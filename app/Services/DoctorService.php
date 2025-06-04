<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class DoctorService
{
    public function getFilteredDoctors(Request $request): Collection
    {
        $query = User::query();

        $this->applyFilters($query, $request);

        return $query->orderBy('id', 'desc')->get();
    }

    public function deleteDoctor(User $doctor): bool
    {
        // Проверка: только администратор может удалять доктора
        if (!auth()->user() || !auth()->user()->hasRole('admin')) {
            throw new \Illuminate\Auth\Access\AuthorizationException('You are not authorized to delete this doctor.');
        }

        return $doctor->delete();
    }

    private function applyFilters(Builder $query, Request $request): void
    {
        // Если передан параметр поиска – ищем по имени, email и месту работы
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('workplace', 'like', '%' . $search . '%');
            });
        }

        // Фильтрация по специальности
        if ($request->filled('specialty')) {
            $query->where('specialty', $request->input('specialty'));
        }

        // Фильтрация по диапазону дат (например, по дате регистрации)
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->input('from'));
        }

        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->input('to'));
        }
    }
}