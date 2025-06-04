<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Задаем границы для текущего и прошлого месяца
        $startOfCurrentMonth = Carbon::now()->startOfMonth();
        $endOfCurrentMonth   = Carbon::now()->endOfMonth();
        $startOfLastMonth    = Carbon::now()->subMonth()->startOfMonth();
        $endOfLastMonth      = Carbon::now()->subMonth()->endOfMonth();

        // --- Patients ---
        $patientsCount      = Patient::count();
        $newPatientsCurrent = Patient::whereBetween('created_at', [$startOfCurrentMonth, $endOfCurrentMonth])->count();
        $newPatientsLast    = Patient::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();
        $percentChangePatients = ($newPatientsLast > 0)
            ? round((($newPatientsCurrent - $newPatientsLast) / $newPatientsLast) * 100)
            : 0;

        // --- On Monitoring --- (количество пациентов, у которых есть хотя бы один мониторинг)
        $onMonitoringCount = Patient::whereHas('monitorings')->count();
        $newOnMonitoringCurrent = Patient::whereHas('monitorings', function($query) use ($startOfCurrentMonth, $endOfCurrentMonth) {
            $query->whereBetween('created_at', [$startOfCurrentMonth, $endOfCurrentMonth]);
        })->distinct()->count();
        $newOnMonitoringLast = Patient::whereHas('monitorings', function($query) use ($startOfLastMonth, $endOfLastMonth) {
            $query->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth]);
        })->distinct()->count();
        $percentChangeMonitoring = ($newOnMonitoringLast > 0)
            ? round((($newOnMonitoringCurrent - $newOnMonitoringLast) / $newOnMonitoringLast) * 100)
            : 0;

        // --- Doctors --- (Пользователи с ролью "Doctor")
        // Если роли не существуют, они будут созданы
        $doctorRole = \Spatie\Permission\Models\Role::firstOrCreate(
            ['name' => 'Doctor', 'guard_name' => 'web']
        );
        $doctorsCount = \App\Models\User::role($doctorRole->name)->count();
        $newDoctorsCurrent = \App\Models\User::role($doctorRole->name)
            ->whereBetween('created_at', [$startOfCurrentMonth, $endOfCurrentMonth])
            ->count();
        $newDoctorsLast = \App\Models\User::role($doctorRole->name)
            ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
            ->count();
        $percentChangeDoctors = ($newDoctorsLast > 0)
            ? round((($newDoctorsCurrent - $newDoctorsLast) / $newDoctorsLast) * 100)
            : 0;

        // --- Admins --- (Пользователи с ролью "Admin")
        $adminRole = \Spatie\Permission\Models\Role::firstOrCreate(
            ['name' => 'Admin', 'guard_name' => 'web']
        );
        $adminsCount = \App\Models\User::role($adminRole->name)->count();
        $newAdminsCurrent = \App\Models\User::role($adminRole->name)
            ->whereBetween('created_at', [$startOfCurrentMonth, $endOfCurrentMonth])
            ->count();
        $newAdminsLast = \App\Models\User::role($adminRole->name)
            ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
            ->count();
        $percentChangeAdmins = ($newAdminsLast > 0)
            ? round((($newAdminsCurrent - $newAdminsLast) / $newAdminsLast) * 100)
            : 0;

        // Получаем текущего пользователя для приветствия
        $currentUser = auth()->user();

        $doctors = \App\Models\User::role('Doctor')->latest()->take(5)->get();
        // Последние 10 добавленных пациентов (сортировка по дате регистрации)
        $recentPatients = Patient::latest()->take(10)->get();

        return view('home', compact(
            'patientsCount',
            'newPatientsCurrent',
            'newPatientsLast',
            'percentChangePatients',
            'onMonitoringCount',
            'newOnMonitoringCurrent',
            'newOnMonitoringLast',
            'percentChangeMonitoring',
            'doctorsCount',
            'newDoctorsCurrent',
            'newDoctorsLast',
            'percentChangeDoctors',
            'adminsCount',
            'newAdminsCurrent',
            'newAdminsLast',
            'percentChangeAdmins',
            'currentUser',
            'doctors',
            'recentPatients'
        ));
    }


}
