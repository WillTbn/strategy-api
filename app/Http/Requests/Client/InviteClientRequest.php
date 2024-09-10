<?php

namespace App\Http\Requests\Client;

use App\Enum\NotificationEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InviteClientRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
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
            'address_number' =>'int',
            'address_district' =>'',
            'address_zip_code' =>'',
            'address_city' =>'',
            'address_country' =>'',
            'current_balance' => 'numeric',
            'last_month'=>'numeric',
            'type_of_investor'=>''
        ];
    }
}
