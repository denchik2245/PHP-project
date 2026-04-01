<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Movie;
use Illuminate\Contracts\View\View;
use Symfony\Component\HttpFoundation\Response;

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

    public function error403(): Response
    {
        return response()
            ->view('errors.403', [], 403)
            ->header('X-Demo-Error', 'Forbidden');
    }

    public function error404(): Response
    {
        return response()
            ->view('errors.404', [], 404)
            ->header('X-Demo-Error', 'Not-Found');
    }

    public function error500(): Response
    {
        return response()
            ->view('errors.500', [], 500)
            ->header('X-Demo-Error', 'Server-Error');
    }
}
