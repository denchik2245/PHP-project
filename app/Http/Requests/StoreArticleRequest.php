<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = Auth::user();

        return $user instanceof User
            && $user->hasAnyRole(['author', 'admin']);
    }

    public function rules(): array
    {
        return [
            'movie_id' => ['required', 'integer', Rule::exists('movies', 'id')],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'alpha_dash', Rule::unique('articles', 'slug')],
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
            'slug.alpha_dash' => 'Slug может содержать только буквы, цифры, дефис и нижнее подчеркивание.',
            'content.required' => 'Введите текст статьи.',
            'content.min' => 'Текст статьи должен быть не меньше 20 символов.',
        ];
    }
}