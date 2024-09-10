<?php

namespace App\Rules;

use App\Models\UserWallet;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class WalletBelongsToUser implements ValidationRule
{
    protected $user_id;
    public function __construct(
        $user_id
    )
    {
        $this->user_id = $user_id;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(!UserWallet::where('id', $value)->where('user_id', $this->user_id)->exists()){
            $fail('Erro, dados inconsistentes...');
        }
    }
}
