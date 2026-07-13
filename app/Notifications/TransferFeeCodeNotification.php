<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TransferFeeCodeNotification extends Notification
{
    use Queueable;

    private $fee;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($fee)
    {
        $this->fee = $fee;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $amount     = setCurrency($this->fee->currency, $this->fee->cost);
        $code       = $this->fee->code;
        $subject    = translate_mail_subject(855, false, $amount);

        return (new MailMessage)->subject($subject)->view('emails.customer-transfer-code', [
                "customer"  => $notifiable,
                "subject"   => $subject,
                "code"      => $code,
                "amount"    => $amount,
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
