<?php

namespace App\Models\Repository;

use App\DataTransferObject\Users\UserBankAccountDTO;
use App\Models\UserBankAccount;


interface UserBankRepository
{
    // public function all():int|Collection;
    // public function getByEmail(string $email):?User;
    public function update(UserBankAccountDTO $accountDto, UserBankAccount $account):UserBankAccount;
}
