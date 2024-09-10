<?php

namespace App\Observers;

use App\Enum\RoleEnum;
use App\Events\Client\InviteClientEvent;
use App\Events\CreateUserAdm;
use App\Models\AccessToken;
use Illuminate\Support\Facades\Log;

class AccessTokenObserver
{
    /**
     * Handle the AccessToken "created" event.
     */
    public function created(AccessToken $accessToken): void
    {
        Log::info('Event created token'.$accessToken);
        if($accessToken->user->role_id == RoleEnum::Master || $accessToken->user->role_id == RoleEnum::Employee){
            Log::info('Event created user admin or employee');
            event(new CreateUserAdm($accessToken));
        }else if($accessToken->user->role_id == RoleEnum::Client){
            Log::info('Event created user client');
            event(new InviteClientEvent($accessToken));
        }
    }

    /**
     * Handle the AccessToken "updated" event.
     */
    public function updated(AccessToken $accessToken): void
    {
        if($accessToken->isDirty('expires_at')){
            if($accessToken->user->role_id == RoleEnum::Master || $accessToken->user->role_id == RoleEnum::Employee)
                Log::info('Event update expires_at user admin');
                event(new CreateUserAdm($accessToken));

        }
    }

    /**
     * Handle the AccessToken "deleted" event.
     */
    public function deleted(AccessToken $accessToken): void
    {
        //
    }

    /**
     * Handle the AccessToken "force deleted" event.
     */
    public function forceDeleted(AccessToken $accessToken): void
    {
        //
    }
}
