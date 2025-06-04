<?php

namespace App\Actions;

use App\Http\Requests\UpdateDoctorRequest;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;
use Spatie\Permission\Models\Role;

class UpdateDoctorAction
{
    use AsAction;

    public function execute(UpdateDoctorRequest $request, User $doctor): User
    {
        $data = $request->validated();

        // Обновляем данные врача
        $doctor->update($data);

        // Определяем роль из данных запроса
        $roleName = $data['role'];

        // Если такой роли нет для guard "web", создаем её
        $role = Role::firstOrCreate(
            ['name' => $roleName, 'guard_name' => 'web']
        );

        // Обновляем роль: синхронизируем роли согласно новому значению
        $doctor->syncRoles($role);

        return $doctor;
    }
}
