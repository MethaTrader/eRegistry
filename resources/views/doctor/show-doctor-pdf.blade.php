<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Doctor Report</title>
    <style>
        /* Простые стили для PDF */
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 14px;
            margin: 20px;
        }
        h2 {
            margin-bottom: 10px;
        }
        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            color: #fff;
            font-size: 12px;
        }
        .status-green { background-color: #28a745; }
        .status-red { background-color: #dc3545; }
        .status-blue { background-color: #007bff; }
        .status-secondary { background-color: #6c757d; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 6px 8px;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
<h2>Doctor Report</h2>
@php
    // Определяем префикс для ID и класс плашки в зависимости от роли
    switch($doctor->getRoleNames()->first()) {
        case 'Administrator':
            $prefix = 'A-';
            $badgeClass = 'status-red';
            break;
        case 'Doctor':
            $prefix = 'D-';
            $badgeClass = 'status-green';
            break;
        case 'User':
            $prefix = 'U-';
            $badgeClass = 'status-blue';
            break;
        default:
            $prefix = '';
            $badgeClass = 'status-secondary';
    }
@endphp

<p><strong>Doctor ID:</strong> {{ $prefix . str_pad($doctor->id, 4, '0', STR_PAD_LEFT) }}</p>
<p><strong>Name:</strong> {{ $doctor->name }}</p>
<p><strong>Email:</strong> {{ $doctor->email }}</p>
<p><strong>Workplace:</strong> {{ $doctor->workplace ?? 'N/A' }}</p>
<p><strong>Specialty:</strong> {{ $doctor->specialty ?? 'N/A' }}</p>
<p>
    <strong>Role:</strong>
    <span class="badge {{ $badgeClass }}">
            {{ $doctor->getRoleNames()->first() }}
        </span>
</p>
<p><strong>Registration Date:</strong> {{ $doctor->created_at ? $doctor->created_at->format('d.m.Y') : 'N/A' }}</p>

@if(!empty($doctor->additional_information))
    <h3>Additional Information</h3>
    <p>{{ $doctor->additional_information }}</p>
@endif

<!-- Пример таблицы с дополнительной информацией (если необходимо) -->
<table>
    <thead>
    <tr>
        <th>Field</th>
        <th>Value</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>Doctor ID</td>
        <td>{{ $prefix . str_pad($doctor->id, 4, '0', STR_PAD_LEFT) }}</td>
    </tr>
    <tr>
        <td>Name</td>
        <td>{{ $doctor->name }}</td>
    </tr>
    <tr>
        <td>Email</td>
        <td>{{ $doctor->email }}</td>
    </tr>
    <tr>
        <td>Workplace</td>
        <td>{{ $doctor->workplace ?? 'N/A' }}</td>
    </tr>
    <tr>
        <td>Specialty</td>
        <td>{{ $doctor->specialty ?? 'N/A' }}</td>
    </tr>
    <tr>
        <td>Role</td>
        <td><span class="badge {{ $badgeClass }}">{{ $doctor->getRoleNames()->first() }}</span></td>
    </tr>
    <tr>
        <td>Registration Date</td>
        <td>{{ $doctor->created_at ? $doctor->created_at->format('d.m.Y') : 'N/A' }}</td>
    </tr>
    </tbody>
</table>
</body>
</html>
