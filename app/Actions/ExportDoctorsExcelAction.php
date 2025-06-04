<?php

namespace App\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Rap2hpoutre\FastExcel\FastExcel;

class ExportDoctorsExcelAction
{
    use AsAction;

    public function execute($doctors)
    {
        // Преобразуем коллекцию докторов в массив данных для экспорта
        $data = $doctors->map(function ($doctor) {
            return [
                'Doctor ID'             => 'D-' . str_pad($doctor->id, 4, '0', STR_PAD_LEFT),
                'Name'                  => $doctor->name,
                'Email'                 => $doctor->email,
                'Workplace'             => $doctor->workplace ?? 'N/A',
                'Specialty'             => $doctor->specialty ?? 'N/A',
                'Role'                  => $doctor->getRoleNames()->first(),
                'Registration Date'     => $doctor->created_at ? $doctor->created_at->format('d.m.Y') : 'N/A',
                'Additional Information'=> $doctor->additional_information ?? '',
            ];
        });

        $fileName = 'doctors_report_' . now()->format('Ymd_His') . '.xlsx';

        return (new FastExcel($data))->download($fileName);
    }
}
