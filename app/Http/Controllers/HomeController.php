<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Movie;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $movies = Movie::query()
            ->latest()
            ->take(6)
            ->get();

        $articles = Article::query()
            ->where('status', 'published')
            ->with(['movie', 'author'])
            ->latest('published_at')
            ->take(6)
            ->get();

        return view('home', compact('movies', 'articles'));
    }
}