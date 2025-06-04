<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Patient Report</title>
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
        .header, .section {
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .header p {
            margin: 2px 0;
        }
        .section-title {
            font-size: 18px;
            border-bottom: 1px solid #333;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
        .info-block {
            margin-bottom: 10px;
        }
        .info-block strong {
            display: inline-block;
            width: 200px;
        }
        .monitoring-record {
            border: 1px solid #ddd;
            padding: 10px 15px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        .monitoring-record h3 {
            font-size: 16px;
            margin-bottom: 8px;
            color: #2196F3;
        }
        .monitoring-record .info-line {
            margin-bottom: 4px;
        }
        .info-line strong {
            display: inline-block;
            width: 180px;
        }
        .file-status {
            font-style: italic;
            color: #555;
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Patient Header -->
    <div class="header">
        <h1>Patient Report</h1>
        <div class="info-block">
            <p><strong>Full Name:</strong> {{ $patient->full_name }}</p>
            <p><strong>Date of Birth:</strong> {{ $patient->date_of_birth ? \Carbon\Carbon::parse($patient->date_of_birth)->format('d M Y') : 'N/A' }}</p>
            <p><strong>Gender:</strong> {{ $patient->gender }}</p>
            <p><strong>Phone Number:</strong> {{ $patient->phone_number ?? 'N/A' }}</p>
            <p><strong>Email:</strong> {{ $patient->email }}</p>
            <p><strong>Address:</strong> {{ $patient->address ?? 'N/A' }}</p>
        </div>
        <div class="info-block">
            <p><strong>Ethnicity:</strong> {{ $patient->ethnicity ?? 'N/A' }}</p>
            <p><strong>Race:</strong> {{ $patient->race ?? 'N/A' }}</p>
            <p><strong>Occupation:</strong> {{ $patient->occupation ?? 'N/A' }}</p>
            <p><strong>Insurance Status:</strong> {{ $patient->insurance_status ?? 'N/A' }}</p>
            <p><strong>Socioeconomic Factors:</strong> {{ $patient->socioeconomic_factors ?? 'N/A' }}</p>
        </div>
        <div class="info-block">
            <p><strong>Alcohol Consumption:</strong> {{ $patient->alcohol_consumption ?? 'N/A' }}</p>
            <p><strong>Smoking Status:</strong> {{ $patient->smoking_status ?? 'N/A' }}</p>
            <p><strong>Radiation Exposure:</strong> {{ $patient->radiation_exposure ?? 'N/A' }}</p>
            <p><strong>Karnofsky Performance Scale:</strong> {{ $patient->karnofsky_performance_scale ?? 'N/A' }}</p>
        </div>
        <div class="info-block">
            <p><strong>Symptoms Reported:</strong> {{ $patient->symptoms_reported ?? 'N/A' }}</p>
            <p><strong>Quality of Life Assessments:</strong> {{ $patient->quality_of_life_assessments ?? 'N/A' }}</p>
            <p><strong>Ophthalmologic Assessment:</strong> {{ $patient->ophthalmologic_assessment ?? 'N/A' }}</p>
            <p><strong>EEG Results:</strong> {{ $patient->eeg_results ?? 'N/A' }}</p>
        </div>
    </div>

    <!-- Monitoring Records Section -->
    <div class="section">
        <div class="section-title">Monitoring Records</div>
        @if($patient->monitorings->count())
            @foreach($patient->monitorings->sortBy('visit_date') as $monitoring)
                <div class="monitoring-record">
                    <h3>Monitoring Record #{{ $loop->iteration }}</h3>
                    <div class="info-line"><strong>Visit Date:</strong> {{ \Carbon\Carbon::parse($monitoring->visit_date)->format('d M Y') }}</div>
                    <div class="info-line"><strong>Diagnosis Date:</strong> {{ \Carbon\Carbon::parse($monitoring->diagnosis_date)->format('d M Y') }}</div>
                    <div class="info-line"><strong>Cancer Type:</strong> {{ $monitoring->cancer_type ?: 'N/A' }}</div>
                    <div class="info-line"><strong>Stage:</strong> {{ $monitoring->stage ?: 'N/A' }}</div>
                    <div class="info-line"><strong>Grade:</strong> {{ $monitoring->grade ?: 'N/A' }}</div>
                    <div class="info-line">
                        <strong>Pathology Reports:</strong>
                        @if($monitoring->pathology_reports)
                            <span class="file-status">File available</span>
                        @else
                            <span class="file-status">No file</span>
                        @endif
                    </div>
                    <div class="info-line">
                        <strong>MRI Findings:</strong>
                        @if($monitoring->mri_findings)
                            <span class="file-status">File available</span>
                        @else
                            <span class="file-status">No file</span>
                        @endif
                    </div>
                    <div class="info-line">
                        <strong>CT Scan Findings:</strong>
                        @if($monitoring->ct_findings)
                            <span class="file-status">File available</span>
                        @else
                            <span class="file-status">No file</span>
                        @endif
                    </div>
                    <div class="info-line"><strong>Follow-up Date:</strong> {{ $monitoring->followup_date ? \Carbon\Carbon::parse($monitoring->followup_date)->format('d M Y') : 'N/A' }}</div>
                    <div class="info-line"><strong>Follow-up Results:</strong> {{ $monitoring->followup_results ?: 'N/A' }}</div>
                    <div class="info-line"><strong>Disease Progression Date:</strong> {{ $monitoring->progression_date ? \Carbon\Carbon::parse($monitoring->progression_date)->format('d M Y') : 'N/A' }}</div>
                    <div class="info-line"><strong>Progression Site:</strong> {{ $monitoring->progression_site ?: 'N/A' }}</div>
                    <div class="info-line"><strong>Progression Treatment:</strong> {{ $monitoring->progression_treatment ?: 'N/A' }}</div>
                    <div class="info-line"><strong>Functional Status:</strong> {{ $monitoring->functional_status ?: 'N/A' }}</div>
                    <div class="info-line"><strong>Genetic Testing:</strong> {{ $monitoring->genetic_testing ?: 'N/A' }}</div>
                    <div class="info-line"><strong>Biomarker Data:</strong> {{ $monitoring->biomarker_data ?: 'N/A' }}</div>
                    <div class="info-line"><strong>Genetic Mutations:</strong> {{ $monitoring->genetic_mutations ?: 'N/A' }}</div>
                </div>
            @endforeach
        @else
            <p>No monitoring records found.</p>
        @endif
    </div>
</div>
</body>
</html>
