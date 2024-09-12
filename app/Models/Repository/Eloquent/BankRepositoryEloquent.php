<?php
namespace App\Models\Repository\Eloquent;


use App\DataTransferObject\Users\UserBankAccountDTO;

use App\Models\Repository\UserBankRepository;
use App\Models\UserBankAccount;
use Illuminate\Support\Facades\DB;

class BankRepositoryEloquent implements UserBankRepository
{
    public function update(UserBankAccountDTO $bankDto, UserBankAccount $accountBank): UserBankAccount
    {
        DB::transaction(function () use ($bankDto, $accountBank) {
            if ($bankDto->getMainAccount()) {
                UserBankAccount::where('user_id', $accountBank->user_id)
                    ->update(['main_account' => false]);
            }
            // $accountBank = new UserBankAccount();
            $accountBank->bank = $bankDto->getBank();
            $accountBank->agency = $bankDto->getAgency();
            $accountBank->number = $bankDto->getNumber();
            $accountBank->nickname = $bankDto->getNickname();
            $accountBank->main_account = $bankDto->getMainAccount();
            $accountBank->updateOrFail();
        });
        return $accountBank;
    }
}
