<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Doctors Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 20px;
            font-size: 14px;
        }
        .card {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .card h3 {
            margin-top: 0;
            margin-bottom: 10px;
        }
        .card p {
            margin: 5px 0;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
<div class="header">
    <h2>Report doctors</h2>
</div>
@foreach($doctors as $doctor)
    <div class="card">
        <h3>{{ $doctor->name }}</h3>
        <p><strong>Doctor ID:</strong> D-{{ str_pad($doctor->id, 4, '0', STR_PAD_LEFT) }}</p>
        <p><strong>Email:</strong> {{ $doctor->email }}</p>
        <p><strong>Workplace:</strong> {{ $doctor->workplace ?? 'N/A' }}</p>
        <p><strong>Specialty:</strong> {{ $doctor->specialty ?? 'N/A' }}</p>
        <p><strong>Role:</strong> {{ $doctor->getRoleNames()->first() }}</p>
        <p><strong>Registration Date:</strong> {{ $doctor->created_at ? $doctor->created_at->format('d.m.Y') : 'N/A' }}</p>
        <p><strong>Additional Information:</strong> {{ $doctor->additional_information ?? '' }}</p>
    </div>
@endforeach
</body>
</html>
