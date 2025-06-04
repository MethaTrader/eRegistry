<?php

namespace App\Actions;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class ExportPatientsPdfAction
{
    use AsAction;

    public function execute(Collection $patients)
    {
        // Загружаем связь monitorings для каждого пациента
        $patients->load('monitorings');

        // Рендерим представление для PDF. Файл resources/views/patient/pdf-all.blade.php
        $pdf = Pdf::loadView('patient.pdf-all', compact('patients'));

        // Формируем имя файла, например: patients_20230515_123456.pdf
        $fileName = 'patients_' . now()->format('Ymd_His') . '.pdf';

        return $pdf->download($fileName);
    }
}
