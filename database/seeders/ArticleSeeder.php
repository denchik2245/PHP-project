<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $author = User::where('login', 'author')->first();
        $editor = User::where('login', 'editor')->first();

        $interstellar = Movie::where('slug', 'interstellar')->first();
        $inception = Movie::where('slug', 'inception')->first();
        $matrix = Movie::where('slug', 'matrix')->first();

        Article::updateOrCreate(
            ['slug' => 'interstellar-review'],
            [
                'movie_id' => $interstellar?->id,
                'author_id' => $author?->id,
                'title' => 'Обзор фильма Интерстеллар',
                'content' => 'Интерстеллар — это сильная научно-фантастическая драма о времени, космосе и семье.',
                'status' => 'published',
                'published_at' => Carbon::now(),
                'published_by' => $editor?->id,
            ]
        );

        Article::updateOrCreate(
            ['slug' => 'inception-review'],
            [
                'movie_id' => $inception?->id,
                'author_id' => $author?->id,
                'title' => 'Обзор фильма Начало',
                'content' => 'Начало показывает сложную структуру сна и интересную идею внедрения мыслей.',
                'status' => 'draft',
                'published_at' => null,
                'published_by' => null,
            ]
        );

        Article::updateOrCreate(
            ['slug' => 'matrix-review'],
            [
                'movie_id' => $matrix?->id,
                'author_id' => $author?->id,
                'title' => 'Почему Матрица стала культовой',
                'content' => 'Матрица объединила философию, экшен и технологическую антиутопию.',
                'status' => 'published',
                'published_at' => Carbon::now(),
                'published_by' => $editor?->id,
            ]
        );
    }
}
