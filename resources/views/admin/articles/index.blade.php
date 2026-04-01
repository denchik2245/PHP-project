@extends('layouts.app')

@section('content')
    <div class="card">
        <h1>Модерация статей</h1>
        <p>Редактор и администратор могут публиковать и снимать статьи с публикации.</p>
    </div>

    @if(session('success'))
        <div class="card" style="background: #dcfce7; color: #166534;">
            {{ session('success') }}
        </div>
    @endif

    @forelse($articles as $article)
        <div class="card">
            <h3>{{ $article->title }}</h3>

            <p><strong>Фильм:</strong> {{ $article->movie?->title ?? '—' }}</p>
            <p><strong>Автор:</strong> {{ $article->author?->name ?? '—' }}</p>
            <p><strong>Slug:</strong> {{ $article->slug }}</p>

            <p>
                <strong>Статус:</strong>
                @if($article->status === 'published')
                    <span style="color: #166534;">Опубликована</span>
                @else
                    <span style="color: #92400e;">Черновик</span>
                @endif
            </p>

            <p>
                <strong>Опубликовал:</strong>
                {{ $article->publisher?->name ?? '—' }}
            </p>

            <p>
                <strong>Дата публикации:</strong>
                {{ $article->published_at ? $article->published_at->format('d.m.Y H:i') : '—' }}
            </p>

            <p>{{ \Illuminate\Support\Str::limit($article->content, 220) }}</p>

            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                @if($article->status === 'draft')
                    <form action="{{ route('moderation.articles.publish', $article) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn" style="border: none; cursor: pointer;">
                            Опубликовать
                        </button>
                    </form>
                @else
                    <form action="{{ route('moderation.articles.unpublish', $article) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn" style="border: none; cursor: pointer;">
                            Снять с публикации
                        </button>
                    </form>

                    <a href="{{ route('articles.show', $article) }}" class="btn">Открыть</a>
                @endif
            </div>
        </div>
    @empty
        <div class="card">
            Статей пока нет.
        </div>
    @endforelse

    <div class="pagination">
        {{ $articles->links() }}
    </div>
@endsection