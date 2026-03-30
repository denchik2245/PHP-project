<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'login' => ['required', 'string', 'max:255', 'alpha_dash', Rule::unique('users', 'login')],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Введите имя.',
            'login.required' => 'Введите логин.',
            'login.unique' => 'Такой логин уже занят.',
            'login.alpha_dash' => 'Логин может содержать только буквы, цифры, дефис и нижнее подчеркивание.',
            'email.required' => 'Введите email.',
            'email.email' => 'Введите корректный email.',
            'email.unique' => 'Такой email уже зарегистрирован.',
            'password.required' => 'Введите пароль.',
            'password.min' => 'Пароль должен быть не короче 6 символов.',
            'password.confirmed' => 'Пароли не совпадают.',
        ];
    }
}