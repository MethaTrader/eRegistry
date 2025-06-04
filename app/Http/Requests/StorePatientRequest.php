<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePatientRequest extends FormRequest
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
            // Basic Information
            'full_name' => 'required|string|max:255',
            'date_of_birth' => 'nullable|date_format:Y/m/d',
            'gender' => 'required|in:Male,Female,Other',
            'phone_number' => ['nullable', 'regex:/^[\d\s\-\+\(\)]{7,20}$/'],            'email' => 'required|email|unique:patients,email',
            'address' => 'nullable|string',

            // Demographic and Socioeconomic Information
            'ethnicity' => 'nullable|string|max:255',
            'race' => 'nullable|string|max:255',
            'occupation' => 'nullable|string|max:255',
            'insurance_status' => 'nullable|in:Insured,Uninsured',
            'socioeconomic_factors' => 'nullable|string',

            // Lifestyle
            'alcohol_consumption' => 'nullable|in:Never,Former,Current',
            'smoking_status' => 'nullable|in:Never,Former,Current',
            'radiation_exposure' => 'nullable|string',

            // Additional Medical Data
            'karnofsky_performance_scale' => 'nullable|integer|min:0|max:100',
            'symptoms_reported' => 'nullable|string',
            'quality_of_life_assessments' => 'nullable|string',
            'ophthalmologic_assessment' => 'nullable|string',
            'eeg_results' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'full_name.required' => 'Full Name is required.',
            'date_of_birth.date_format' => 'Date of Birth must be in DD/MM/YYYY format.',
            'gender.required' => 'Gender is required.',
            'gender.in' => 'Selected gender is invalid.',
            'phone_number.regex' => 'Phone Number must be a valid format (digits, spaces, dashes, and parentheses allowed).',
            'email.required' => 'Email Address is required.',
            'email.email' => 'Email Address must be a valid email.',
            'email.unique' => 'Email Address is already taken.',
            'insurance_status.in' => 'Selected insurance status is invalid.',
            'alcohol_consumption.in' => 'Selected alcohol consumption status is invalid.',
            'smoking_status.in' => 'Selected smoking status is invalid.',
            'karnofsky_performance_scale.integer' => 'Karnofsky Performance Scale must be an integer.',
            'karnofsky_performance_scale.min' => 'Karnofsky Performance Scale must be at least 0.',
            'karnofsky_performance_scale.max' => 'Karnofsky Performance Scale may not be greater than 100.',
            // Додаткові повідомлення можна додати за потребою
        ];
    }
}
