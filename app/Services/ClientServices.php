<?php

namespace App\Services;

use App\Enum\RoleEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ClientServices
{
    public function get(int $user):User
    {
        $response  = User::where('id', $user)->with(['account', 'userWallet', 'userBankAccounts'])->first();
        return $response;
    }
    public function getAll():Collection
    {
        $response = DB::table('users')
        ->join('accounts', 'accounts.user_id', '=', 'users.id')
        ->join('user_wallets', 'user_wallets.user_id', '=', 'users.id')
        ->select(
            'users.id',
            'users.name',
            'users.email',
            DB::raw('CONCAT("'.env("APP_URL").'",accounts.avatar) as avatar'),
            'accounts.notifications as notification',
            DB::raw('DATE_FORMAT(accounts.birthday, "%d/%m/%Y") as birthday'),
            'user_wallets.current_balance as balance',
            'user_wallets.current_loan as loan',
            'user_wallets.current_investment as investment',
        )
        ->groupBy(
            'users.id',
            'users.name',
            'users.email',
            'accounts.avatar',
            'accounts.notifications',
            'accounts.birthday',
            'user_wallets.current_balance',
            'user_wallets.current_loan',
            'user_wallets.current_investment'
        )
        ->where('role_id', RoleEnum::Client)
        ->get();
        return $response;
    }
}
