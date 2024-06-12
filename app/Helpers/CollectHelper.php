<?php

namespace App\Helpers;

use App\Models\DepositReceipt;
use Illuminate\Support\Collection;

trait CollectHelper
{
    public function getTransDeposit( DepositReceipt $depositReceipt, string $trans_name):Collection
    {
        $trans_data = collect([...$depositReceipt->only([
            'transaction_id',
            'investment'
        ])]);
        $trans_data['trans_name'] = 'pix';
        return $trans_data;
    }
}
