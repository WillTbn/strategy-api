<?php

namespace App\Http\Requests;

use App\Enum\NotificationEnum;
use App\Enum\RoleEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // [Rule::enum(TypeReport::class)]
        return [
            'name' => 'required|string|min:4|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'person' => 'required|unique:accounts',
            'birthday' =>'required|date_format:d-m-Y',
            'Notifications'=> ['required', Rule::enum(NotificationEnum::class)],
            'type_of_investor' =>'string',
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
}
