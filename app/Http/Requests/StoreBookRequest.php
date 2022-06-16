<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'published_at' => 'required|date',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'O título é obrigatório',
            'author.required' => 'O autor é obrigatório',
            'description.required' => 'A descrição é obrigatória',
            'published_at.required' => 'A data de publicação é obrigatória',
        ];
    }

    public function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            response()->json([
                'error' => $validator->errors(),
            ], 422)
        );
    }
}
