@extends('layouts.app')

@section('content')
    <div class="card">
        <h1>500 — Внутренняя ошибка сервера</h1>
        <p>Во время обработки запроса произошла ошибка.</p>
        <a href="{{ route('home') }}" class="btn">На главную</a>
    </div>
@endsection
