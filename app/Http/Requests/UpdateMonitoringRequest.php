<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMonitoringRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'patient_id'            => 'required|exists:patients,id',
            'visit_date'            => 'required|date_format:Y/m/d',
            'cancer_type'           => 'nullable|string|max:100',
            'stage'                 => 'nullable|string|max:50',
            'grade'                 => 'nullable|string|max:50',
            'diagnosis_date'        => 'required|date_format:Y/m/d',
            'pathology_reports'     => 'nullable|string',
            'surgeries'             => 'nullable|string',
            'chemotherapy'          => 'nullable|string',
            'radiation_therapy'     => 'nullable|string',
            'mri_date'              => 'nullable|date_format:Y/m/d',
            'mri_findings'          => 'nullable|string',
            'ct_date'               => 'nullable|date_format:Y/m/d',
            'ct_findings'           => 'nullable|string',
            'followup_date'         => 'nullable|date_format:Y/m/d',
            'followup_results'      => 'nullable|string',
            'progression_date'      => 'nullable|date_format:Y/m/d',
            'progression_site'      => 'nullable|string',
            'progression_treatment' => 'nullable|string',
            'functional_status'     => 'nullable|string',
            'genetic_testing'       => 'nullable|string',
            'biomarker_data'        => 'nullable|string',
            'genetic_mutations'     => 'nullable|string',
        ];
    }
}
