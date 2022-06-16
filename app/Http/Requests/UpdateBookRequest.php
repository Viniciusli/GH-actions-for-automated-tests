<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateBookRequest extends FormRequest
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
            'title' => 'sometimes|required|string|max:255',
            'author' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string|max:255',
            'published_at' => 'sometimes|required|date',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'O título não pode ser vazio',
            'author.required' => 'O autor não pode ser vazio',
            'description.required' => 'A descrição não pode ser vazia',
            'published_at.required' => 'A data de publicação não pode ser vazia',
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
