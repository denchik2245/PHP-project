<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('login', 'admin')->first();

        $movies = [
            [
                'title' => 'Интерстеллар',
                'slug' => 'interstellar',
                'description' => 'Фильм о космосе, времени и спасении человечества.',
                'release_year' => 2014,
            ],
            [
                'title' => 'Начало',
                'slug' => 'inception',
                'description' => 'Фильм о проникновении в сны и управлении сознанием.',
                'release_year' => 2010,
            ],
            [
                'title' => 'Матрица',
                'slug' => 'matrix',
                'description' => 'Фильм о виртуальной реальности и борьбе за свободу.',
                'release_year' => 1999,
            ],
        ];

        foreach ($movies as $movieData) {
            $movie = Movie::updateOrCreate(
                ['slug' => $movieData['slug']],
                [
                    'title' => $movieData['title'],
                    'description' => $movieData['description'],
                    'release_year' => $movieData['release_year'],
                    'created_by' => $admin?->id,
                ]
            );

            $fantasy = Genre::where('slug', 'fantastika')->first();
            $drama = Genre::where('slug', 'drama')->first();
            $action = Genre::where('slug', 'boevik')->first();

            $genreIds = match ($movie->slug) {
                'interstellar' => [$fantasy?->id, $drama?->id],
                'inception' => [$fantasy?->id, $action?->id],
                'matrix' => [$fantasy?->id, $action?->id],
                default => [],
            };

            $movie->genres()->sync(array_filter($genreIds));
        }
    }
}
