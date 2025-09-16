<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LessonRequest extends FormRequest
{
    public function authorize()
    {
        // التفويض العام يتم داخل Controller / Policy
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'resource' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip,mp4,mov,avi|max:51200', // max: 50MB (KB)
        ];
    }
}
