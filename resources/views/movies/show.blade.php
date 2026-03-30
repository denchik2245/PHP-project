@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="poster-placeholder">Постер фильма</div>

        <h1>{{ $movie->title }}</h1>
        <p class="muted">Год выпуска: {{ $movie->release_year ?? 'не указан' }}</p>

        @if($movie->genres->isNotEmpty())
            <div style="margin-bottom: 15px;">
                @foreach($movie->genres as $genre)
                    <span class="badge">{{ $genre->name }}</span>
                @endforeach
            </div>
        @endif

        <p>{{ $movie->description ?: 'Описание пока отсутствует.' }}</p>
    </div>

    <div class="card">
        <h2>Опубликованные статьи по фильму</h2>

        @forelse($movie->articles as $article)
            <div style="margin-bottom: 18px; padding-bottom: 18px; border-bottom: 1px solid #ddd;">
                <h3>{{ $article->title }}</h3>
                <p class="muted">
                    Автор: {{ $article->author?->name ?? '—' }}
                </p>
                <p>{{ \Illuminate\Support\Str::limit($article->content, 180) }}</p>
                <a href="{{ route('articles.show', $article) }}" class="btn">Читать статью</a>
            </div>
        @empty
            <p>По этому фильму пока нет опубликованных статей.</p>
        @endforelse
    </div>
@endsection