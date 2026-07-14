<?php

namespace App\Http\Livewire;

use Livewire\Component;
class AddTransferForm extends Component
{

    public $transfert_ref_msg;
    public $customer;
    public $cards;
    public $paypals;
    public $recipients;
    public $recipientMode = 'new';
    public $cardMode = 'new';
    public $paypalMode = 'new';

    public $currentTab = 'recipients';

    public $newBalance = 0;
    public $balance_typing = null;
    public $balanceTypingError = false;

    public function mount($transfert_ref_msg)
    {
        $this->transfert_ref_msg = $transfert_ref_msg;
        $this->customer = customer();
        $this->newBalance = (float) $this->customer->balance;

        $availableMethods = [];
        if (ALLOW_WITHDRAWALS_TO_BANK) {
            $availableMethods[] = 'recipients';
        }
        if (ALLOW_WITHDRAWALS_TO_CARD) {
            $availableMethods[] = 'cards';
        }
        if (ALLOW_WITHDRAWALS_TO_PAYPAL) {
            $availableMethods[] = 'paypal';
        }

        $requestedMethod = old('payment_method');
        $this->currentTab = in_array($requestedMethod, $availableMethods, true)
            ? $requestedMethod
            : ($availableMethods[0] ?? 'recipients');
        $this->paypals = $this->customer->paypal()->whereNotNull('approved_at')->get();
        $this->cards = $this->customer->cards()->whereNotNull('approved_at')->get();
        $this->recipients = $this->customer->recipients()->whereNotNull('approved_at')->get();

        $this->recipientMode = old('recipient_mode', $this->recipientMode);
        $this->cardMode = old('card_mode', $this->cards->count() ? 'existing' : 'new');
        $this->paypalMode = old('paypal_mode', $this->paypals->count() ? 'existing' : 'new');
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

    public function render()
    {
        return view('livewire.add-transfer-form');
    }
}
