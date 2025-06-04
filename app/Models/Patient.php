<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        // Основная информация
        'full_name',
        'date_of_birth',
        'gender',
        'phone_number',
        'email',
        'address',

        // Демографическая и социально-экономическая информация
        'ethnicity',
        'race',
        'occupation',
        'insurance_status',
        'socioeconomic_factors',

        // Образ жизни
        'alcohol_consumption',
        'smoking_status',
        'radiation_exposure',

        // Дополнительные медицинские данные
        'karnofsky_performance_scale',
        'symptoms_reported',
        'quality_of_life_assessments',
        'ophthalmologic_assessment',
        'eeg_results',
    ];

    /**
     * Типы атрибутов модели.
     *
     * @var array
     */
    protected $casts = [
        'date_of_birth' => 'date',
        'karnofsky_performance_scale' => 'integer',
    ];

    public function monitorings()
    {
        return $this->hasMany(Monitoring::class);
    }

}
