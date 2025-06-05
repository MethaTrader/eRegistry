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
        // Получаем год из параметров запроса или используем текущий год
        $year = $request->input('year', Carbon::now()->year);

        // Валидация года
        if (!is_numeric($year) || $year < 2020 || $year > Carbon::now()->year + 1) {
            $year = Carbon::now()->year;
        }

        try {
            // Получаем всех пациентов, зарегистрированных в указанном году
            $patients = Patient::whereYear('created_at', $year)->get();

            // Категории – месяцы года
            $categories = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

            // Инициализируем массивы для Male и Female
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

            // Формируем структуру series для графика с улучшенными названиями
            $series = [
                [
                    'name' => 'Male',
                    'data' => $data['Male'],
                    'color' => '#667eea'
                ],
                [
                    'name' => 'Female',
                    'data' => $data['Female'],
                    'color' => '#f093fb'
                ]
            ];

            // Дополнительная статистика
            $totalMale = array_sum($data['Male']);
            $totalFemale = array_sum($data['Female']);
            $totalPatients = $totalMale + $totalFemale;

            return response()->json([
                'categories' => $categories,
                'series' => $series,
                'statistics' => [
                    'total_patients' => $totalPatients,
                    'total_male' => $totalMale,
                    'total_female' => $totalFemale,
                    'male_percentage' => $totalPatients > 0 ? round(($totalMale / $totalPatients) * 100, 1) : 0,
                    'female_percentage' => $totalPatients > 0 ? round(($totalFemale / $totalPatients) * 100, 1) : 0,
                    'year' => (int)$year
                ],
                'success' => true
            ]);

        } catch (\Exception $e) {
            // Логирование ошибки
            \Log::error('Error in PatientChartController: ' . $e->getMessage());

            return response()->json([
                'error' => 'Failed to load chart data',
                'message' => $e->getMessage(),
                'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                'series' => [
                    [
                        'name' => 'Male',
                        'data' => array_fill(0, 12, 0)
                    ],
                    [
                        'name' => 'Female',
                        'data' => array_fill(0, 12, 0)
                    ]
                ],
                'success' => false
            ], 500);
        }
    }

    /**
     * Возвращает статистику по возрастным группам для donut chart
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ageGroupStats(Request $request)
    {
        $year = $request->input('year', Carbon::now()->year);

        try {
            $patients = Patient::whereYear('created_at', $year)
                ->whereNotNull('date_of_birth')
                ->get();

            $ageGroups = [
                '18-25' => 0,
                '26-35' => 0,
                '36-45' => 0,
                '45+' => 0
            ];

            foreach ($patients as $patient) {
                $age = Carbon::parse($patient->date_of_birth)->age;

                if ($age >= 18 && $age <= 25) {
                    $ageGroups['18-25']++;
                } elseif ($age >= 26 && $age <= 35) {
                    $ageGroups['26-35']++;
                } elseif ($age >= 36 && $age <= 45) {
                    $ageGroups['36-45']++;
                } elseif ($age > 45) {
                    $ageGroups['45+']++;
                }
            }

            return response()->json([
                'labels' => array_keys($ageGroups),
                'series' => array_values($ageGroups),
                'year' => (int)$year,
                'success' => true
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in ageGroupStats: ' . $e->getMessage());

            return response()->json([
                'error' => 'Failed to load age group statistics',
                'labels' => ['18-25', '26-35', '36-45', '45+'],
                'series' => [0, 0, 0, 0],
                'success' => false
            ], 500);
        }
    }
}