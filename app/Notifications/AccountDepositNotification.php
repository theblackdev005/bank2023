<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountDepositNotification extends Notification
{
    private $transaction;

    public function __construct($transaction)
    {
        $this->transaction = $transaction;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $currency = $this->transaction->currency ?: $notifiable->currency;
        $suffix = $currency ? ($currency->symbol ?: $currency->name) : '';

        return (new MailMessage)
            ->subject(translate(1269))
            ->view('emails/customer-account-deposit', [
                'customer' => $notifiable,
                'amount' => trim(number_format((float) $this->transaction->cost, 2, ',', ' ') . ' ' . $suffix),
                'balanceAfter' => trim(number_format((float) $this->transaction->balance_after, 2, ',', ' ') . ' ' . $suffix),
                'transaction' => $this->transaction,
                'timezone' => customer_timezone($notifiable),
            ]);
    }
}
