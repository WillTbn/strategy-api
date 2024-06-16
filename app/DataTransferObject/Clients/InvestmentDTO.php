<?php

namespace App\DataTransferObject\Clients;

use App\DataTransferObject\AbstractDTO;
use App\DataTransferObject\InterfaceDTO;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class InvestmentDTO extends AbstractDTO implements InterfaceDTO
{
    public function __construct(
        public readonly ?int  $user_id =null,
        public readonly ?int  $investment_id =null
    )
    {
        $this->validate();
    }
    // public function getRole():RoleEnum
    // {
    //     return RoleEnum::Client;
    // }
    public function rules(): array
    {
        return [
            'user_id' => 'required|integer|exists:users',
            'investment_id' => 'required|integer|exists:investments',
            // 'person' => 'required|unique:accounts',
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
