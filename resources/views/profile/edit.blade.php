@extends('layouts.app')

@section('content')
    <div class="card" style="max-width: 700px; margin: 0 auto;">
        <h1>Редактирование профиля</h1>

        @if(session('success'))
            <div style="background: #dcfce7; color: #166534; padding: 12px; border-radius: 8px; margin-bottom: 15px;">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div style="background: #fee2e2; color: #991b1b; padding: 12px; border-radius: 8px; margin-bottom: 15px;">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        @if($user->avatar_path)
            <div style="margin-bottom: 20px;">
                <img
                    src="{{ asset('storage/' . $user->avatar_path) }}"
                    alt="Аватар"
                    style="width: 120px; height: 120px; object-fit: cover; border-radius: 50%;"
                >
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div style="margin-bottom: 15px;">
                <label for="name">Имя</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $user->name) }}"
                    style="width: 100%; padding: 10px; margin-top: 6px;"
                >
            </div>

            <div style="margin-bottom: 15px;">
                <label for="login">Логин</label>
                <input
                    type="text"
                    id="login"
                    name="login"
                    value="{{ old('login', $user->login) }}"
                    style="width: 100%; padding: 10px; margin-top: 6px;"
                >
            </div>

            <div style="margin-bottom: 15px;">
                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email', $user->email) }}"
                    style="width: 100%; padding: 10px; margin-top: 6px;"
                >
            </div>

            <div style="margin-bottom: 20px;">
                <label for="avatar">Аватар</label>
                <input
                    type="file"
                    id="avatar"
                    name="avatar"
                    style="display: block; margin-top: 6px;"
                >
                <p class="muted">Допустимые форматы: jpg, jpeg, png, webp. Максимум 2 МБ.</p>
            </div>

            <button type="submit" class="btn" style="border: none; cursor: pointer;">Сохранить</button>
        </form>
    </div>
@endsection