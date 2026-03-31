<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserNotBlocked
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->is_blocked) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            abort(403, 'Ваш аккаунт заблокирован.');
        }

        return $next($request);
    }
}
