<?php

namespace App\DTO;

class DashboardData
{
    public function __construct(
        public readonly StatisticsData $patientsStats,
        public readonly StatisticsData $monitoringStats,
        public readonly StatisticsData $doctorsStats,
        public readonly StatisticsData $adminsStats,
        public readonly \Illuminate\Support\Collection $recentDoctors,
        public readonly \Illuminate\Support\Collection $recentPatients,
        public readonly \App\Models\User $currentUser
    ) {}

    public function toArray(): array
    {
        return [
            'patientsCount' => $this->patientsStats->totalCount,
            'newPatientsCurrent' => $this->patientsStats->currentMonthCount,
            'newPatientsLast' => $this->patientsStats->lastMonthCount,
            'percentChangePatients' => $this->patientsStats->percentChange,

            'onMonitoringCount' => $this->monitoringStats->totalCount,
            'newOnMonitoringCurrent' => $this->monitoringStats->currentMonthCount,
            'newOnMonitoringLast' => $this->monitoringStats->lastMonthCount,
            'percentChangeMonitoring' => $this->monitoringStats->percentChange,

            'doctorsCount' => $this->doctorsStats->totalCount,
            'newDoctorsCurrent' => $this->doctorsStats->currentMonthCount,
            'newDoctorsLast' => $this->doctorsStats->lastMonthCount,
            'percentChangeDoctors' => $this->doctorsStats->percentChange,

            'adminsCount' => $this->adminsStats->totalCount,
            'newAdminsCurrent' => $this->adminsStats->currentMonthCount,
            'newAdminsLast' => $this->adminsStats->lastMonthCount,
            'percentChangeAdmins' => $this->adminsStats->percentChange,

            'doctors' => $this->recentDoctors,
            'recentPatients' => $this->recentPatients,
            'currentUser' => $this->currentUser,
        ];
    }
}