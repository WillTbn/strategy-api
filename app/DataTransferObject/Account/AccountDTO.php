<?php

namespace App\DataTransferObject\Account;

use App\DataTransferObject\AbstractDTO;
use App\DataTransferObject\InterfaceDTO;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rules\Password;

class AccountDTO extends AbstractDTO implements InterfaceDTO
{
    public function __construct(
        public readonly ?string  $name =null,
        // public readonly ?string  $password =null,
        public readonly ?string  $birthday =null,
        public readonly ?string  $notifications =null,
        public readonly ?string  $type_of_investor =null,
        public readonly ?string  $telephone =null,
        public readonly ?string  $phone =null,
        public readonly ?string  $genre =null,
        public readonly ?string  $address_street ="",
        public readonly ?string  $address_state ="",
        public readonly ?string  $address_number ="",
        public readonly ?string  $address_district ="",
        public readonly ?string  $address_zip_code ="",
        public readonly ?string  $address_city ="",
        public readonly ?string  $address_country ="",
    )
    {
        $this->validate();
    }
    public function rules(): array
    {
        return [
        ];
    }
    public function messages(): array
    {
        return[];
    }
    public function validator(): Validator
    {
        return validator($this->toArray(), $this->rules(), $this->messages());
    }
    public function validate():array
    {
        return $this->validator()->validate();
    }
}
