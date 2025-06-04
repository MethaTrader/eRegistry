<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Actions\ExportDoctorPdfAction;
use App\Actions\ExportDoctorsExcelAction;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DoctorReportController extends Controller
{
    public function pdf(Request $request)
    {
        $query = User::query();

        // Если передан параметр ids, то экспортируем только выбранные записи
        if ($request->filled('ids')) {
            $ids = explode(',', $request->input('ids'));
            $query->whereIn('id', $ids);
        } else {
            // Фильтры
            if ($request->filled('search')) {
                $search = $request->input('search');
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhere('workplace', 'like', '%' . $search . '%');
                });
            }
            if ($request->filled('specialty')) {
                $query->where('specialty', $request->input('specialty'));
            }
            if ($request->filled('from')) {
                $query->whereDate('created_at', '>=', $request->input('from'));
            }
            if ($request->filled('to')) {
                $query->whereDate('created_at', '<=', $request->input('to'));
            }
        }
        $doctors = $query->orderBy('id', 'desc')->get();
        $action = new ExportDoctorPdfAction();
        return $action->execute($doctors);
    }

    public function excel(Request $request)
    {
        $query = User::query();

        if ($request->filled('ids')) {
            $ids = explode(',', $request->input('ids'));
            $query->whereIn('id', $ids);
        } else {
            if ($request->filled('search')) {
                $search = $request->input('search');
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhere('workplace', 'like', '%' . $search . '%');
                });
            }
            if ($request->filled('specialty')) {
                $query->where('specialty', $request->input('specialty'));
            }
            if ($request->filled('from')) {
                $query->whereDate('created_at', '>=', $request->input('from'));
            }
            if ($request->filled('to')) {
                $query->whereDate('created_at', '<=', $request->input('to'));
            }
        }
        $doctors = $query->orderBy('id', 'desc')->get();
        $action = new ExportDoctorsExcelAction();
        return $action->execute($doctors);
    }
}
