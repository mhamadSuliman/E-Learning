<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLessonRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'title'=>'sometimes|string|max:255',

            'description'=>'nullable|string',

            'video'=>
            'nullable|file|mimes:mp4,mov,avi|max:51200',

            'file'=>
            'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip|max:10240',

            'order'=>'nullable|integer'

        ];
    }
}