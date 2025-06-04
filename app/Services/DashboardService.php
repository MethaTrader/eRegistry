<?php

namespace App\Services;

use App\DTO\DashboardData;
use App\Models\Patient;
use App\Models\User;

class DashboardService
{
    public function __construct(
        private StatisticsService $statisticsService
    ) {}

    public function getDashboardData(): DashboardData
    {
        return new DashboardData(
            patientsStats: $this->statisticsService->getPatientsStatistics(),
            monitoringStats: $this->statisticsService->getMonitoringStatistics(),
            doctorsStats: $this->statisticsService->getDoctorsStatistics(),
            adminsStats: $this->statisticsService->getAdminsStatistics(),
            recentDoctors: $this->getRecentDoctors(),
            recentPatients: $this->getRecentPatients(),
            currentUser: auth()->user()
        );
    }

    private function getRecentDoctors(): \Illuminate\Support\Collection
    {
        return User::role('Doctor')->latest()->take(5)->get();
    }

    private function getRecentPatients(): \Illuminate\Support\Collection
    {
        return Patient::latest()->take(10)->get();
    }
}