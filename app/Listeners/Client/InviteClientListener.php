<?php

namespace App\Listeners\Client;

use App\Events\Client\InviteClientEvent;
use App\Mail\Client\SendFirstAccessClient;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class InviteClientListener
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
    public function handle(InviteClientEvent $event): void
    {
        $user = $event->access->user;
        Mail::to('joorge.will@gmail.com')->send(new SendFirstAccessClient($user, $event->access->token));
    }
}
