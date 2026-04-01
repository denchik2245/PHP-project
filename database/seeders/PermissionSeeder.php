<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['name' => 'movie.view', 'title' => 'Просмотр фильмов'],
            ['name' => 'movie.create', 'title' => 'Создание фильмов'],
            ['name' => 'movie.update', 'title' => 'Редактирование фильмов'],
            ['name' => 'movie.delete', 'title' => 'Удаление фильмов'],

            ['name' => 'article.view', 'title' => 'Просмотр статей'],
            ['name' => 'article.create', 'title' => 'Создание статей'],
            ['name' => 'article.update.own', 'title' => 'Редактирование своих статей'],
            ['name' => 'article.publish', 'title' => 'Публикация статей'],

            ['name' => 'user.manage', 'title' => 'Управление пользователями'],
            ['name' => 'role.manage', 'title' => 'Управление ролями'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission['name']],
                ['title' => $permission['title']]
            );
        }
    }
}
