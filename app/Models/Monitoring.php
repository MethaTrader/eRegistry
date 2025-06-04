<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Monitoring extends Model
{
    // Указываем имя таблицы, если оно не совпадает с именем модели во множественном числе
    protected $table = 'monitoring';

    // Поля, разрешённые для массового заполнения
    protected $fillable = [
        'patient_id',
        'visit_date',
        'diagnosis_date',
        'cancer_type',
        'stage',
        'grade',
        'pathology_reports',
        'surgeries',
        'chemotherapy',
        'radiation_therapy',
        'mri_date',
        'mri_findings',
        'ct_date',
        'ct_findings',
        'followup_date',
        'followup_results',
        'progression_date',
        'progression_site',
        'progression_treatment',
        'functional_status',
        'genetic_testing',
        'biomarker_data',
        'genetic_mutations',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

}
