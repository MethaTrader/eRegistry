<?php

namespace App\Actions;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class ExportDoctorPdfAction
{
    use AsAction;

    public function execute($data)
    {
        // Если передан одиночный объект, оборачиваем его в коллекцию
        if (!($data instanceof Collection)) {
            $doctors = collect([$data]);
            $fileName = 'doctor_' . $data->name . '_' . now()->format('Ymd_His') . '.pdf';
        } else {
            $doctors = $data;
            $fileName = 'doctors_report_' . now()->format('Ymd_His') . '.pdf';
        }

        // Выбираем представление для экспорта всех моделей в виде карточек
        $view = 'doctor.reports.pdf-all';

        $pdf = Pdf::loadView($view, ['doctors' => $doctors]);

        return $pdf->download($fileName);
    }
}
