<?php

namespace App\Http\Controllers;

use App\Actions\CreateDoctorAction;
use App\Actions\UpdateDoctorAction;
use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Hash;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;
use Str;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Начинаем запрос ко всем пользователям (для гибкости поиска)
        $query = User::query();

        // Если передан параметр поиска – ищем по имени, email и месту работы
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('workplace', 'like', '%' . $search . '%');
            });
        }

        // Фильтрация по специальности
        if ($request->filled('specialty')) {
            $query->where('specialty', $request->input('specialty'));
        }

        // Фильтрация по диапазону дат (например, по дате регистрации)
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->input('from'));
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->input('to'));
        }

        // Получаем результаты с сортировкой (последние добавленные первыми)
        $users = $query->orderBy('id', 'desc')->get();

        // Передаём данные в представление (для совместимости оставляем переменную $doctors)
        return view('doctor.index', ['doctors' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('doctor.create'); // Переконайтесь, що цей шаблон існує
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
        // Проверка: только администратор может удалять доктора
        if (!auth()->user() || !auth()->user()->hasRole('Administrator')) {
            abort(403, 'You are not authorized to delete this doctor.');
        }

        $doctor->delete();

        return redirect()->route('doctors.index')
            ->with('success', 'Doctor deleted successfully!');
    }


    public function pdfReport(User $doctor)
    {
        // Подготовим данные для отчёта. Можно переиспользовать данные, которые уже есть у врача.
        // Здесь создаётся представление, похожее на show.blade.php, но адаптированное для PDF.
        $pdf = Pdf::loadView('doctor.show-doctor-pdf', ['doctor' => $doctor]);

        // Отдаем PDF для скачивания с именем файла, например: doctor_14.pdf
        return $pdf->download('doctor_' . $doctor->name . '.pdf');
    }

    public function excelReport(User $doctor)
    {
        // Формируем данные для экспорта в виде массива
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

        // Оборачиваем данные в коллекцию
        $collection = collect($data);

        // Формируем имя файла с текущей датой и временем
        $fileName = 'report_' . now()->format('Ymd_His') . '.xlsx';

        // Генерируем и отдаём Excel-файл для скачивания
        return (new FastExcel($collection))->download($fileName);
    }
}
