<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'question' =>
            'required|string',

            'type' =>
            'required|in:multiple_choice,true_false',

            'options' =>
            'nullable|array',

            'correct_answer' =>
            'required|string',
        ];
    }
}