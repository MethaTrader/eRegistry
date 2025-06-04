<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePatientRequest extends FormRequest
{
    public function authorize()
    {
        // Здесь можно добавить проверку прав доступа, если необходимо
        return true;
    }

    public function rules()
    {
        return [
            // Основная информация
            'full_name'       => 'required|string|max:255',
            'date_of_birth'   => 'nullable|date_format:"d/m/Y"',
            'gender'          => 'required|in:Male,Female,Other',
            'phone_number'    => 'nullable|string|max:20',
            'email'           => 'required|email|max:255',
            'address'         => 'nullable|string',

            // Демографическая и социально-экономическая информация
            'ethnicity'             => 'nullable|string|max:100',
            'race'                  => 'nullable|string|max:100',
            'occupation'            => 'nullable|string|max:255',
            'insurance_status'      => 'nullable|in:Insured,Uninsured',
            'socioeconomic_factors' => 'nullable|string',

            // Образ жизни
            'alcohol_consumption'   => 'nullable|in:Never,Former,Current',
            'smoking_status'        => 'nullable|in:Never,Former,Current',
            'radiation_exposure'    => 'nullable|string',

            // Дополнительные медицинские данные
            'karnofsky_performance_scale' => 'nullable|integer|min:0|max:100',
            'symptoms_reported'           => 'nullable|string',
            'quality_of_life_assessments' => 'nullable|string',
            'ophthalmologic_assessment'   => 'nullable|string',
            'eeg_results'                 => 'nullable|string',
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->filled('date_of_birth')) {
            $dob = trim($this->date_of_birth);
            try {
                $converted = \Carbon\Carbon::createFromFormat('d/m/Y', $dob)->format('Y-m-d');
                $this->merge(['date_of_birth' => $converted]);
            } catch (\Exception $e) {
                // Если формат не соответствует, можно либо оставить значение как есть, либо установить null.
                // Здесь устанавливаем null, чтобы затем сработала валидация.
                $this->merge(['date_of_birth' => null]);
            }
        }
    }
}
