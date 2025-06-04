<?php

namespace App\Services;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class PatientService
{
    public function getFilteredPatients(Request $request): Collection
    {
        $query = Patient::query();

        $this->applyFilters($query, $request);

        return $query->orderBy('id', 'desc')->get();
    }

    public function createPatient(array $validatedData): Patient
    {
        return Patient::create($validatedData);
    }

    public function updatePatient(Patient $patient, array $validatedData): Patient
    {
        $patient->update($validatedData);
        return $patient->fresh();
    }

    public function deletePatient(Patient $patient): bool
    {
        // Удаляем все мониторинги, связанные с пациентом
        $patient->monitorings()->delete();

        // Удаляем пациента
        return $patient->delete();
    }

    public function getPatientWithMonitorings(Patient $patient): Patient
    {
        return $patient->load(['monitorings' => function($query) {
            $query->orderBy('visit_date', 'asc');
        }]);
    }

    private function applyFilters(Builder $query, Request $request): void
    {
        // Общий поиск по ФИО, телефону или email
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', '%' . $search . '%')
                    ->orWhere('phone_number', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        // Фильтр по полному имени (если указан отдельно)
        if ($request->filled('full_name')) {
            $query->where('full_name', 'like', '%' . $request->input('full_name') . '%');
        }

        // Фильтр по полу
        if ($request->filled('gender')) {
            $query->where('gender', $request->input('gender'));
        }

        // Фильтр по страховому статусу
        if ($request->filled('insurance_status')) {
            $query->where('insurance_status', $request->input('insurance_status'));
        }

        // Фильтр по занятости
        if ($request->filled('occupation')) {
            $query->where('occupation', 'like', '%' . $request->input('occupation') . '%');
        }

        // Фильтр по типу рака, который находится в связанной модели Monitoring
        if ($request->filled('cancer_type')) {
            $query->whereHas('monitorings', function ($q) use ($request) {
                $q->where('cancer_type', $request->input('cancer_type'));
            });
        }

        // Фильтрация по диапазону дат регистрации (created_at)
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->input('from'));
        }

        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->input('to'));
        }
    }
}