@extends('layouts.app')

@section('content')
    <div class="card" style="max-width: 500px; margin: 0 auto;">
        <h1>Регистрация</h1>

        @if ($errors->any())
            <div style="background: #fee2e2; color: #991b1b; padding: 12px; border-radius: 8px; margin-bottom: 15px;">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('register.store') }}" method="POST">
            @csrf

            <div style="margin-bottom: 15px;">
                <label for="name">Имя</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    style="width: 100%; padding: 10px; margin-top: 6px;"
                >
            </div>

            <div style="margin-bottom: 15px;">
                <label for="login">Логин</label>
                <input
                    type="text"
                    id="login"
                    name="login"
                    value="{{ old('login') }}"
                    style="width: 100%; padding: 10px; margin-top: 6px;"
                >
            </div>

            <div style="margin-bottom: 15px;">
                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    style="width: 100%; padding: 10px; margin-top: 6px;"
                >
            </div>

            <div style="margin-bottom: 15px;">
                <label for="password">Пароль</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    style="width: 100%; padding: 10px; margin-top: 6px;"
                >
            </div>

            <div style="margin-bottom: 15px;">
                <label for="password_confirmation">Подтверждение пароля</label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    style="width: 100%; padding: 10px; margin-top: 6px;"
                >
            </div>

            <button type="submit" class="btn" style="border: none; cursor: pointer;">Зарегистрироваться</button>
        </form>

        <p style="margin-top: 20px;">
            Уже есть аккаунт?
            <a href="{{ route('login') }}">Войти</a>
        </p>
    </div>
@endsection