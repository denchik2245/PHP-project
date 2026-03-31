@extends('layouts.app')

@section('content')
    <div class="card">
        <h1>403 — Доступ запрещен</h1>
        <p>У вас нет прав для доступа к этой странице.</p>
        <a href="{{ route('home') }}" class="btn">На главную</a>
    </div>
@endsection
