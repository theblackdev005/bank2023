<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class IdentityVerifiedNotification extends Notification
{
    use Queueable;

    private $rib;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($rib)
    {
        $this->rib = $rib;
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
        $subject = translate(788);

        return (new MailMessage)->subject($subject)->view('emails.customer-identity-verified', [
                        "customer"  => $notifiable,
                        "subject"   => $subject,
                        "rib"       => $this->rib,
                        "amount"    => setCurrency($this->rib->currency, $this->rib->amount),
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
