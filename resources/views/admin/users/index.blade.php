@extends('layouts.app')

@section('content')
    <div class="card">
        <h1>Админка — пользователи</h1>
        <p>Здесь администратор может менять роли и блокировать пользователей.</p>
    </div>

    @if(session('success'))
        <div class="card" style="background: #dcfce7; color: #166534;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="card" style="background: #fee2e2; color: #991b1b;">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="card" style="background: #fee2e2; color: #991b1b;">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    @forelse($users as $user)
        <div class="card">
            <div style="display: flex; justify-content: space-between; gap: 20px; flex-wrap: wrap;">
                <div>
                    <h3 style="margin-bottom: 10px;">{{ $user->name }}</h3>
                    <p><strong>Логин:</strong> {{ $user->login }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p>
                        <strong>Статус:</strong>
                        @if($user->is_blocked)
                            <span style="color: #b91c1c;">Заблокирован</span>
                        @else
                            <span style="color: #166534;">Активен</span>
                        @endif
                    </p>
                    <p>
                        <strong>Текущая роль:</strong>
                        {{ $user->roles->pluck('title')->join(', ') ?: 'Не назначена' }}
                    </p>
                </div>

                <div style="min-width: 280px;">
                    <form action="{{ route('admin.users.update-role', $user) }}" method="POST" style="margin-bottom: 15px;">
                        @csrf
                        <label for="role_id_{{ $user->id }}"><strong>Сменить роль</strong></label>
                        <select
                            name="role_id"
                            id="role_id_{{ $user->id }}"
                            style="width: 100%; padding: 10px; margin-top: 8px; margin-bottom: 10px;"
                        >
                            @foreach($roles as $role)
                                <option
                                    value="{{ $role->id }}"
                                    @selected($user->roles->contains('id', $role->id))
                                >
                                    {{ $role->title }}
                                </option>
                            @endforeach
                        </select>

                        <button type="submit" class="btn" style="border: none; cursor: pointer;">
                            Сохранить роль
                        </button>
                    </form>

                    <form action="{{ route('admin.users.toggle-block', $user) }}" method="POST">
                        @csrf
                        <button
                            type="submit"
                            class="btn"
                            style="border: none; cursor: pointer;"
                        >
                            {{ $user->is_blocked ? 'Разблокировать' : 'Заблокировать' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="card">
            Пользователи не найдены.
        </div>
    @endforelse

    <div class="pagination">
        {{ $users->links() }}
    </div>
@endsection
