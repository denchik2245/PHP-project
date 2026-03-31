@extends('layouts.app')

@section('content')
    <div class="card">
        <h1>404 — Страница не найдена</h1>
        <p>Запрошенная страница не существует или была удалена.</p>
        <a href="{{ route('home') }}" class="btn">На главную</a>
    </div>
@endsection
