@extends('layouts.app')

@section('content')
    <div class="card">
        <h1>Каталог фильмов</h1>
        <p>Здесь отображаются фильмы, добавленные в систему.</p>
    </div>

    <div class="grid">
        @forelse($movies as $movie)
            <div class="card">
                <div class="poster-placeholder">Постер</div>
                <h3>{{ $movie->title }}</h3>
                <p class="muted">Год: {{ $movie->release_year ?? 'не указан' }}</p>

                @if($movie->genres->isNotEmpty())
                    <div style="margin-bottom: 10px;">
                        @foreach($movie->genres as $genre)
                            <span class="badge">{{ $genre->name }}</span>
                        @endforeach
                    </div>
                @endif

                <p>{{ \Illuminate\Support\Str::limit($movie->description, 120) }}</p>
                <a href="{{ route('movies.show', $movie) }}" class="btn">Открыть</a>
            </div>
        @empty
            <div class="card">
                <p>Фильмы не найдены.</p>
            </div>
        @endforelse
    </div>

    <div class="pagination">
        {{ $movies->links() }}
    </div>
@endsection