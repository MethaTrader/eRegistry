<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PatientChartController extends Controller
{
    /**
     * Возвращает данные для графика регистрации пациентов по месяцам и полу.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // Используем текущий год
        $year = Carbon::now()->year;

        // Получаем всех пациентов, зарегистрированных в текущем году
        $patients = Patient::whereYear('created_at', $year)->get();

        // Категории – месяцы года
        $categories = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

        // Инициализируем массивы для Male и Female (Other будем игнорировать)
        $data = [
            'Male'   => array_fill(0, 12, 0),
            'Female' => array_fill(0, 12, 0)
        ];

        // Перебираем пациентов и распределяем по месяцам, учитывая только Male и Female
        foreach ($patients as $patient) {
            $month = Carbon::parse($patient->created_at)->month; // число от 1 до 12
            $gender = $patient->gender;
            if ($gender === 'Male') {
                $data['Male'][$month - 1]++;
            } elseif ($gender === 'Female') {
                $data['Female'][$month - 1]++;
            }
            // Если пол равен Other, ничего не делаем – в графике остаётся 0
        }

        // Формируем структуру series для графика
        $series = [
            [
                'name' => 'Male',
                'data' => $data['Male']
            ],
            [
                'name' => 'Female',
                'data' => $data['Female']
            ]
        ];

        return response()->json([
            'categories' => $categories,
            'series'     => $series
        ]);
    }
}
