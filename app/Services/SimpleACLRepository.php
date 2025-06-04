<?php

namespace App\Services;

use Alexusmai\LaravelFileManager\Services\ACLService\ACLRepository;

class SimpleACLRepository implements ACLRepository
{
    /**
     * Get access level for path
     *
     * @param string $disk
     * @param string $path
     * @return int
     */
    public function getAccessLevel($disk, $path): int
    {
        // Если пользователь не авторизован
        if (!auth()->check()) {
            return 0; // deny
        }

        // Для всех авторизованных пользователей - полный доступ
        return 2; // read/write
    }

    /**
     * Get rules list from repository
     *
     * @return array
     */
    public function getRules(): array
    {
        if (!auth()->check()) {
            return [];
        }

        $userId = auth()->id();

        return [
            [
                'disk' => 'public',
                'path' => '/',
                'access' => 2,
                'user_id' => $userId
            ],
            [
                'disk' => 'public',
                'path' => 'monitoring/*',
                'access' => 2,
                'user_id' => $userId
            ]
        ];
    }

    public function getUserID()
    {
        // TODO: Implement getUserID() method.
    }
}