<?php

namespace App\Http\Controllers;

use App\Actions\ExportPatientsPdfAction;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientReportController extends Controller
{
    public function pdf(Request $request)
    {
        $query = Patient::query();

        // Общий поиск по ФИО, телефону или email
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', '%' . $search . '%')
                    ->orWhere('phone_number', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        // Фильтр по полному имени
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

        // Фильтр по типу рака через связь monitorings
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

        // Получаем пациентов (новые записи первыми)
        $patients = $query->orderBy('id', 'desc')->get();

        $action = new ExportPatientsPdfAction();
        return $action->execute($patients);
    }
}
