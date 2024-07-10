<?php

namespace App\Rules;

use App\Enum\StatusDeposit;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class VerifyStatusDeposit implements ValidationRule
{
    public function __construct(
        protected $status
        // $status
    )
    {
        // $this->status = $status;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if($this->status == StatusDeposit::Rejected->value && $value == null){
            $fail('Você esta rejeitando o deposito, informe o motivo para o cliente, por favor.');
        }
    }
}
