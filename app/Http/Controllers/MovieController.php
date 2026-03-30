<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Contracts\View\View;

class MovieController extends Controller
{
    public function index(): View
    {
        $movies = Movie::query()
            ->with('genres')
            ->latest()
            ->paginate(9);

        return view('movies.index', compact('movies'));
    }

    public function show(Movie $movie): View
    {
        $movie->load([
            'genres',
            'articles' => function ($query) {
                $query->where('status', 'published')
                    ->with('author')
                    ->latest('published_at');
            },
        ]);

        return view('movies.show', compact('movie'));
    }
}