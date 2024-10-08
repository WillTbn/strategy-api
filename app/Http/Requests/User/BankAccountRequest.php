<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class BankAccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'bank' => 'required',
            'agency' => 'required',
            'number' => 'required',
            'nickname' => 'string|nullable',
            'main_account' => 'boolean'
        ];
    }
}
