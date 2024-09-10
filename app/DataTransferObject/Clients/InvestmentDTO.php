<?php

namespace App\DataTransferObject\Clients;

use App\DataTransferObject\AbstractDTO;
use App\DataTransferObject\InterfaceDTO;
use App\Services\InvestmentServices;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class InvestmentDTO extends AbstractDTO implements InterfaceDTO
{
    public function __construct(
        public readonly ?int  $user_id =null,
        public readonly ?int  $investment_id =null,
        private InvestmentServices $investmentServices,
    )
    {
        $this->validate();
    }
    public function getInvestment()
    {
        return $this->investment_id != null ?  $this->investment_id : $this->investmentServices->getInitialId();
    }
    public function rules(): array
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'investment_id' => '',
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
