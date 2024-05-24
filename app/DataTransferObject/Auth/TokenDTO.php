<?php

namespace App\DataTransferObject\Auth;

use App\DataTransferObject\AbstractDTO;
use App\DataTransferObject\InterfaceDTO;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rules\Password;

class TokenDTO extends AbstractDTO implements InterfaceDTO
{
    public function __construct(
        public readonly ?string  $token =null,
        public readonly ?string  $person =null,
        public readonly ?string  $password =null,
        public readonly ?string  $password_confirm =null,
    )
    {
        $this->validate();
    }
    public function rules(): array
    {
        return [
            'token' => 'required|string|exists:access_tokens',
            'person' => 'required|exists:accounts',
            'password' =>['required', Password::min(8)->mixedCase()->numbers()->symbols()  ],
            'password_confirm' =>'required|same:password',

        ];
    }
    public function messages(): array
    {
        return[
            'person.exists' => 'Campo CPF, invalido!'
        ];
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
