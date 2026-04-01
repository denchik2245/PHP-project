<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ModerationController extends Controller
{
    public function index(): View
    {
        $articles = Article::query()
            ->with(['movie', 'author', 'publisher'])
            ->latest()
            ->paginate(12);

        return view('admin.articles.index', compact('articles'));
    }

    public function publish(Article $article): RedirectResponse
    {
        $article->update([
            'status' => 'published',
            'published_at' => Carbon::now(),
            'published_by' => Auth::id(),
        ]);

        return back()->with('success', 'Статья опубликована.');
    }

    public function unpublish(Article $article): RedirectResponse
    {
        $article->update([
            'status' => 'draft',
            'published_at' => null,
            'published_by' => null,
        ]);

        return back()->with('success', 'Статья снята с публикации.');
    }
}