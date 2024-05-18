<?php

namespace App\Listeners;

use App\Enum\RoleEnum;
use App\Events\CreateUserAdm;
use App\Mail\SetEmailRegistreAdm;
use App\Mail\SetEmailRegistreEmployee;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmailWelcomeAdm
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
    public function handle(CreateUserAdm $event): void
    {
        $user = $event->access->user;
        if($user->role_id == RoleEnum::Master){
            Log::info('Enviar email para o usuário permissão Master ');
            Mail::to(env('CONTRACT_EMAIL', 'no_env_contract@strategyanalitycs.com.br'))->send(new SetEmailRegistreAdm($user, $event->access->token));
        }else if($user->role_id == RoleEnum::Employee){
            Log::info('Enviar email para o usuário permissão Funcionario ');
            Mail::to(env('CONTRACT_EMAIL', 'no_env_contract@strategyanalitycs.com.br'))->send(new SetEmailRegistreEmployee($user, $event->access->token));
        }
    }
}
