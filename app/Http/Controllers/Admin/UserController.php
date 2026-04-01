<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::query()
            ->with('roles')
            ->latest()
            ->paginate(10);

        $roles = Role::query()->orderBy('id')->get();

        return view('admin.users.index', compact('users', 'roles'));
    }

    public function toggleBlock(User $user): RedirectResponse
    {
        // Нельзя заблокировать самого себя
        if (Auth::id() === $user->id) {
            return back()->with('error', 'Нельзя заблокировать самого себя.');
        }

        $user->update([
            'is_blocked' => ! $user->is_blocked,
        ]);

        return back()->with(
            'success',
            $user->is_blocked
                ? 'Пользователь заблокирован.'
                : 'Пользователь разблокирован.'
        );
    }

    public function updateRole(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'role_id' => ['required', 'integer', Rule::exists('roles', 'id')],
        ], [
            'role_id.required' => 'Выберите роль.',
            'role_id.exists' => 'Выбрана несуществующая роль.',
        ]);

        $roleId = (int) $validated['role_id'];

        $user->roles()->sync([$roleId]);

        return back()->with('success', 'Роль пользователя обновлена.');
    }
}