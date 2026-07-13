<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\TransfertFee;
use Carbon\Carbon;

class TransferPaymentForm extends Component
{
    public $loadsection;
    public $pending_fee;
    public $customer;
    public $pending_transfert;
    public $transfer_code = [];
    public $form_error_msg = null;

    public function mount($loadsection, $pending_fee, $pending_transfert)
    {
        $this->loadsection          = $loadsection;
        $this->customer             = customer();
        $this->pending_fee          = $pending_fee;
        $this->pending_transfert    = $pending_transfert;

        for ($i=1; $i <= TRANSFER_CODE_LENGTH; $i++) { 
            $this->transfer_code['otp_' . $i] = null;
        }
    }

    public function submit_transfer_code()
    {
        $this->form_error_msg = null;
        $customer = customer();
        
        try {

            $this->validate([
                'transfer_code'     => ['required', 'array', 'size: ' . TRANSFER_CODE_LENGTH],
                'transfer_code.*'   => ['required', 'integer', 'digits:1']
            ]);
            $code = implode("", $this->transfer_code);

            $fee = TransfertFee::whereId($this->pending_fee->id)
                ->whereTransfertId($this->pending_transfert->id)
                ->whereCode($code)
                ->firstOrFail();

            $delay = intval($fee->load_delay);
            if ( !$fee || ($delay <= 0) ) {
                throw new \Exception(translate(57));
            }

            # Frais de Transfert
            $fee->payed_at  = Carbon::now();
            $fee->load_at   = Carbon::now()->addSeconds( $delay );
            $fee->saveOrFail();

            # Pending Transfert
            if ($fee->percentage >= 100) {
                $this->pending_transfert->completed_at = now();
                $this->pending_transfert->saveOrFail();
            }

            # Envoyer une notification de paiement
            $customer->sendFeePaidNotificationToCustomer($fee);

            # Set Transaction
            $customer->setTransaction(2, $fee->cost, 546, $fee->currency);

            # Email à l'administrateur
            if ( $customer->admin ) {
                $customer->admin->sendCustomerActivityToAdmin([
                    'title'     => $customer->fullname() . " - Frais payé !",
                    'message'   => "Vient de confirmer le paiement d'un frais !",
                ]);
            }

            return redirect(routeWithLocale('customer.show_transfert'));
            
        } catch (\Exception $e) {
            $this->form_error_msg = translate(57);
        }
    }

    public function render()
    {
        return view('livewire.transfer-payment-form');
    }
}
