<?php

namespace App\Services;

use App\Models\DepositReceipt;

class DepositReceiptServices
{
    public function getByWallet(int $user_wallet):DepositReceipt
    {
        $deposit =
        DepositReceipt::where('user_wallet_id', $user_wallet)->first();
        return $deposit;

    }
}
