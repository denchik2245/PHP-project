<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        $user = User::query()
            ->where('login', $credentials['login'])
            ->first();

        if (! $user || $user->is_blocked) {
            return back()
                ->withInput($request->except('password'))
                ->withErrors([
                    'login' => 'Пользователь не найден или заблокирован.',
                ]);
        }

        if (! Auth::attempt([
            'login' => $credentials['login'],
            'password' => $credentials['password'],
        ], true)) {
            return back()
                ->withInput($request->except('password'))
                ->withErrors([
                    'login' => 'Неверный логин или пароль.',
                ]);
        }

        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $user = User::query()->create($request->validated());

        $authorRole = Role::query()->where('name', 'author')->first();

        if ($authorRole) {
            $user->roles()->attach($authorRole->id);
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('home');
    }
}