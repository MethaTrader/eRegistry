<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMonitoringRequest;
use App\Http\Requests\UpdateMonitoringRequest;
use App\Models\Monitoring;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MonitoringController extends Controller
{
    /**
     * Display a listing of the monitoring records.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Monitoring::with('patient');

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

        $monitorings = $query->orderBy('visit_date', 'desc')->get();

        return view('monitoring.index', compact('monitorings'));
    }

    /**
     * Show the form for creating a new monitoring record.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        // Получаем список пациентов для выбора в форме
        $patients = Patient::select('id', 'full_name')->orderBy('full_name')->get();

        // Получаем выбранный ID пациента из GET-параметров (если передан)
        $selectedPatientId = $request->input('patient_id');

        // Если указан параметр load_last и выбран пациент,
        // загружаем последнюю запись мониторинга для этого пациента
        $lastMonitoring = null;
        if ($request->has('load_last') && $selectedPatientId) {
            $lastMonitoring = Monitoring::where('patient_id', $selectedPatientId)
                ->orderBy('id', 'desc')
                ->first();
        }

        return view('monitoring.create', compact('patients', 'selectedPatientId', 'lastMonitoring'));
    }


    public function store(StoreMonitoringRequest $request)
    {
        $data = $request->validated();

        // Если вы раньше обрабатывали файлы через $request->hasFile(), теперь это текстовые поля,
        // поэтому можно сразу создать запись
        Monitoring::create($data);

        return redirect()->back()
            ->with('success', 'Monitoring record created successfully!');
    }



    /**
     * Display the specified monitoring record.
     *
     * @param Monitoring $monitoring
     * @return \Illuminate\View\View
     */
    public function show(Monitoring $monitoring)
    {
        // Жадно загружаем связанные данные, например, данные пациента
        $monitoring->load('patient');
        return view('monitoring.show', compact('monitoring'));
    }

    /**
     * Show the form for editing the specified monitoring record.
     *
     * @param Monitoring $monitoring
     * @return \Illuminate\View\View
     */
    public function edit(Monitoring $monitoring)
    {
        $patients = \App\Models\Patient::select('id', 'full_name')->orderBy('full_name')->get();
        return view('monitoring.edit', compact('monitoring', 'patients'));
    }

    /**
     * Update the specified monitoring record in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Monitoring $monitoring
     * @return RedirectResponse
     */
    public function update(UpdateMonitoringRequest $request, Monitoring $monitoring)
    {
        $data = $request->validated();

        $monitoring->update($data);

        return redirect()->back()
            ->with('success', 'Monitoring record updated successfully!');
    }

    /**
     * Remove the specified monitoring record from storage.
     */
    public function destroy(Monitoring $monitoring)
    {
        $monitoring->delete();

        return redirect()->route('monitoring.index')
            ->with('success', 'Monitoring record deleted successfully!');
    }

}
