<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $article = $this->route('article');

        return [
            'movie_id' => ['required', 'integer', Rule::exists('movies', 'id')],
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                'alpha_dash',
                Rule::unique('articles', 'slug')->ignore($article?->id),
            ],
            'content' => ['required', 'string', 'min:20'],
        ];
    }

    public function messages(): array
    {
        return [
            'movie_id.required' => 'Выберите фильм.',
            'movie_id.exists' => 'Выбран несуществующий фильм.',
            'title.required' => 'Введите заголовок статьи.',
            'slug.required' => 'Введите slug статьи.',
            'slug.unique' => 'Такой slug уже существует.',
            'content.required' => 'Введите текст статьи.',
            'content.min' => 'Текст статьи должен быть не меньше 20 символов.',
        ];
    }
}
