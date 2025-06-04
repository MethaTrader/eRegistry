@extends('layouts.app')

@section('content')
    <div class="container-fluid" style="padding: 1rem;">
        <!-- Standard Breadcrumbs -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/patients') }}">Patients</a></li>
                        <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                        <li class="breadcrumb-item"><a href="{{ url('/monitoring') }}">Monitoring</a></li>
                        <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                        <li class="breadcrumb-item active">Patient Details</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Breadcrumbs -->

        <!-- Patient Information Card -->
        <div class="patient-info" style="position: relative; background: #fff; padding: 1.5rem; border-radius: 0.5rem; box-shadow: 0 3px 15px rgba(0,0,0,0.1); margin-bottom: 2rem;">
            <div class="download-buttons" style="position: absolute; top: 1rem; right: 1rem;">
                <a href="{{ route('patients.pdf', $patient->id) }}" class="btn btn-sm btn-white" style="margin-right: 5px;">
                    <img src="{{ asset('assets/img/icons/pdf-icon-01.svg') }}" alt="PDF" style="height: 16px;">
                </a>
{{--                <a href="#" class="btn btn-sm btn-white">--}}
{{--                    <img src="{{ asset('assets/img/icons/pdf-icon-04.svg') }}" alt="Excel" style="height: 16px;">--}}
{{--                </a>--}}
            </div>
            <h1 style="margin-bottom: 1rem;">{{ $patient->full_name }}</h1>
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
        </div>

        <!-- Monitoring Timeline -->
        <div class="monitoring-section">
            <h2 style="margin-bottom: 1.5rem;">Monitoring Timeline <a href="{{ route('monitoring.create', ['patient_id' => $patient->id]) }}" class="btn btn-sm btn-primary" title="Add Monitoring">
                    <i class="fa fa-plus"></i> Add monitoring
                </a></h2>

            @if($patient->monitorings->count() > 0)
                <div class="stepper">
                    @foreach($patient->monitorings->sortBy('visit_date') as $monitoring)
                        <div class="step">
                            <div class="step-marker">
                                {{ $loop->iteration }}
                            </div>
                            <div class="step-details" style="position: relative;">
                                <!-- Иконки скачивания мониторинга -->
                                <div class="monitoring-download" style="position: absolute; top: 5px; right: 5px;">
                                    <a href="{{route('monitoring.pdf', $monitoring)}}" style="margin-right: 5px;">
                                        <!-- Download PDF Icon -->
                                        <img src="{{ asset('assets/img/icons/pdf-icon-01.svg') }}" alt="PDF" style="height: 24px;">
                                    </a>
{{--                                    <a href="#">--}}
{{--                                        <!-- Download Excel Icon -->--}}
{{--                                        <img src="{{ asset('assets/img/icons/pdf-icon-04.svg') }}" alt="Excel" style="height: 24px;">--}}
{{--                                    </a>--}}
                                </div>
                                <p><strong>Visit Date:</strong> {{ \Carbon\Carbon::parse($monitoring->visit_date)->format('d M Y') }}</p>
                                <p><strong>Diagnosis Date:</strong> {{ \Carbon\Carbon::parse($monitoring->diagnosis_date)->format('d M Y') }}</p>
                                <p><strong>Cancer Type:</strong> {{ $monitoring->cancer_type ?: 'N/A' }}</p>
                                <p><strong>Stage:</strong> {{ $monitoring->stage ?: 'N/A' }}</p>
                                <p><strong>Grade:</strong> {{ $monitoring->grade ?: 'N/A' }}</p>
                                @if($monitoring->pathology_reports)
                                    <p><strong>Pathology Report:</strong> <a href="{{ $monitoring->pathology_reports }}" target="_blank" style="color: #2196F3;">Download</a></p>
                                @endif
                                <a href="{{ route('monitoring.show', [$monitoring->id]) }}" class="btn btn-primary detail-btn" style="margin-top: 0.5rem;">Detail</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p>No monitoring records available.</p>
            @endif


        </div>
    </div>

    <!-- Inline CSS -->
    <style>
        body {
            background: #f5f5f5;
        }
        .patient-info p,
        .step-details p {
            margin: 0.3rem 0;
            font-size: 0.95rem;
            color: #555;
        }
        .patient-info h1 {
            font-size: 2.5rem;
            color: #333;
            margin-bottom: 1rem;
        }
        .monitoring-section h2 {
            margin-bottom: 1.5rem;
            color: #333;
            font-size: 1.8rem;
        }
        .stepper {
            position: relative;
            margin-left: 40px;
            padding-left: 20px;
            border-left: 2px solid #ddd;
        }
        .step {
            position: relative;
            margin-bottom: 2rem;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .step:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }
        .step-marker {
            position: absolute;
            left: -40px;
            top: 0;
            width: 30px;
            height: 30px;
            background: #2196F3;
            border-radius: 50%;
            text-align: center;
            line-height: 30px;
            color: #fff;
            font-weight: bold;
            font-size: 1rem;
        }
        .step-details {
            background: #fff;
            padding: 1rem;
            border-radius: 0.25rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-left: 10px;
            position: relative;
        }
        .detail-btn {
            margin-top: 0.5rem;
        }
        .monitoring-download a {
            display: inline-block;
        }
        @media (max-width: 768px) {
            .stepper {
                margin-left: 20px;
                padding-left: 15px;
            }
            .step-marker {
                left: -35px;
                width: 28px;
                height: 28px;
                line-height: 28px;
                font-size: 0.9rem;
            }
        }
    </style>
@endsection
