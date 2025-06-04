<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMonitoringRequest;
use App\Http\Requests\UpdateMonitoringRequest;
use App\Models\Monitoring;
use App\Services\MonitoringService;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    public function __construct(
        private MonitoringService $monitoringService
    ) {}

    /**
     * Display a listing of the monitoring records.
     */
    public function index(Request $request)
    {
        $monitorings = $this->monitoringService->getFilteredMonitorings($request);

        return view('monitoring.index', compact('monitorings'));
    }

    /**
     * Show the form for creating a new monitoring record.
     */
    public function create(Request $request)
    {
        $patients = $this->monitoringService->getPatientsForSelect();
        $selectedPatientId = $request->input('patient_id');

        // Загружаем последнюю запись мониторинга для этого пациента, если запрошено
        $lastMonitoring = null;
        if ($request->has('load_last') && $selectedPatientId) {
            $lastMonitoring = $this->monitoringService->getLastMonitoringForPatient($selectedPatientId);
        }

        return view('monitoring.create', compact('patients', 'selectedPatientId', 'lastMonitoring'));
    }

    public function store(StoreMonitoringRequest $request)
    {
        $this->monitoringService->createMonitoring($request->validated());

        return redirect()->back()
            ->with('success', 'Monitoring record created successfully!');
    }

    /**
     * Display the specified monitoring record.
     */
    public function show(Monitoring $monitoring)
    {
        $monitoring = $this->monitoringService->getMonitoringWithPatient($monitoring);

        return view('monitoring.show', compact('monitoring'));
    }

    /**
     * Show the form for editing the specified monitoring record.
     */
    public function edit(Monitoring $monitoring)
    {
        $patients = $this->monitoringService->getPatientsForSelect();

        return view('monitoring.edit', compact('monitoring', 'patients'));
    }

    /**
     * Update the specified monitoring record in storage.
     */
    public function update(UpdateMonitoringRequest $request, Monitoring $monitoring)
    {
        $this->monitoringService->updateMonitoring($monitoring, $request->validated());

        return redirect()->back()
            ->with('success', 'Monitoring record updated successfully!');
    }

    /**
     * Remove the specified monitoring record from storage.
     */
    public function destroy(Monitoring $monitoring)
    {
        $this->monitoringService->deleteMonitoring($monitoring);

        return redirect()->route('monitoring.index')
            ->with('success', 'Monitoring record deleted successfully!');
    }
}