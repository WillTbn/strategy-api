<?php

namespace App\DataTransferObject\UserAdm;

use App\DataTransferObject\AbstractDTO;
use App\DataTransferObject\InterfaceDTO;
use App\Enum\NotificationEnum;
use App\Enum\RoleEnum;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class UseradmDTO extends AbstractDTO implements InterfaceDTO
{
    public readonly string $password;
    public readonly string $password_confirm;
    public function __construct(
        public readonly ?string  $name =null,
        public readonly ?string  $email =null,
        // public readonly ?string  $password =null,
        public readonly ?int  $role_id =null,
        public readonly ?string  $person =null,
        public readonly ?string  $birthday =null,
        public readonly ?string  $notifications =null,
        public readonly ?string  $type_of_investor =null,
        public readonly ?string  $telephone =null,
        public readonly ?string  $phone =null,
        public readonly ?string  $genre =null,
        public readonly ?string  $address_street =null,
        public readonly ?string  $address_state =null,
        public readonly ?string  $address_number =null,
        public readonly ?string  $address_district =null,
        public readonly ?string  $address_zip_code =null,
        public readonly ?string  $address_city =null,
        public readonly ?string  $address_country =null,
    )
    {
        $random_passwrod = Str::random(8);
        $this->password = $random_passwrod;
        $this->password_confirm =  $this->password;
        $this->validate();
    }
    public function getBirthday() :Carbon
    {
        return Carbon::parse($this->birthday);
    }
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:4|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'person' => 'required|unique:accounts',
            'birthday' =>'required|date_format:d-m-Y',
            'notifications'=> ['required', Rule::enum(NotificationEnum::class)],
            'telephone' => 'string',
            'phone' => 'string',
            'genre' => 'in:M,W,L',
            'address_street' =>'string',
            'address_state' =>'string',
            'address_number' =>'string',
            'address_district' =>'string',
            'address_zip_code' =>'string',
            'address_city' =>'string',
            'address_country' =>'string',
            'role_id' =>[
                'required',
                Rule::enum(RoleEnum::class)
            ]
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
