<?php

namespace App\Services;

use App\DTO\StatisticsData;
use App\Models\Patient;
use App\Models\User;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;

class StatisticsService
{
    private Carbon $startOfCurrentMonth;
    private Carbon $endOfCurrentMonth;
    private Carbon $startOfLastMonth;
    private Carbon $endOfLastMonth;

    public function __construct()
    {
        $this->startOfCurrentMonth = Carbon::now()->startOfMonth();
        $this->endOfCurrentMonth = Carbon::now()->endOfMonth();
        $this->startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $this->endOfLastMonth = Carbon::now()->subMonth()->endOfMonth();
    }

    public function getPatientsStatistics(): StatisticsData
    {
        $totalCount = Patient::count();

        $currentMonthCount = Patient::whereBetween('created_at', [
            $this->startOfCurrentMonth,
            $this->endOfCurrentMonth
        ])->count();

        $lastMonthCount = Patient::whereBetween('created_at', [
            $this->startOfLastMonth,
            $this->endOfLastMonth
        ])->count();

        return StatisticsData::create($totalCount, $currentMonthCount, $lastMonthCount);
    }

    public function getMonitoringStatistics(): StatisticsData
    {
        $totalCount = Patient::whereHas('monitorings')->count();

        $currentMonthCount = Patient::whereHas('monitorings', function($query) {
            $query->whereBetween('created_at', [
                $this->startOfCurrentMonth,
                $this->endOfCurrentMonth
            ]);
        })->distinct()->count();

        $lastMonthCount = Patient::whereHas('monitorings', function($query) {
            $query->whereBetween('created_at', [
                $this->startOfLastMonth,
                $this->endOfLastMonth
            ]);
        })->distinct()->count();

        return StatisticsData::create($totalCount, $currentMonthCount, $lastMonthCount);
    }

    public function getDoctorsStatistics(): StatisticsData
    {
        $doctorRole = $this->ensureRoleExists('Doctor');

        $totalCount = User::role($doctorRole->name)->count();

        $currentMonthCount = User::role($doctorRole->name)
            ->whereBetween('created_at', [
                $this->startOfCurrentMonth,
                $this->endOfCurrentMonth
            ])
            ->count();

        $lastMonthCount = User::role($doctorRole->name)
            ->whereBetween('created_at', [
                $this->startOfLastMonth,
                $this->endOfLastMonth
            ])
            ->count();

        return StatisticsData::create($totalCount, $currentMonthCount, $lastMonthCount);
    }

    public function getAdminsStatistics(): StatisticsData
    {
        $adminRole = $this->ensureRoleExists('Admin');

        $totalCount = User::role($adminRole->name)->count();

        $currentMonthCount = User::role($adminRole->name)
            ->whereBetween('created_at', [
                $this->startOfCurrentMonth,
                $this->endOfCurrentMonth
            ])
            ->count();

        $lastMonthCount = User::role($adminRole->name)
            ->whereBetween('created_at', [
                $this->startOfLastMonth,
                $this->endOfLastMonth
            ])
            ->count();

        return StatisticsData::create($totalCount, $currentMonthCount, $lastMonthCount);
    }

    private function ensureRoleExists(string $roleName): Role
    {
        return Role::firstOrCreate(
            ['name' => $roleName, 'guard_name' => 'web']
        );
    }
}