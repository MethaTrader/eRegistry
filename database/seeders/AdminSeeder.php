<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $adminEmail = env('ADMIN_EMAIL', 'admin@example.com');
        $adminPassword = env('ADMIN_PASSWORD', 'secret');

        // Если пользователь с таким email ещё не существует, создаём его
        if (!User::where('email', $adminEmail)->exists()) {
            $user = User::create([
                'name'     => 'Administrator',
                'email'    => $adminEmail,
                'password' => Hash::make($adminPassword),
            ]);

            // Создаём роль 'admin', если её ещё нет, с указанием guard_name
            $adminRole = Role::firstOrCreate(
                ['name' => 'admin'],
                ['guard_name' => 'web']
            );

            // Назначаем созданную роль пользователю
            $user->assignRole($adminRole);
        }
    }
}
