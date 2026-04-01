<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'login' => 'admin',
                'password' => Hash::make('password'),
                'is_blocked' => false,
            ]
        );

        $editor = User::updateOrCreate(
            ['email' => 'editor@example.com'],
            [
                'name' => 'Editor User',
                'login' => 'editor',
                'password' => Hash::make('password'),
                'is_blocked' => false,
            ]
        );

        $author = User::updateOrCreate(
            ['email' => 'author@example.com'],
            [
                'name' => 'Author User',
                'login' => 'author',
                'password' => Hash::make('password'),
                'is_blocked' => false,
            ]
        );

        $adminRole = Role::where('name', 'admin')->first();
        $editorRole = Role::where('name', 'editor')->first();
        $authorRole = Role::where('name', 'author')->first();

        $admin->roles()->sync([$adminRole->id]);
        $editor->roles()->sync([$editorRole->id]);
        $author->roles()->sync([$authorRole->id]);
    }
}
