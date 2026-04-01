@extends('layouts.app')

@section('content')
    <div class="card" style="max-width: 900px; margin: 0 auto;">
        <h1>Редактировать статью</h1>

        @if($errors->any())
            <div style="background: #fee2e2; color: #991b1b; padding: 12px; border-radius: 8px; margin-bottom: 15px;">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('my.articles.update', $article) }}" method="POST">
            @csrf

            <div style="margin-bottom: 15px;">
                <label for="movie_id">Фильм</label>
                <select id="movie_id" name="movie_id" style="width: 100%; padding: 10px; margin-top: 6px;">
                    @foreach($movies as $movie)
                        <option value="{{ $movie->id }}" @selected(old('movie_id', $article->movie_id) == $movie->id)>
                            {{ $movie->title }} ({{ $movie->release_year }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom: 15px;">
                <label for="title">Заголовок статьи</label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    value="{{ old('title', $article->title) }}"
                    style="width: 100%; padding: 10px; margin-top: 6px;"
                >
            </div>

            <div style="margin-bottom: 15px;">
                <label for="slug">Slug</label>
                <input
                    type="text"
                    id="slug"
                    name="slug"
                    value="{{ old('slug', $article->slug) }}"
                    style="width: 100%; padding: 10px; margin-top: 6px;"
                >
            </div>

            <div style="margin-bottom: 20px;">
                <label for="content">Текст статьи</label>
                <textarea
                    id="content"
                    name="content"
                    rows="12"
                    style="width: 100%; padding: 10px; margin-top: 6px;"
                >{{ old('content', $article->content) }}</textarea>
            </div>

            <button type="submit" class="btn" style="border: none; cursor: pointer;">Сохранить изменения</button>
        </form>
    </div>
@endsection