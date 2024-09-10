<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;
    public $url;
    public $name;
    /**
     * Create a new message instance.
     */
    public function __construct(String $url)
    {
        $this->url = $url;
    }
    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $name = $notifiable->name;
        $url = $this->url;
        return (new MailMessage)
                    ->from(env('NO_REPLAY_EMAIL', 'no-replay@strategyanalytics.com.br'), 'Equipe Strategy Analytics')
                    ->subject('Redefinir Senha')
                    ->line('Olá, ', $this->name)
                    ->action('Notification Action', $this->url)
                    ->view('mail.users.forgotpassword', compact('name', 'url'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
