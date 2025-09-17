<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmissionRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'content' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,zip,txt,rtf,mp4,mov|max:51200', // 50MB
        ];
    }

}
