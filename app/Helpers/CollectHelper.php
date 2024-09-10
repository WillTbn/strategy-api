<?php

namespace App\Helpers;

use App\Enum\TransictionStatus;
use App\Models\DepositReceipt;
use App\Models\Investment;
use Illuminate\Support\Collection;

trait CollectHelper
{
    /**
     * dados da transação
    */
    private $trans_data;
    public function getTransDeposit( DepositReceipt $depositReceipt, string $trans_name = 'pix'):Collection
    {
        $this->trans_data = collect([...$depositReceipt->only([
            'transaction_code',
            'investment'
        ])]);
        $this->trans_data['trans_name'] = $trans_name;
        return $this->trans_data;
    }
    public function getTransIncomeUpdate(Investment $perfomance, string $trans_name = 'income'):Collection
    {
        $this->trans_data = collect([...$perfomance->only([
            'name',
            'type'
        ])]);
        $this->trans_data['trans_name'] = $trans_name;
        $this->trans_data['trans_description'] = TransictionStatus::PRDAA->description();
        return $this->trans_data;
    }
}
