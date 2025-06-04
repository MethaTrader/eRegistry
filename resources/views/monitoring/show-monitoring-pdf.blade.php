<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Monitoring Report</title>
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
        .section {
            margin-bottom: 20px;
        }
        .section-title {
            font-size: 16px;
            border-bottom: 1px solid #333;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
        .info-block {
            margin-bottom: 10px;
        }
        .info-block p {
            margin: 4px 0;
        }
        .info-block strong {
            display: inline-block;
            width: 200px;
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Patient Information -->
    <div class="section">
        <div class="section-title">Patient Information</div>
        <div class="info-block">
            <p><strong>Full Name:</strong> {{ $monitoring->patient->full_name }}</p>
        </div>
    </div>

    <!-- Monitoring Information -->
    <div class="section">
        <div class="section-title">Monitoring Details</div>
        <div class="info-block">
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
    </div>
</div>
</body>
</html>
