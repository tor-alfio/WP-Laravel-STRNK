<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Reset della password Strnk')
            ->greeting('Ciao ' . $notifiable->username . '!')
            ->line('Hai richiesto il reset della password.')
            ->action('Reset Password', url('/password/reset/' . $this->token . '?email=' . urlencode($notifiable->email)))
            ->line('Se non hai richiesto tu questo reset, ignora questa email.');
    }
}
