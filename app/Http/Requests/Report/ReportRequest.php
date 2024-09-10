<?php

namespace App\Http\Requests\Report;

use App\Enum\TypeReport;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReportRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'document' => 'required|file|mimes:pdf|max:59240',
            'title' => 'string|required',
            'description'=>'string',
            'type'=>['required', Rule::enum(TypeReport::class)],
            'display_date_at' =>'date_format:d-m-Y',
            'audio' =>[
                'mimes:audio/aac,audio/aiff,audio/amr,audio/flac,audio/m4a,audio/ogg,audio/opus,audio/wav,audio/wma,audio/.mp3,mp3',
                'max:59240', // 59MB em kilobytes
            ],
        ];
    }
}
