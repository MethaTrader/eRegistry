<?php

namespace App\Http\Controllers;

use App\Actions\ExportPatientPdfAction;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Models\Patient;
use App\Services\PatientService;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function __construct(
        private PatientService $patientService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $patients = $this->patientService->getFilteredPatients($request);

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
        $this->patientService->createPatient($request->validated());

        return redirect()->back()->with('success', 'Patient successfully added.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        $patient = $this->patientService->getPatientWithMonitorings($patient);

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
    public function update(UpdatePatientRequest $request, Patient $patient)
    {
        $this->patientService->updatePatient($patient, $request->validated());

        return redirect()->back()
            ->with('success', 'Patient updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        $this->patientService->deletePatient($patient);

        return redirect()->route('patients.index')
            ->with('success', 'Patient and all associated monitorings have been deleted successfully!');
    }

    public function pdfReport(Patient $patient)
    {
        $action = new ExportPatientPdfAction();
        return $action->execute($patient);
    }
}