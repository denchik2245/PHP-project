@extends('layouts.app')

@section('content')
    <div class="card">
        <h1>Мои статьи</h1>
        <p>Здесь отображаются ваши статьи и их статусы.</p>

        <div style="margin-top: 15px;">
            <a href="{{ route('my.articles.create') }}" class="btn">Создать статью</a>
        </div>
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
            <p><strong>Slug:</strong> {{ $article->slug }}</p>
            <p>
                <strong>Статус:</strong>
                @if($article->status === 'published')
                    <span style="color: #166534;">Опубликована</span>
                @else
                    <span style="color: #92400e;">Черновик</span>
                @endif
            </p>

            <p>{{ \Illuminate\Support\Str::limit($article->content, 180) }}</p>

            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                @if($article->status === 'draft' || auth()->user()->hasRole('admin'))
                    <a href="{{ route('my.articles.edit', $article) }}" class="btn">Редактировать</a>
                @endif

                @if($article->status === 'published')
                    <a href="{{ route('articles.show', $article) }}" class="btn">Открыть</a>
                @endif
            </div>
        </div>
    @empty
        <div class="card">
            У вас пока нет статей.
        </div>
    @endforelse

    <div class="pagination">
        {{ $articles->links() }}
    </div>
@endsection
