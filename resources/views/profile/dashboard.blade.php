@extends('layouts.app')

@section('content')
    <div class="card">
        <h1>Личный кабинет</h1>

        @if($user->avatar_path)
            <div style="margin-bottom: 20px;">
                <img
                    src="{{ asset('storage/' . $user->avatar_path) }}"
                    alt="Аватар"
                    style="width: 120px; height: 120px; object-fit: cover; border-radius: 50%;"
                >
            </div>
        @endif

        <p><strong>Имя:</strong> {{ $user->name }}</p>
        <p><strong>Логин:</strong> {{ $user->login }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>

        <div style="margin-top: 20px;">
            <a href="{{ route('profile.edit') }}" class="btn">Редактировать профиль</a>
        </div>
    </div>
@endsection