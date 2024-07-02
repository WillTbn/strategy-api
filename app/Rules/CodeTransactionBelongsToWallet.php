<?php

namespace App\Rules;

use App\Models\DepositReceipt;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CodeTransactionBelongsToWallet implements ValidationRule
{
    protected $wallet_id;
    public function __construct(
        $wallet_id
    )
    {
        $this->wallet_id = $wallet_id;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $getDeposit = DepositReceipt::where('transaction_code', $value)->first();
        if(!($getDeposit->user_wallet_id === $this->wallet_id)){
            $fail('Erro, dados inconsistentes...');
        }
    }
}
