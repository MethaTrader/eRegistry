<?php

namespace App\Actions;

use App\Models\Patient;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Lorisleiva\Actions\Concerns\AsAction;

class ExportPatientPdfAction
{
    use AsAction;

    /**
     * Экспортирует пациента со всеми мониторингами в PDF.
     *
     * @param Patient $patient
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function execute(Patient $patient)
    {
        // Жадно загружаем мониторинги
        $patient->load('monitorings');

        // Рендерим представление для PDF (файл resources/views/patient/pdf.blade.php)
        $pdf = Pdf::loadView('patient.show-patient', compact('patient'));

        // Формируем имя файла: patient_{id}_{slug(name)}.pdf
        $fileName = 'patient_' . $patient->id . '_' . Str::slug($patient->full_name) . '.pdf';

        // Отдаем PDF для скачивания
        return $pdf->download($fileName);
    }
}
