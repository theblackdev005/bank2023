<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FeePaidNotification extends Notification
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
        $cost = setCurrency($this->fee->currency, $this->fee->cost);
        $subject = translate_mail_subject(837, false, $cost);

        return (new MailMessage)->subject($subject)->view('emails.customer-fee-paid', [
                "customer"  => $notifiable,
                "subject"   => $subject,
                "cost"      => $cost,
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
