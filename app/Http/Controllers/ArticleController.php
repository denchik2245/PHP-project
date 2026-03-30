<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Contracts\View\View;

class ArticleController extends Controller
{
    public function show(Article $article): View
    {
        if (! $article->isPublished()) {
            abort(404);
        }

        $article->load(['movie', 'author', 'publisher']);

        return view('articles.show', compact('article'));
    }
}