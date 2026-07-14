<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomerTemporaryPasswordNotification extends Notification
{
    private $temporaryPassword;

    public function __construct(string $temporaryPassword)
    {
        $this->temporaryPassword = $temporaryPassword;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(translate(725))
            ->view('emails.customer-temporary-password', [
                'customer' => $notifiable,
                'temporaryPassword' => $this->temporaryPassword,
            ]);
    }
}
