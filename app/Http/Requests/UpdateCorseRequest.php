<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCorseRequest extends FormRequest
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
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric',
            'author' => 'sometimes|required|string|max:255',
            'duration' => 'sometimes|required|integer',
            'students_number' => 'nullable|integer',
            'rating' => 'nullable|integer',
            'image' => 'nullable|string',
            'category_id' => 'sometimes|required|exists:courses_categories,id',
        ];
    }
}
