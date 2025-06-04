<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Patients Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            padding: 20px;
        }
        .patient-section {
            margin-bottom: 30px;
            border-bottom: 1px solid #333;
            padding-bottom: 10px;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 8px;
        }
        .info-block p {
            margin: 3px 0;
        }
        .info-block strong {
            display: inline-block;
            width: 220px;
        }
        .monitoring {
            margin-left: 20px;
            padding-left: 10px;
            border-left: 2px solid #ccc;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Patients Report</h1>
    @foreach($patients as $patient)
        <div class="patient-section">
            <div class="section-title">Patient: {{ $patient->full_name }} (ID: {{ 'P-' . str_pad($patient->id, 6, '0', STR_PAD_LEFT) }})</div>
            <div class="info-block">
                <p><strong>Date of Birth:</strong> {{ $patient->date_of_birth ? \Carbon\Carbon::parse($patient->date_of_birth)->format('d M Y') : 'N/A' }}</p>
                <p><strong>Gender:</strong> {{ $patient->gender }}</p>
                <p><strong>Phone Number:</strong> {{ $patient->phone_number ?? 'N/A' }}</p>
                <p><strong>Email:</strong> {{ $patient->email }}</p>
                <p><strong>Address:</strong> {{ $patient->address ?? 'N/A' }}</p>
                <p><strong>Ethnicity:</strong> {{ $patient->ethnicity ?? 'N/A' }}</p>
                <p><strong>Race:</strong> {{ $patient->race ?? 'N/A' }}</p>
                <p><strong>Occupation:</strong> {{ $patient->occupation ?? 'N/A' }}</p>
                <p><strong>Insurance Status:</strong> {{ $patient->insurance_status ?? 'N/A' }}</p>
                <p><strong>Socioeconomic Factors:</strong> {{ $patient->socioeconomic_factors ?? 'N/A' }}</p>
                <p><strong>Alcohol Consumption:</strong> {{ $patient->alcohol_consumption ?? 'N/A' }}</p>
                <p><strong>Smoking Status:</strong> {{ $patient->smoking_status ?? 'N/A' }}</p>
                <p><strong>Radiation Exposure:</strong> {{ $patient->radiation_exposure ?? 'N/A' }}</p>
                <p><strong>Karnofsky Performance Scale:</strong> {{ $patient->karnofsky_performance_scale ?? 'N/A' }}</p>
                <p><strong>Symptoms Reported:</strong> {{ $patient->symptoms_reported ?? 'N/A' }}</p>
                <p><strong>Quality of Life Assessments:</strong> {{ $patient->quality_of_life_assessments ?? 'N/A' }}</p>
                <p><strong>Ophthalmologic Assessment:</strong> {{ $patient->ophthalmologic_assessment ?? 'N/A' }}</p>
                <p><strong>EEG Results:</strong> {{ $patient->eeg_results ?? 'N/A' }}</p>
            </div>
            <div class="section-title">Monitorings</div>
            @if($patient->monitorings->count())
                @foreach($patient->monitorings->sortBy('visit_date') as $monitoring)
                    <div class="monitoring">
                        <p><strong>Visit Date:</strong> {{ \Carbon\Carbon::parse($monitoring->visit_date)->format('d M Y') }}</p>
                        <p><strong>Diagnosis Date:</strong> {{ \Carbon\Carbon::parse($monitoring->diagnosis_date)->format('d M Y') }}</p>
                        <p><strong>Cancer Type:</strong> {{ $monitoring->cancer_type ?: 'N/A' }}</p>
                        <p><strong>Stage:</strong> {{ $monitoring->stage ?: 'N/A' }}</p>
                        <p><strong>Grade:</strong> {{ $monitoring->grade ?: 'N/A' }}</p>
                        <p><strong>Follow-up Date:</strong> {{ $monitoring->followup_date ? \Carbon\Carbon::parse($monitoring->followup_date)->format('d M Y') : 'N/A' }}</p>
                        <p><strong>Follow-up Results:</strong> {{ $monitoring->followup_results ?: 'N/A' }}</p>
                        <p><strong>Disease Progression Date:</strong> {{ $monitoring->progression_date ? \Carbon\Carbon::parse($monitoring->progression_date)->format('d M Y') : 'N/A' }}</p>
                        <p><strong>Progression Site:</strong> {{ $monitoring->progression_site ?: 'N/A' }}</p>
                        <p><strong>Progression Treatment:</strong> {{ $monitoring->progression_treatment ?: 'N/A' }}</p>
                        <p><strong>Functional Status:</strong> {{ $monitoring->functional_status ?: 'N/A' }}</p>
                        <p><strong>Genetic Testing:</strong> {{ $monitoring->genetic_testing ?: 'N/A' }}</p>
                        <p><strong>Biomarker Data:</strong> {{ $monitoring->biomarker_data ?: 'N/A' }}</p>
                        <p><strong>Genetic Mutations:</strong> {{ $monitoring->genetic_mutations ?: 'N/A' }}</p>
                    </div>
                @endforeach
            @else
                <p>No monitorings found.</p>
            @endif
        </div>
    @endforeach
</div>
</body>
</html>
