<?php

use App\Actions\ExportMonitoringPdfAction;
use App\Http\Controllers\API\PatientChartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\DoctorReportController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PatientReportController;
use App\Http\Controllers\TrainingController;
use App\Models\Monitoring;
use Illuminate\Support\Facades\Route;


Route::redirect('/', '/dashboard');

// Группа маршрутов для гостей (неавторизованных пользователей)
Route::middleware('guest')->group(function () {
    // Показ формы входа
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    // Обработка отправки формы входа
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
});

// Группа маршрутов для авторизованных пользователей
Route::middleware('auth')->group(function () {
    // Домашняя страница
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('home');

// Training Materials Routes - Add these lines
    Route::get('/training', [TrainingController::class, 'index'])->name('training.index');
    Route::get('/training/{id}', [TrainingController::class, 'show'])->name('training.show');


    // Ресурсы
    Route::resource('patients', PatientController::class);
    Route::resource('doctors', DoctorController::class);
    Route::resource('monitoring', MonitoringController::class);

    // Дополнительные маршруты для мониторинга
    Route::get('/monitoring/last', [MonitoringController::class, 'last'])->name('monitoring.last');
    // Маршрут для скачивания файла
    Route::get('/monitoring/{monitoring}/download/{file}', [MonitoringController::class, 'downloadFile'])->name('monitoring.download');

    // Экспорт для отдельной модели (страница show)
    Route::get('/doctors/{doctor}/pdf', [DoctorController::class, 'pdfReport'])->name('doctors.pdf');
    Route::get('/doctors/{doctor}/excel', [DoctorController::class, 'excelReport'])->name('doctors.excel');

    // Экспорт списка с фильтрацией (страница index)
    Route::get('/reports/doctors/pdf', [DoctorReportController::class, 'pdf'])->name('doctors.reports.pdf');
    Route::get('/reports/doctors/excel', [DoctorReportController::class, 'excel'])->name('doctors.reports.excel');

    // Экспорт для пациента
    Route::get('/patients/{patient}/pdf', [PatientController::class, 'pdfReport'])->name('patients.pdf');
    Route::get('/reports/patients/pdf', [PatientReportController::class, 'pdf'])->name('patients.reports.pdf');


    // Экспорт PDF для мониторинга через Action
    Route::get('/monitoring/{monitoring}/pdf', function(Monitoring $monitoring) {
        $action = new ExportMonitoringPdfAction();
        return $action->execute($monitoring);
    })->name('monitoring.pdf');

    // Выход из системы
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

//Route::redirect('/','/dashboard');

// API маршруты для графиков (обновленные)
Route::get('api/chart/patients', [PatientChartController::class, 'index']);
Route::get('api/chart/patients/age-groups', [PatientChartController::class, 'ageGroupStats']);