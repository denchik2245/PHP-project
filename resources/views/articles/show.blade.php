@extends('layouts.app')

@section('content')
    <div class="card">
        <h1>{{ $article->title }}</h1>

        <p class="muted">
            Фильм: {{ $article->movie?->title ?? '—' }} |
            Автор: {{ $article->author?->name ?? '—' }} |
            Опубликовано:
            {{ $article->published_at ? $article->published_at->format('d.m.Y H:i') : 'не опубликовано' }}
        </p>

        <div style="margin-top: 20px; line-height: 1.7;">
            {!! nl2br(e($article->content)) !!}
        </div>
    </div>
@endsection