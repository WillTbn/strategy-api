<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'document' => 'required|file|mimes:pdf|max:2048',
            'title' => 'string|required',
            'description'=>'string',
            'audio' =>[
                'required',
                'file',
                'mimes:audio/aac,audio/aiff,audio/amr,audio/flac,audio/m4a,audio/ogg,audio/opus,audio/wav,audio/wma',
                'max:59240', // 59MB em kilobytes
            ],
        ];
    }
}
