<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UserRegistrationRequest extends FormRequest
{
    /**
     * Определите, авторизован ли пользователь для выполнения этого запроса.     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Получите правила проверки, которые применяются к запросу.*
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:App\Models\User,email',
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
            'name.required' => 'Название обязательно к заполнению.',
            'email.required' => 'Почта обязательна к заполнению.',
            'email.email' => 'Почта некорректна.',
            'email.unique' => 'Такая почта уже зарегистрирована.',
            'password.required' => 'Пароль обязателен к заполнению.',
        ];
    }
}
