<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
{
    public function authorize()
    {
        // Allow; Authorization is handled by the controller policies
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'instructor_id' => 'nullable|exists:users,id', // admin يمكنه تعيين مدرس
        ];
    }

}
