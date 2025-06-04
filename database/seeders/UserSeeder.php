<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Создаем роль "Doctor", если ее еще нет
        $doctorRole = Role::firstOrCreate([
            'name'       => 'Doctor',
            'guard_name' => 'web'
        ]);

        // Создаем 10 пользователей (врачей) и назначаем каждому роль "Doctor"
        User::factory()->count(10)->create()->each(function ($user) use ($doctorRole) {
            $user->assignRole($doctorRole);
        });
    }
}
