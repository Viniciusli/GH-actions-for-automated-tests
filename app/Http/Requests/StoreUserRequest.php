<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|string|min:6|same:password',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Informe o nome do usuário',
            'name.max' => 'O nome do usuário deve ter no máximo 255 caracteres',
            'email.required' => 'Informe o e-mail do usuário',
            'email.email' => 'Informe um e-mail válido',
            'email.max' => 'O e-mail do usuário deve ter no máximo 255 caracteres',
            'email.unique' => 'Este e-mail já está cadastrado',
            'password.required' => 'Informe a senha do usuário',
            'password.min' => 'A senha do usuário deve ter no mínimo 6 caracteres',
            'password.confirmed' => 'As senhas não conferem',
            'password_confirmation.required' => 'Informe a confirmação da senha do usuário',
            'password_confirmation.min' => 'A confirmação da senha do usuário deve ter no mínimo 6 caracteres',
            'password_confirmation.same' => 'As senhas não conferem',
        ];
    }

    public function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            response()->json(
                [
                    'error' => $validator->errors()->first(),
                    'message' => 'Erro ao cadastrar usuário',
                ],
                422
            )
        );
    }
}
