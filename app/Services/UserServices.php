<?php

namespace App\Services;

use App\Models\Account;

class UserServices
{
    public function getEmailByPerson(string $person)
    {
        $email = Account::with('user')->where('person', $person)->first()->user->email;
        return $email;
    }
}
