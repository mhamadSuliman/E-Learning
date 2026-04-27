<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCorseRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'author' => 'required|string|max:255',
            'duration' => 'required|integer',
            'students_number' => 'nullable|integer',
            'rating' => 'nullable|integer',
            'image' => 'nullable|string',
            'category_id' => 'required|exists:courses_categories,id',
            'instructor_id' => 'nullable|exists:users,id',

        ];
    }
}
