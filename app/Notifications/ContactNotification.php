<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactNotification extends Notification
{
    use Queueable;

    private $parameter = [];

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($parameter)
    {
        $this->parameter = $parameter;
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
        $post = $this->parameter;
        extract( $post['message'] );

        return (new MailMessage)->replyTo( $email, $name )
            ->subject($subject)->view('emails.contact-us', [
                "parameter"         => $post,
                "hideCustomerInfo"  => !empty($post['hideCustomerInfo']) ? true : false,
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
