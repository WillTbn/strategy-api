<?php

namespace App\Rules;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidateAge implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail):void
    {
        $dateBirth = Carbon::parse($value);
        $miniAge = Carbon::now()->subYears(18);

        if($dateBirth->gte($miniAge)){
            $fail('Só permitido maiores de 18 anos.');
        };
    }
}
