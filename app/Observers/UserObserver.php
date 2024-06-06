<?php

namespace App\Observers;

use App\Enum\RoleEnum;
use App\Events\CreateUserAdm;
use App\Events\User\CreatedClientUser;
use App\Helpers\FileHelper;
use App\Models\EmailVerifiedUser;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserObserver
{
    use FileHelper;
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        // if($user->role_id == RoleEnum::Client)
        //     event(new CreatedClientUser($user));

    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        // tem que tira isso daqui
        if($user->isDirty('avatar') && $user->getOriginal('avatar')){
            $file = $this->getNameFile($user->getOriginal('avatar'));
            Storage::disk('public')->delete($file);
        }
        if($user->isDirty('email_verified_at')){
            $veri = EmailVerifiedUser::where('user_id', $user->id)->first();
            if($veri){
                $veri->delete();
            }
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
