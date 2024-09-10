<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendCodeNotification extends Notification
{
    use Queueable;
    /**
     * Create a new notification instance.
     */
    public function __construct(
        protected String $code)
    {

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
        $code = $this->code;
        return (new MailMessage)
                    ->from(env('NO_REPLAY_EMAIL', 'no-replay@strategyanalytics.com.br'), 'Equipe Strategy Analytics')
                    ->subject('Código de verificação de email')
                    ->line('Olá, ', $name)
                    ->view('mail.users.verifiedemail', compact('name', 'code'));
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
