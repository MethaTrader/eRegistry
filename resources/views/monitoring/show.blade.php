@extends('layouts.app')

@section('content')
    <div class="container-fluid" style="padding: 2rem;">
        <!-- Breadcrumbs -->
        <div class="page-header mb-3">
            <div class="row">
                <div class="col-sm-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/monitoring') }}">Monitoring</a></li>
                        <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                        <li class="breadcrumb-item active">Monitoring Details</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Monitoring Details Card -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Monitoring Record Details</h3>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <!-- Left Column -->
                    <div class="col-md-6">
                        <p><strong>Patient:</strong> <a href="{{ route('patients.show', $monitoring->patient_id) }}">{{ $monitoring->patient->full_name }}</a></p>
                        <p><strong>Visit Date:</strong> {{ \Carbon\Carbon::parse($monitoring->visit_date)->format('d M Y') }}</p>
                        <p><strong>Diagnosis Date:</strong> {{ \Carbon\Carbon::parse($monitoring->diagnosis_date)->format('d M Y') }}</p>
                        <p><strong>Cancer Type:</strong> {{ $monitoring->cancer_type ?: 'N/A' }}</p>
                        <p><strong>Stage:</strong> {{ $monitoring->stage ?: 'N/A' }}</p>
                        <p><strong>Grade:</strong> {{ $monitoring->grade ?: 'N/A' }}</p>
                    </div>
                    <!-- Right Column -->
                    <div class="col-md-6">
                        <p><strong>Follow-up Date:</strong> {{ $monitoring->followup_date ? \Carbon\Carbon::parse($monitoring->followup_date)->format('d M Y') : 'N/A' }}</p>
                        <p><strong>Follow-up Results:</strong> {{ $monitoring->followup_results ?: 'N/A' }}</p>
                        <p><strong>Disease Progression Date:</strong> {{ $monitoring->progression_date ? \Carbon\Carbon::parse($monitoring->progression_date)->format('d M Y') : 'N/A' }}</p>
                        <p><strong>Progression Site:</strong> {{ $monitoring->progression_site ?: 'N/A' }}</p>
                        <p><strong>Progression Treatment:</strong> {{ $monitoring->progression_treatment ?: 'N/A' }}</p>
                        <p><strong>Functional Status:</strong> {{ $monitoring->functional_status ?: 'N/A' }}</p>
                    </div>
                </div>
                <hr>
                <!-- File Information -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <p><strong>Pathology Reports:</strong>
                            @if($monitoring->pathology_reports)
                                <a href="{{ $monitoring->pathology_reports }}" download class="btn btn-sm btn-primary">
                                    <i class="fa fa-download"></i> Download
                                </a>
                            @else
                                <span class="text-danger">No file available</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>MRI Findings:</strong>
                            @if($monitoring->mri_findings)
                                <a href="{{ $monitoring->mri_findings }}" class="btn btn-sm btn-primary" target="_blank">
                                    <i class="fa fa-download"></i> Download
                                </a>
                            @else
                                <span class="text-danger">No file available</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>CT Scan Findings:</strong>
                            @if($monitoring->ct_findings)
                                <a href="{{ $monitoring->ct_findings }}" class="btn btn-sm btn-primary" target="_blank">
                                    <i class="fa fa-download"></i> Download
                                </a>
                            @else
                                <span class="text-danger">No file available</span>
                            @endif
                        </p>
                    </div>
                </div>
                <hr>
                <!-- Genetic and Biomarker Data -->
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Genetic Testing:</strong> {{ $monitoring->genetic_testing ?: 'N/A' }}</p>
                        <p><strong>Biomarker Data:</strong> {{ $monitoring->biomarker_data ?: 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Genetic Mutations:</strong> {{ $monitoring->genetic_mutations ?: 'N/A' }}</p>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <a href="{{ route('monitoring.edit', [$monitoring->id]) }}" class="btn btn-primary btn-sm">Edit</a>
                <a href="{{ route('monitoring.index') }}" class="btn btn-secondary btn-sm">Back to List</a>
            </div>
        </div>
    </div>
@endsection

<!-- Дополнительные стили -->
@push('styles')
    <style>
        .card {
            margin-bottom: 2rem;
        }
        .card-header h3 {
            margin: 0;
        }
        .card-body p {
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
        }
        .breadcrumb {
            background: transparent;
            padding: 0;
            margin-bottom: 1rem;
        }
        .btn-outline-primary {
            margin-top: 5px;
        }
    </style>
@endpush
