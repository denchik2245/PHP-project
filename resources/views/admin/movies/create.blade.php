@extends('layouts.app')

@section('content')
    <div class="card" style="max-width: 800px; margin: 0 auto;">
        <h1>Добавить фильм</h1>

        @if($errors->any())
            <div style="background: #fee2e2; color: #991b1b; padding: 12px; border-radius: 8px; margin-bottom: 15px;">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('admin.movies.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div style="margin-bottom: 15px;">
                <label for="title">Название</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" style="width: 100%; padding: 10px; margin-top: 6px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label for="slug">Slug</label>
                <input type="text" id="slug" name="slug" value="{{ old('slug') }}" style="width: 100%; padding: 10px; margin-top: 6px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label for="release_year">Год выпуска</label>
                <input type="number" id="release_year" name="release_year" value="{{ old('release_year') }}" style="width: 100%; padding: 10px; margin-top: 6px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label for="description">Описание</label>
                <textarea id="description" name="description" rows="6" style="width: 100%; padding: 10px; margin-top: 6px;">{{ old('description') }}</textarea>
            </div>

            <div style="margin-bottom: 15px;">
                <label for="genres">Жанры</label>
                <select id="genres" name="genres[]" multiple style="width: 100%; padding: 10px; margin-top: 6px; min-height: 120px;">
                    @foreach($genres as $genre)
                        <option value="{{ $genre->id }}" @selected(collect(old('genres'))->contains($genre->id))>
                            {{ $genre->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom: 20px;">
                <label for="poster">Постер</label>
                <input type="file" id="poster" name="poster" style="display: block; margin-top: 6px;">
            </div>

            <button type="submit" class="btn" style="border: none; cursor: pointer;">Сохранить</button>
        </form>
    </div>
@endsection