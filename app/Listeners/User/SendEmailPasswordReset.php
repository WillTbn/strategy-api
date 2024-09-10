<?php

namespace App\Listeners\User;

use App\Events\User\PasswordReset;
use App\Mail\User\PasswordResetMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmailPasswordReset
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PasswordReset $event): void
    {
        Log::info('Enviando e-mail para usuário informando que ele resetou com sucesso a senha!'.json_encode($event->user));
        Mail::to($event->user->email, $event->user->name)->send(new PasswordResetMail($event->user));
    }
}
