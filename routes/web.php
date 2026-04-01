<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::middleware(['auth', 'not_blocked'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/my/articles', [ArticleController::class, 'myIndex'])->name('my.articles.index');
    Route::get('/my/articles/create', [ArticleController::class, 'create'])->name('my.articles.create');
    Route::post('/my/articles', [ArticleController::class, 'store'])->name('my.articles.store');
    Route::get('/my/articles/{article}/edit', [ArticleController::class, 'edit'])->name('my.articles.edit');
    Route::post('/my/articles/{article}', [ArticleController::class, 'update'])->name('my.articles.update');
});

Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
Route::get('/movies/{movie:slug}', [MovieController::class, 'show'])->name('movies.show');

Route::get('/articles/{article:slug}', [ArticleController::class, 'show'])->name('articles.show');
Route::get('/error-test/403', [HomeController::class, 'error403'])->name('error.403');
Route::get('/error-test/404', [HomeController::class, 'error404'])->name('error.404');
Route::get('/error-test/500', [HomeController::class, 'error500'])->name('error.500');
Route::get('/abort-test/403', function () {
    abort(403, 'Доступ запрещен');
});

Route::get('/abort-test/404', function () {
    abort(404, 'Страница не найдена');
});

Route::get('/abort-test/500', function () {
    abort(500, 'Внутренняя ошибка сервера');
});

Route::middleware(['auth', 'not_blocked', 'role:admin'])->get('/admin-only-test', function () {
    return 'Доступ только для администратора';
});

Route::middleware(['auth', 'not_blocked', 'role:editor,admin'])->get('/editor-only-test', function () {
    return 'Доступ для редактора или администратора';
});

Route::middleware(['auth', 'not_blocked', 'permission:user.manage'])->get('/permission-test', function () {
    return 'Есть право user.manage';
});

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'not_blocked', 'role:admin'])
    ->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('dashboard');

        Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
        Route::post('/users/{user}/toggle-block', [\App\Http\Controllers\Admin\UserController::class, 'toggleBlock'])->name('users.toggle-block');
        Route::post('/users/{user}/role', [\App\Http\Controllers\Admin\UserController::class, 'updateRole'])->name('users.update-role');
        Route::get('/movies', [\App\Http\Controllers\Admin\MovieAdminController::class, 'index'])->name('movies.index');
        Route::get('/movies/create', [\App\Http\Controllers\Admin\MovieAdminController::class, 'create'])->name('movies.create');
        Route::post('/movies', [\App\Http\Controllers\Admin\MovieAdminController::class, 'store'])->name('movies.store');
        Route::get('/movies/{movie}/edit', [\App\Http\Controllers\Admin\MovieAdminController::class, 'edit'])->name('movies.edit');
        Route::post('/movies/{movie}', [\App\Http\Controllers\Admin\MovieAdminController::class, 'update'])->name('movies.update');
        Route::post('/movies/{movie}/delete', [\App\Http\Controllers\Admin\MovieAdminController::class, 'destroy'])->name('movies.destroy');
    });

Route::prefix('moderation')
    ->name('moderation.')
    ->middleware(['auth', 'not_blocked', 'role:editor,admin'])
    ->group(function () {
        Route::get('/articles', [\App\Http\Controllers\Admin\ModerationController::class, 'index'])->name('articles.index');
        Route::post('/articles/{article}/publish', [\App\Http\Controllers\Admin\ModerationController::class, 'publish'])->name('articles.publish');
        Route::post('/articles/{article}/unpublish', [\App\Http\Controllers\Admin\ModerationController::class, 'unpublish'])->name('articles.unpublish');
    });
