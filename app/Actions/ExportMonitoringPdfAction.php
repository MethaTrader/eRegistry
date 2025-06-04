<?php

namespace App\Actions;

use App\Models\Monitoring;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Lorisleiva\Actions\Concerns\AsAction;

class ExportMonitoringPdfAction
{
    /**
     * Экспортирует один мониторинг (с данными пациента) в PDF.
     *
     * @param \App\Models\Monitoring $monitoring
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function execute(Monitoring $monitoring)
    {
        // Жадно загружаем связанные данные (например, пациента)
        $monitoring->load('patient');

        // Рендерим представление для PDF (файл resources/views/monitoring/pdf.blade.php)
        $pdf = Pdf::loadView('monitoring.show-monitoring-pdf', compact('monitoring'));

        // Формируем имя файла, например: monitoring_12_patient-john-doe.pdf
        $fileName = 'monitoring_' . $monitoring->id . '_' . Str::slug($monitoring->patient->full_name) . '.pdf';

        // Отдаем PDF для скачивания
        return $pdf->download($fileName);
    }
}
