<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMovieRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasRole('admin');
    }

    public function rules(): array
    {
        $movie = $this->route('movie');

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                'alpha_dash',
                Rule::unique('movies', 'slug')->ignore($movie?->id),
            ],
            'description' => ['nullable', 'string'],
            'release_year' => ['nullable', 'integer', 'min:1888', 'max:' . date('Y')],
            'genres' => ['nullable', 'array'],
            'genres.*' => ['integer', Rule::exists('genres', 'id')],
            'poster' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Введите название фильма.',
            'slug.required' => 'Введите slug.',
            'slug.unique' => 'Такой slug уже существует.',
            'slug.alpha_dash' => 'Slug может содержать только буквы, цифры, дефис и нижнее подчеркивание.',
            'poster.image' => 'Файл постера должен быть изображением.',
            'poster.mimes' => 'Допустимые форматы постера: jpg, jpeg, png, webp.',
            'poster.max' => 'Постер не должен быть больше 4 МБ.',
        ];
    }
}
