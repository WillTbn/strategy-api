<?php

namespace App\Http\Requests\Report;

use App\Enum\TypeReport;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReportputRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [
            'report_id' => 'exists:reports,id',
            'title' => 'string',
            'description'=>'string',
            'display_date_at'=>'date',
            'type'=>[Rule::enum(TypeReport::class)],
        ];
    }
}
