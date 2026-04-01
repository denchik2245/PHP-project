<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class MovieAdminController extends Controller
{
    public function index(): View
    {
        $movies = Movie::query()
            ->with('genres')
            ->latest()
            ->paginate(10);

        return view('admin.movies.index', compact('movies'));
    }

    public function create(): View
    {
        $genres = Genre::query()->orderBy('name')->get();

        return view('admin.movies.create', compact('genres'));
    }

    public function store(StoreMovieRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $genreIds = $data['genres'] ?? [];

        if ($request->hasFile('poster')) {
            $data['poster_path'] = $request->file('poster')->store('posters', 'public');
        }

        unset($data['poster'], $data['genres']);

        $data['created_by'] = auth()->id();

        $movie = Movie::query()->create($data);
        $movie->genres()->sync($genreIds);

        return redirect()
            ->route('admin.movies.index')
            ->with('success', 'Фильм успешно создан.');
    }

    public function edit(Movie $movie): View
    {
        $movie->load('genres');
        $genres = Genre::query()->orderBy('name')->get();

        return view('admin.movies.edit', compact('movie', 'genres'));
    }

    public function update(UpdateMovieRequest $request, Movie $movie): RedirectResponse
    {
        $data = $request->validated();
        $genreIds = $data['genres'] ?? [];

        if ($request->hasFile('poster')) {
            if ($movie->poster_path && Storage::disk('public')->exists($movie->poster_path)) {
                Storage::disk('public')->delete($movie->poster_path);
            }

            $data['poster_path'] = $request->file('poster')->store('posters', 'public');
        }

        unset($data['poster'], $data['genres']);

        $movie->update($data);
        $movie->genres()->sync($genreIds);

        return redirect()
            ->route('admin.movies.index')
            ->with('success', 'Фильм успешно обновлен.');
    }

    public function destroy(Movie $movie): RedirectResponse
    {
        if ($movie->poster_path && Storage::disk('public')->exists($movie->poster_path)) {
            Storage::disk('public')->delete($movie->poster_path);
        }

        $movie->genres()->detach();
        $movie->delete();

        return redirect()
            ->route('admin.movies.index')
            ->with('success', 'Фильм удален.');
    }
}
