<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AddTransferRequest;
use App\Models\Transfert as TransfertModel;
use App\Models\TransfertFee;
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
            $amount = floatval( $amount );
            if ( ($customer->balance <= 0) || ($amount > $customer->balance) ) {
                return back_With_Error(53);
            }

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

            # Envoyer une notification
            $customer->sendTransferInitiatedEmailToCustomer($transfert);

            # Set Transaction
            $customer->setTransaction(0, $post['amount'], 95);

            # Convertir le montant en devise
            if ( $crcy = $transfert->pm_currency() ) {
                $transfert->convert_amount = currency_converter( $transfert->currency->name, $amount, $crcy->name );
                $transfert->saveOrFail();
            }

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
                ->firstOrFail();

            if ( $loadsection = compareTimer( $lastPaidFee->load_at ) ) {
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
            ->firstOrFail();
        
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
