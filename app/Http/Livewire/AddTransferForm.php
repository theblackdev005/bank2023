<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\PaypalAccount;

class AddTransferForm extends Component
{

    public $transfert_ref_msg;
    public $customer;
    public $cards;
    public $paypals;
    public $recipients;
    public $recipientMode = 'new';

    public $currentTab = 'cards';

    # PAYPAL PROCESSING
    public $chooseOrAddPpl = 1;
    public $paypal_email;
    public $paypal_form_spinner = false;
    public $paypal_form_error = false;
    public $paypal_form_error_msg = null;

    public $newBalance = 0;
    public $balance_typing = null;
    public $balanceTypingError = false;

    public function mount($transfert_ref_msg)
    {
        $this->transfert_ref_msg = $transfert_ref_msg;
        $this->customer = customer();
        $this->newBalance = (float) $this->customer->balance;
        $this->currentTab = old('payment_method', $this->currentTab);
        $this->recipientMode = old('recipient_mode', $this->recipientMode);

        $this->paypals = $this->retreivePaypal();
        $this->cards = $this->customer->cards()->get();
        $this->recipients = $this->customer->recipients()->whereNotNull('approved_at')->get();
    }

    private function initPaypalVars()
    {
        $this->paypal_form_spinner = false;
        $this->paypal_form_error = false;
        $this->paypal_form_error_msg = null;
    }

    public function addPaypalAccount()
    {
        $this->initPaypalVars();

        try {
            if ( !$this->paypal_email || !filter_var($this->paypal_email, FILTER_VALIDATE_EMAIL) ) {
                throw new \Exception(translate(643));
            }

            if ( PaypalAccount::wherePaypalEmail($this->paypal_email)->exists() ) {
                throw new \Exception(translate(649));
            }

            $paypal = new PaypalAccount();
            $paypal->customer_id = $this->customer->id;
            $paypal->paypal_email = $this->paypal_email;

            # Marqué chaque nouveau compte paypal comme vérifié
            if ( intval(AUTO_VERIFY_NEW_PAYPAL_ACCOUNT) === 1 ) {
                $paypal->approved_at = now();
            }

            $paypal->saveOrFail();

            # Set Transaction
            $paypal->customer->setTransaction(2, 0, 689);

            $this->paypal_email = null;
            $this->initPaypalVars();

        } catch (\Exception $e) {
            $this->paypal_form_spinner = false;
            $this->paypal_form_error = true;
            $this->paypal_form_error_msg = $e->getMessage();
        }
    }

    public function updateBalanceAfterTyping()
    {
        $typedAmount = str_replace(',', '.', (string) $this->balance_typing);
        $typedAmount = (float) preg_replace('/[^0-9.\-]/', '', $typedAmount);
        $subs = (float) $this->customer->balance - max(0, $typedAmount);

        if ( $subs < 0 ) {
            $this->newBalance = 0;
            $this->balanceTypingError = true;
        } else {
            $this->balanceTypingError = false;
            $this->newBalance = $subs;
        }
    }

    public function updatedBalanceTyping()
    {
        $this->updateBalanceAfterTyping();
    }

    public function retreivePaypal()
    {
        $this->initPaypalVars();
        $this->paypals = $this->customer->paypal()->get();
    }

    public function render()
    {
        return view('livewire.add-transfer-form');
    }
}
