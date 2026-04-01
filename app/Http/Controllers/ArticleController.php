<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Models\Movie;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

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

    public function myIndex(): View
    {
        $user = Auth::user();

        $articles = Article::query()
            ->where('author_id', $user->id)
            ->with('movie')
            ->latest()
            ->paginate(10);

        return view('articles.index', compact('articles'));
    }

    public function create(): View
    {
        if (! Auth::user()->hasAnyRole(['author', 'admin'])) {
            abort(403);
        }

        $movies = Movie::query()->orderBy('title')->get();

        return view('articles.create', compact('movies'));
    }

    public function store(StoreArticleRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['author_id'] = Auth::id();
        $data['status'] = 'draft';

        Article::query()->create($data);

        return redirect()
            ->route('my.articles.index')
            ->with('success', 'Статья успешно создана как черновик.');
    }

    public function edit(Article $article): View
    {
        $user = Auth::user();

        if ($article->author_id !== $user->id && ! $user->hasRole('admin')) {
            abort(403);
        }

        if ($article->isPublished() && ! $user->hasRole('admin')) {
            abort(403, 'Опубликованную статью нельзя редактировать автору.');
        }

        $movies = Movie::query()->orderBy('title')->get();

        return view('articles.edit', compact('article', 'movies'));
    }

    public function update(UpdateArticleRequest $request, Article $article): RedirectResponse
    {
        $user = Auth::user();

        if ($article->author_id !== $user->id && ! $user->hasRole('admin')) {
            abort(403);
        }

        if ($article->isPublished() && ! $user->hasRole('admin')) {
            abort(403, 'Опубликованную статью нельзя редактировать автору.');
        }

        $article->update($request->validated());

        return redirect()
            ->route('my.articles.index')
            ->with('success', 'Статья успешно обновлена.');
    }
}
