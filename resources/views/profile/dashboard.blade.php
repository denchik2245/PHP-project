@extends('layouts.app')

@section('content')
    <div class="card">
        <h1>Личный кабинет</h1>
        <p><strong>Имя:</strong> {{ $user->name }}</p>
        <p><strong>Логин:</strong> {{ $user->login }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>

        <div style="margin-top: 20px;">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn" style="border: none; cursor: pointer;">Выйти</button>
            </form>
        </div>
    </div>
@endsection