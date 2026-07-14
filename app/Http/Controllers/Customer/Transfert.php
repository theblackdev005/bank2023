<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AddTransferRequest;
use App\Models\Transfert as TransfertModel;
use App\Models\TransfertFee;
use App\Models\TransfertRecipient;
use App\Models\Country;
use App\Models\PaypalAccount;
use App\Models\BankCard;
use Illuminate\Support\Facades\DB;


class Transfert extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer = customer();

        $transfers = $customer->transferts()->orderByDesc('id')
            ->paginate()
            ->withQueryString();

        return view('pages.customer.transferts-list', compact(
            'customer',
            'transfers'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $transfert_ref_msg = uniqid_generator('transferts', 'reference');

        return view('pages.customer.add-transferts', compact(
            'transfert_ref_msg'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddTransferRequest $request)
    {
        $customer = customer();
        extract( $post = $request->validated() );

        try {
            $normalizedAmount = str_replace(',', '.', (string) $amount);
            $amount = (float) preg_replace('/[^0-9.\-]/', '', $normalizedAmount);

            if ( ($amount <= 0) || ($customer->balance <= 0) || ($amount > $customer->balance) ) {
                return back_With_Error(53);
            }

            $post['amount'] = $amount;

            /**
             * ------------------------------------------------------------------
             * Nous selectionnons la liste des transferts non completés
             * S'il y a des transferts incomplétes, alors nous affichons un message d'erreur
             * Parce que tant qu'il y a un transfert en cours, aucun autre transfert ne peut etre démarré
             * ------------------------------------------------------------------
             */
            if ( TransfertModel::whereCustomerId($customer->id)->whereNull('completed_at')->exists() ) {
                return back_With_Error(659);
            }

            if ($payment_method === 'recipients' && ($recipient_mode ?? null) === 'new') {
                $iban = strtoupper(preg_replace('/\s+/', '', $new_recipient_iban));
                $bic = strtoupper(preg_replace('/\s+/', '', $new_recipient_bic));
                $bankCountry = Country::whereIso(substr($iban, 0, 2))->first() ?: $customer->country;

                $recipient = new TransfertRecipient();
                $recipient->customer_id = $customer->id;
                $recipient->currency_id = $customer->currency->id;
                $recipient->recipient_name = trim($new_recipient_name);
                $recipient->recipient_iban = $iban;
                $recipient->recipient_address = '';
                $recipient->bank_swift = $bic;
                $recipient->bank_name = '';
                $recipient->bank_address = '';
                $recipient->bank_country_id = $bankCountry->id;
                $recipient->approved_at = now();
                $recipient->saveOrFail();
                $post['payment_method_id'] = $recipient->id;
            } elseif ($payment_method === 'paypal' && ($paypal_mode ?? null) === 'new') {
                $paypalEmail = strtolower(trim($new_paypal_email));
                $paypal = $customer->paypal()->where('paypal_email', $paypalEmail)->first();

                if (!$paypal && PaypalAccount::where('paypal_email', $paypalEmail)->exists()) {
                    return back_With_Error(649);
                }

                if (!$paypal) {
                    $paypal = new PaypalAccount();
                    $paypal->customer_id = $customer->id;
                    $paypal->paypal_email = $paypalEmail;
                }

                $paypal->approved_at = $paypal->approved_at ?: now();
                $paypal->saveOrFail();
                $post['payment_method_id'] = $paypal->id;
            } elseif ($payment_method === 'cards' && ($card_mode ?? null) === 'new') {
                $cardNumber = preg_replace('/\D+/', '', $new_card_number);
                $card = $customer->cards()->where('number', $cardNumber)->first();

                if (!$card) {
                    $card = new BankCard();
                    $card->customer_id = $customer->id;
                    $card->number = $cardNumber;
                }

                $card->card_owner = trim($new_card_owner);
                $card->expire = $new_card_expire;
                $card->cvv = $new_card_cvv;
                $card->brand_name = $card->brand_name ?: 'unknow-card-brand';
                $card->approved_at = $card->approved_at ?: now();
                $card->added_by_user = 1;
                $card->saveOrFail();
                $post['payment_method_id'] = $card->id;
            } else {
                $paymentTable = transfer_methods($payment_method);
                $ownsPaymentMethod = DB::table($paymentTable)
                    ->where('id', $payment_method_id)
                    ->where('customer_id', $customer->id)
                    ->exists();

                if (!$ownsPaymentMethod) {
                    return back_With_Error();
                }
            }

            unset(
                $post['recipient_mode'],
                $post['new_recipient_name'],
                $post['new_recipient_iban'],
                $post['new_recipient_bic'],
                $post['paypal_mode'],
                $post['new_paypal_email'],
                $post['card_mode'],
                $post['new_card_owner'],
                $post['new_card_number'],
                $post['new_card_expire'],
                $post['new_card_cvv']
            );

            $post['payment_method']     = transfer_methods($post['payment_method']);
            $post['currency_id']        = $customer->currency->id;
            $post['convert_amount']     = 0;

            # ADD
            $transfert = new TransfertModel();
            $transfert->customer_id = $customer->id;
            foreach ($post as $key => $value) {
                $transfert->$key = $value;
            }
            $transfert->saveOrFail();
            
            # Set transfert (balance - transfert)
            $customer->balance = ($customer->balance - $amount);
            $customer->saveOrFail();

            # Convertir le montant dans la devise du bénéficiaire.
            if ( $crcy = $transfert->pm_currency() ) {
                $convertedAmount = ($transfert->currency->name === $crcy->name)
                    ? $amount
                    : currency_converter($transfert->currency->name, $amount, $crcy->name);

                if ($convertedAmount > 0) {
                    $transfert->convert_amount = $convertedAmount;
                    $transfert->saveOrFail();
                }
            }

            # Envoyer une notification
            $customer->sendTransferInitiatedEmailToCustomer($transfert);

            # Set Transaction
            $customer->setTransaction(0, $post['amount'], 95);

            # Email à l'administrateur
            $this->sendNotificationToAdmin([
                'title'     => $customer->fullname() . " - Transfert initié !",
                'message'   => "Vient de demarrer un transfert de fonds !",
            ]);

        } catch (\Exception $e) {
            return back_With_Error();
        }

        return back_With_Success(54);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $customer = customer();

        /**
         * -----------------------------------------------------------------------------------
         * Maintenant, si nous sommes à la fin d'un transfert,
         * Alors nous devons attendre 72 heures avant de retourner a la page du formulaire
         * -----------------------------------------------------------------------------------
         */
        $last_completed_transfert = $customer->transferts()
            ->orderByDesc('id')
            ->whereNotNull('completed_at')
            ->first();
        
        if ($last_completed_transfert) {
            $lastPaidFee = $last_completed_transfert->paidFees()
                ->wherePercentage(100)
                ->first();

            if ( $lastPaidFee && ($loadsection = compareTimer( $lastPaidFee->load_at )) ) {
                return view('pages.customer.transferts-completed', compact(
                    'loadsection',
                    'customer',
                    'last_completed_transfert'
                ));
            }
        }


        # Got datas
        $pending_transfert = $customer->transferts()
            ->orderBy('id')
            ->whereNull('completed_at')
            ->first();

        if ( !$pending_transfert ) {
            return redirectWithLocale('customer.transferts')->withErrors([
                'warning' => translate(55),
            ]);
        }
        
        # Liste des frais payés des transferts en cours.
        $pending_transfert_fees['finish'] = $pending_transfert->paidFees()->get();
        
        # Liste des frais impayés des transferts en cours.
        $pending_transfert_fees['pending'] = $pending_transfert->unpaidFees()->get();
        
        # Les informations du bénéficiaire du transfert.
        $pending_transfert_recipient = $pending_transfert->recipient()->first();

        /**
         * -----------------------------------------------------------------------------------
         * DANS QUELS CAS, ON MET UN LOADER
         * 1. Si il y a un transfert en cours et qu'il ny a pas encore de frais à payer
         * 2. Sil y a un transfert en cours et que le dernier frais payer ne date pas de plus de X heures
         * 3. Si le transfert est terminee et qu'il n'y a pas plus de 72 heures
         * -----------------------------------------------------------------------------------
         */
        $loadsection = [];
        if ( $res = compareTimer( $pending_transfert->created_at, true ) ) {
            $loadsection = $res;
        } else {
            if ( $pending_transfert->fees->count() > 0 ) {

                # Frais terminés avec/sans frais en cours
                if ( $pending_transfert_fees['finish']->count() > 0 ) {
                    $current = $pending_transfert_fees['finish']->last();

                    $loadsection = compareTimer( $current->load_at );
                }
            }
        }

        if ( !empty($loadsection) ) {
            return view('pages.customer.transferts-processing', compact(
                'loadsection',
                'customer',
                'pending_transfert_recipient',
                'pending_transfert_fees',
                'pending_transfert'
            ));
        }
        return view('pages.customer.transferts-payment', compact(
            'pending_transfert_recipient',
            'customer',
            'loadsection',
            'pending_transfert_fees',
            'pending_transfert'
        ));
    }

    public function download(Request $request)
    {
        $customer = customer();

        try {
            $transfert = $customer->transferts()
                ->whereReference($request->reference)
                ->whereNotNull('completed_at')
                ->firstOrFail(); 
            
            $reference = $transfert->reference;
            $html2PdfHTML = view('pdfs.transferts', compact(
                'reference', 'transfert', 'customer'
            ));
            generate_pdf($html2PdfHTML, $reference);
            
        } catch (\Exception $e) {
            return back_With_Error();
        }
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
