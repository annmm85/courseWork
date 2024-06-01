<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserLoginRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => 'required',
        ];
    }
    /**
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.required' => 'Почта обязательна к заполнению.',
            'email.email' => 'Почта некорректна.',
            'password.required' => 'Пароль обязателен к заполнению.',
        ];
    }
}
