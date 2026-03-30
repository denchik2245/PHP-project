<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Movie Catalog' }}</title>

    <!-- Подключение шрифта Montserrat -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            background: #EDEDED;
            color: #222;
        }

        header {
            background: #141414;
            color: white;
            padding: 16px 0;
        }

        .container {
            width: 100%;
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 20px;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin-right: 16px;
        }

        nav a:hover {
            text-decoration: underline;
        }

        main {
            padding: 30px 0;
        }

        .card {
            background: #FFFFFF;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: none;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 20px;
        }

        .muted {
            color: #666;
            font-size: 14px;
        }

        .btn {
            display: inline-block;
            background: #478ECC;
            color: white;
            text-decoration: none;
            padding: 10px 14px;
            border-radius: 6px;
        }

        .btn:hover {
            background: #3b79ad;
        }

        footer {
            background: #111827;
            color: white;
            padding: 20px 0;
            margin-top: 30px;
        }

        h1, h2, h3 {
            margin-top: 0;
        }

        .poster-placeholder {
            height: 220px;
            background: #d1d5db;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #374151;
            margin-bottom: 15px;
        }

        .badge {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 999px;
            background: #e5e7eb;
            margin-right: 6px;
            margin-bottom: 6px;
            font-size: 13px;
        }

        .pagination {
            margin-top: 20px;
        }

        .pagination svg {
            width: 16px;
            height: 16px;
        }
    </style>
</head>
<body>
<header>
    <div class="container">
        <!-- Убрали надпись Movie Catalog -->
        <nav>
            <a href="{{ route('home') }}">Главная</a>
            <a href="{{ route('movies.index') }}">Каталог фильмов</a>

            @auth
                <a href="{{ route('dashboard') }}">Личный кабинет</a>
                <a href="{{ route('profile.edit') }}">Профиль</a>

                @if(auth()->user()->hasAnyRole(['author', 'admin']))
                    <a href="{{ route('my.articles.index') }}">Мои статьи</a>
                @endif

                @if(auth()->user()->hasAnyRole(['editor', 'admin']))
                    <a href="{{ route('moderation.articles.index') }}">Модерация</a>
                @endif

                @if(auth()->user()->hasRole('admin'))
                    <a href="{{ route('admin.users.index') }}">Пользователи</a>
                    <a href="{{ route('admin.movies.index') }}">Фильмы</a>
                @endif
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button
                        type="submit"
                        style="background: transparent; color: white; border: none; cursor: pointer; font-size: 16px; padding: 0;"
                    >
                        Выйти
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}">Вход</a>
                <a href="{{ route('register') }}">Регистрация</a>
            @endauth
        </nav>
    </div>
</header>

<main>
    <div class="container">
        @yield('content')
    </div>
</main>

<footer>
    <div class="container">
        <!-- Убран текст в подвале -->
    </div>
</footer>
</body>
</html>