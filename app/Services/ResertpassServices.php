<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;

class ResertpassServices
{

    public function create(User $user)
    {
        $tokenReset = new PasswordReset($user);
    }

}
