<?php

namespace App\Actions;

use App\Http\Requests\StoreDoctorRequest;
use App\Models\User;
use Hash;
use Lorisleiva\Actions\Concerns\AsAction;
use Spatie\Permission\Models\Role;
use Str;

class CreateDoctorAction
{
    use AsAction;

    public function execute(StoreDoctorRequest $request): User
    {
        // Генерация случайного пароля (например, 12 символов)
        $generatedPassword = Str::random(12);

        // Получаем проверенные данные
        $data = $request->validated();

        // Хешируем пароль
        $data['password'] = Hash::make($generatedPassword);

        // Создаем нового пользователя (врача)
        $doctor = User::create($data);

        // Определяем роль из данных запроса
        $roleName = $data['role'];

        // Если такой роли нет для guard "web", создаем её
        $role = Role::firstOrCreate(
            ['name' => $roleName, 'guard_name' => 'web']
        );

        // Назначаем роль, переданную в форме (например, 'Doctor')
        $doctor->assignRole($role);

        // Если нужно вернуть сгенерированный пароль для уведомления, можно добавить его как временное свойство
        $doctor->generatedPassword = $generatedPassword;

        return $doctor;
    }
}
