<?php

namespace App\Http\Controllers;

use App\Actions\ExportPatientPdfAction;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
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

        // Получаем результаты (новые записи первыми)
        $patients = $query->orderBy('id', 'desc')->get();

        return view('patient.index', ['patients' => $patients]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('patient.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePatientRequest $request)
    {
        Patient::create($request->validated());
        return redirect()->back()->with('success', 'Patient successfully added.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        // Загружаем связанные записи мониторинга, сортируя их по дате визита (от ранней к поздней)
        $patient->load(['monitorings' => function($query) {
            $query->orderBy('visit_date', 'asc');
        }]);

        // Передаём пациента (с мониторингами) в представление
        return view('patient.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        return view('patient.edit', compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     */
    // Метод для обновления данных пациента
    public function update(UpdatePatientRequest $request, Patient $patient)
    {
        $patient->update($request->validated());
        return redirect()->back()
            ->with('success', 'Patient updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        // Удаляем все мониторинги, связанные с пациентом
        $patient->monitorings()->delete();

        // Удаляем пациента
        $patient->delete();

        return redirect()->route('patients.index')
            ->with('success', 'Patient and all associated monitorings have been deleted successfully!');
    }


    public function pdfReport(Patient $patient)
    {
        $action = new ExportPatientPdfAction();
        return $action->execute($patient);
    }
}
