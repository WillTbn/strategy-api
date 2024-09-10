<?php

namespace App\DataTransferObject\Register;

use App\DataTransferObject\AbstractDTO;
use App\DataTransferObject\InterfaceDTO;
use App\Enum\NotificationEnum;
use App\Enum\RoleEnum;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class RegisterDTO extends AbstractDTO implements InterfaceDTO
{
    public function __construct(
        public readonly ?string  $name =null,
        public readonly ?string  $email =null,
        // public readonly ?string  $password =null,
        public readonly ?string  $person =null,
        public readonly ?string  $birthday =null,
        public readonly ?string  $notifications =null,
        public readonly ?string  $type_of_investor =null,
        public readonly ?string $password=null,
        public readonly ?string $password_confirmation=null,
        public readonly ?string  $telephone =null,
        public readonly ?string  $phone =null,
        public readonly ?string  $genre =null,
        public readonly ?string  $address_street ="",
        public readonly ?string  $address_state ="",
        public readonly ?string  $address_numbers ="",
        public readonly ?string  $address_district ="",
        public readonly ?string  $address_zip_code ="",
        public readonly ?string  $address_city ="",
        public readonly ?string  $address_country ="",
    )
    {
        $this->validate();
    }
    public function getRole():RoleEnum
    {
        return RoleEnum::Client;
    }
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:4|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'person' => 'required|unique:accounts',
            'birthday' =>'required|date_format:Y-m-d',
            'notifications'=> ['required', Rule::enum(NotificationEnum::class)],
            'telephone' => '',
            'phone' => 'string',
            'genre' => 'in:M,W,L,O',
            'address_street' =>'',
            'address_state' =>'',
            'address_number' =>'',
            'address_district' =>'',
            'address_zip_code' =>'',
            'address_city' =>'',
            'address_country' =>'',
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
