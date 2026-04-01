<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'admin', 'title' => 'Администратор'],
            ['name' => 'editor', 'title' => 'Редактор'],
            ['name' => 'author', 'title' => 'Автор'],
        ];

        foreach ($roles as $roleData) {
            Role::updateOrCreate(
                ['name' => $roleData['name']],
                ['title' => $roleData['title']]
            );
        }

        $admin = Role::where('name', 'admin')->first();
        $editor = Role::where('name', 'editor')->first();
        $author = Role::where('name', 'author')->first();

        $adminPermissions = Permission::whereIn('name', [
            'movie.view',
            'movie.create',
            'movie.update',
            'movie.delete',
            'article.view',
            'article.create',
            'article.update.own',
            'article.publish',
            'user.manage',
            'role.manage',
        ])->pluck('id');

        $editorPermissions = Permission::whereIn('name', [
            'movie.view',
            'article.view',
            'article.publish',
        ])->pluck('id');

        $authorPermissions = Permission::whereIn('name', [
            'movie.view',
            'article.view',
            'article.create',
            'article.update.own',
        ])->pluck('id');

        $admin->permissions()->sync($adminPermissions);
        $editor->permissions()->sync($editorPermissions);
        $author->permissions()->sync($authorPermissions);
    }
}