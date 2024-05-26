<?php

namespace App\Listeners\User;

use App\Events\User\CreatedClientUser;
use App\Mail\User\WelcomeClientMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailWelcomeClient
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
    public function handle(CreatedClientUser $event): void
    {
        Mail::to(env('NO_REPLAY_EMAIL', 'no-replay@strategyanalytics.com.br'))->send(new WelcomeClientMail($event->user));
    }
}
