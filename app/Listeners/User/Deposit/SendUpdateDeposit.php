<?php

namespace App\Listeners\User\Deposit;

use App\Enum\StatusDeposit;
use App\Events\User\Deposit\UpdatedStatusDeposit;
use App\Mail\User\Deposit\ConfirmDepositMail;
use App\Mail\User\Deposit\RejectedDepositMail;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendUpdateDeposit
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
    public function handle(UpdatedStatusDeposit $event): void
    {
        $user = $event->transactionData->userWallet->user;
        $data_created = Carbon::parse($event->transactionData->created_at);
        if($event->transactionData->status == StatusDeposit::Confirmed){
            Log::info('Enviar email para usuário avisando o status aceito da deposito');
            Mail::to($user->email)->send(new ConfirmDepositMail($user, $data_created->format('d/m/Y')));
        }else
        {
            // inicialmente fazendo mesmo procedimento para ambos staus REjected e Wainting
            // if($event->transactionData->status == StatusDeposit::Rejected)
            Mail::to($user->email)->send(new RejectedDepositMail($user, $data_created->format('d/m/Y'), $event->transactionData));
        }
    }
}
