@extends('layouts.app')

@section('content')
    <div class="card">
        <h1>Админка — фильмы</h1>
        <p>Управление каталогом фильмов.</p>

        <div style="margin-top: 15px;">
            <a href="{{ route('admin.movies.create') }}" class="btn">Добавить фильм</a>
        </div>
    </div>

    @if(session('success'))
        <div class="card" style="background: #dcfce7; color: #166534;">
            {{ session('success') }}
        </div>
    @endif

    @forelse($movies as $movie)
        <div class="card">
            <div style="display: flex; justify-content: space-between; gap: 20px; flex-wrap: wrap;">
                <div>
                    <h3>{{ $movie->title }}</h3>
                    <p><strong>Slug:</strong> {{ $movie->slug }}</p>
                    <p><strong>Год:</strong> {{ $movie->release_year ?? 'не указан' }}</p>

                    @if($movie->genres->isNotEmpty())
                        <p>
                            <strong>Жанры:</strong>
                            {{ $movie->genres->pluck('name')->join(', ') }}
                        </p>
                    @endif
                </div>

                <div style="display: flex; gap: 10px; align-items: start; flex-wrap: wrap;">
                    <a href="{{ route('admin.movies.edit', $movie) }}" class="btn">Редактировать</a>

                    <form action="{{ route('admin.movies.destroy', $movie) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn" style="border: none; cursor: pointer;">
                            Удалить
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="card">
            Фильмы пока не добавлены.
        </div>
    @endforelse

    <div class="pagination">
        {{ $movies->links() }}
    </div>
@endsection
