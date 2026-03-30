@extends('layouts.app')

@section('content')
    <div class="card">
        <h1>Добро пожаловать в каталог фильмов</h1>
        <a href="{{ route('movies.index') }}" class="btn">Перейти в каталог</a>
        <div style="margin-top: 20px;">
    <p><strong>Демо ошибок:</strong></p>
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <a href="{{ route('error.403') }}" class="btn">Ошибка 403</a>
                <a href="{{ route('error.404') }}" class="btn">Ошибка 404</a>
                <a href="{{ route('error.500') }}" class="btn">Ошибка 500</a>
            </div>
        </div>
    </div>

    <h2>Последние фильмы</h2>
    <div class="grid">
        @forelse($movies as $movie)
            <div class="card">
                <div class="poster-placeholder">Постер</div>
                <h3>{{ $movie->title }}</h3>
                <p class="muted">Год: {{ $movie->release_year ?? 'не указан' }}</p>
                <p>{{ \Illuminate\Support\Str::limit($movie->description, 100) }}</p>
                <a href="{{ route('movies.show', $movie) }}" class="btn">Подробнее</a>
            </div>
        @empty
            <div class="card">
                <p>Фильмы пока не добавлены.</p>
            </div>
        @endforelse
    </div>

    <h2 style="margin-top: 30px;">Последние опубликованные статьи</h2>
    <div class="grid">
        @forelse($articles as $article)
            <div class="card">
                <h3>{{ $article->title }}</h3>
                <p class="muted">
                    Фильм: {{ $article->movie?->title ?? '—' }} |
                    Автор: {{ $article->author?->name ?? '—' }}
                </p>
                <p>{{ \Illuminate\Support\Str::limit($article->content, 120) }}</p>
                <a href="{{ route('articles.show', $article) }}" class="btn">Читать</a>
            </div>
        @empty
            <div class="card">
                <p>Опубликованных статей пока нет.</p>
            </div>
        @endforelse
    </div>
@endsection