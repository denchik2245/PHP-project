<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $userId = auth()->id();

        return [
            'name' => ['required', 'string', 'max:255'],
            'login' => [
                'required',
                'string',
                'max:255',
                'alpha_dash',
                Rule::unique('users', 'login')->ignore($userId),
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Введите имя.',
            'login.required' => 'Введите логин.',
            'login.unique' => 'Этот логин уже занят.',
            'login.alpha_dash' => 'Логин может содержать только буквы, цифры, дефис и нижнее подчеркивание.',
            'email.required' => 'Введите email.',
            'email.email' => 'Введите корректный email.',
            'email.unique' => 'Этот email уже занят.',
            'avatar.image' => 'Файл должен быть изображением.',
            'avatar.mimes' => 'Допустимы только jpg, jpeg, png, webp.',
            'avatar.max' => 'Размер файла не должен превышать 2 МБ.',
        ];
    }
}