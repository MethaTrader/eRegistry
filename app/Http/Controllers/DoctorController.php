<?php

namespace App\Http\Controllers;

use App\Actions\CreateDoctorAction;
use App\Actions\UpdateDoctorAction;
use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Models\User;
use App\Services\DoctorService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;

class DoctorController extends Controller
{
    public function __construct(
        private DoctorService $doctorService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $doctors = $this->doctorService->getFilteredDoctors($request);

        return view('doctor.index', ['doctors' => $doctors]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('doctor.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDoctorRequest $request, CreateDoctorAction $action)
    {
        $doctor = $action->execute($request);

        return redirect()->back()->with([
            'credentials' => [
                'role'     => $doctor->getRoleNames()->first(),
                'email'    => $doctor->email,
                'password' => $doctor->generatedPassword,
            ],
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $doctor)
    {
        return view('doctor.show', ['doctor' => $doctor]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $doctor)
    {
        return view('doctor.edit', ['doctor' => $doctor]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDoctorRequest $request, User $doctor, UpdateDoctorAction $action)
    {
        $doctor = $action->execute($request, $doctor);

        return redirect()->back()->with('success', 'Doctor updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $doctor)
    {
        try {
            $this->doctorService->deleteDoctor($doctor);

            return redirect()->route('doctors.index')
                ->with('success', 'Doctor deleted successfully!');
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            abort(403, $e->getMessage());
        }
    }

    public function pdfReport(User $doctor)
    {
        $pdf = Pdf::loadView('doctor.show-doctor-pdf', ['doctor' => $doctor]);
        return $pdf->download('doctor_' . $doctor->name . '.pdf');
    }

    public function excelReport(User $doctor)
    {
        $data = [
            [
                'Doctor ID'             => 'D-' . str_pad($doctor->id, 4, '0', STR_PAD_LEFT),
                'Name'                  => $doctor->name,
                'Email'                 => $doctor->email,
                'Workplace'             => $doctor->workplace ?? 'N/A',
                'Specialty'             => $doctor->specialty ?? 'N/A',
                'Role'                  => $doctor->getRoleNames()->first(),
                'Registration Date'     => $doctor->created_at ? $doctor->created_at->format('d.m.Y') : 'N/A',
                'Additional Information'=> $doctor->additional_information ?? '',
            ]
        ];

        $collection = collect($data);
        $fileName = 'report_' . now()->format('Ymd_His') . '.xlsx';

        return (new FastExcel($collection))->download($fileName);
    }
}