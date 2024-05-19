<?php

namespace App\Services;

use App\Models\Account;
use Illuminate\Database\Eloquent\Collection;

class AccountServices
{
    public function getByPerson(string $person):Account
    {
        $accountPerson = Account::where('person', $person)->first();
        return $accountPerson;
    }
}
