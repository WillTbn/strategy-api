<?php

namespace App\Observers;

use App\Models\UserWallet;

class UserWalletObserver
{
    /**
     * Handle the UserWallet "created" event.
     */
    public function created(UserWallet $userWallet): void
    {
        //
    }

    /**
     * Handle the UserWallet "updated" event.
     */
    public function updated(UserWallet $userWallet): void
    {
        //
    }

    /**
     * Handle the UserWallet "deleted" event.
     */
    public function deleted(UserWallet $userWallet): void
    {
        //
    }

    /**
     * Handle the UserWallet "restored" event.
     */
    public function restored(UserWallet $userWallet): void
    {
        //
    }

    /**
     * Handle the UserWallet "force deleted" event.
     */
    public function forceDeleted(UserWallet $userWallet): void
    {
        //
    }
}
