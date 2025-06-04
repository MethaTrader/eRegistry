<?php

namespace App\Services;

use App\Models\Monitoring;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class MonitoringService
{
    public function getFilteredMonitorings(Request $request): Collection
    {
        $query = Monitoring::with('patient');

        $this->applyFilters($query, $request);

        return $query->orderBy('visit_date', 'desc')->get();
    }

    public function createMonitoring(array $validatedData): Monitoring
    {
        return Monitoring::create($validatedData);
    }

    public function updateMonitoring(Monitoring $monitoring, array $validatedData): Monitoring
    {
        $monitoring->update($validatedData);
        return $monitoring->fresh();
    }

    public function deleteMonitoring(Monitoring $monitoring): bool
    {
        return $monitoring->delete();
    }

    public function getMonitoringWithPatient(Monitoring $monitoring): Monitoring
    {
        return $monitoring->load('patient');
    }

    public function getLastMonitoringForPatient(int $patientId): ?Monitoring
    {
        return Monitoring::where('patient_id', $patientId)
            ->orderBy('id', 'desc')
            ->first();
    }

    public function getPatientsForSelect(): Collection
    {
        return Patient::select('id', 'full_name')->orderBy('full_name')->get();
    }

    private function applyFilters(Builder $query, Request $request): void
    {
        // Фильтр по имени пациента
        if ($request->filled('patient_name')) {
            $patientName = $request->input('patient_name');
            $query->whereHas('patient', function ($q) use ($patientName) {
                $q->where('full_name', 'like', '%' . $patientName . '%');
            });
        }

        // Фильтр по дате визита: от
        if ($request->filled('visit_from')) {
            $query->whereDate('visit_date', '>=', $request->input('visit_from'));
        }

        // Фильтр по дате визита: до
        if ($request->filled('visit_to')) {
            $query->whereDate('visit_date', '<=', $request->input('visit_to'));
        }

        // Фильтр по типу рака
        if ($request->filled('cancer_type')) {
            $query->where('cancer_type', $request->input('cancer_type'));
        }

        // Фильтр по стадии
        if ($request->filled('stage')) {
            $query->where('stage', 'like', '%' . $request->input('stage') . '%');
        }

        // Фильтр по грейду
        if ($request->filled('grade')) {
            $query->where('grade', 'like', '%' . $request->input('grade') . '%');
        }
    }
}