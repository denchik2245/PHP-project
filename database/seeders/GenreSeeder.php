<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        $genres = [
            ['name' => 'Фантастика', 'slug' => 'fantastika'],
            ['name' => 'Драма', 'slug' => 'drama'],
            ['name' => 'Боевик', 'slug' => 'boevik'],
            ['name' => 'Комедия', 'slug' => 'komediya'],
        ];

        foreach ($genres as $genre) {
            Genre::updateOrCreate(
                ['slug' => $genre['slug']],
                ['name' => $genre['name']]
            );
        }
    }
}
