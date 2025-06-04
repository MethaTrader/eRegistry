@extends('layouts.app')

@section('content')
    <div class="content">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/patients') }}">Patients</a></li>
                        <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                        <li class="breadcrumb-item active">List of Patients</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <!-- Success and Error Messages -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table show-entire">
                    <div class="card-body">
                        <!-- Table Header -->
                        <div class="page-table-header mb-2">
                            <div class="row align-items-center">
                                <div class="col">
                                    <div class="doctor-table-blk">
                                        <h3>Patient Registry</h3>
                                        <div class="doctor-search-blk">
                                            <div class="top-nav-search table-search-blk">
                                                <form action="{{ route('patients.index') }}" method="GET" id="topSearchForm">
                                                    <input type="text" name="search" class="form-control" placeholder="Search by name, phone, email" value="{{ request('search') }}">
                                                    <button type="submit" class="btn">
                                                        <img src="{{ asset('assets/img/icons/search-normal.svg') }}" alt="Search">
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="add-group">
                                                <a href="{{ route('patients.create') }}" class="btn btn-primary add-pluss ms-2">
                                                    <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="Add Patient">
                                                </a>
                                                <a href="javascript:;" class="btn btn-primary doctor-refresh ms-2" id="refreshBtn">
                                                    <img src="{{ asset('assets/img/icons/re-fresh.svg') }}" alt="Refresh">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto text-end float-end ms-auto download-grp">
                                    <a href="{{ route('patients.reports.pdf', request()->query()) }}" class="me-2" title="Download PDF">
                                        <img src="{{ asset('assets/img/icons/pdf-icon-01.svg') }}" alt="PDF Export">
                                    </a>
                                    {{-- Можно добавить Excel экспорт по аналогии --}}
                                </div>
                            </div>
                        </div>
                        <!-- /Table Header -->

                        <!-- Filters -->
                        <div class="staff-search-table mb-3">
                            <form action="{{ route('patients.index') }}" method="GET">
                                <div class="row">
                                    <!-- Filter by Cancer Type -->
                                    <div class="col-12 col-md-6 col-xl-4">
                                        <div class="input-block local-forms">
                                            <label>Cancer Type</label>
                                            <select name="cancer_type" class="form-control select">
                                                <option value="">Select Cancer Type</option>
                                                <option value="glioblastoma" {{ request('cancer_type')=='glioblastoma' ? 'selected' : '' }}>Glioblastoma</option>
                                                <option value="meningioma" {{ request('cancer_type')=='meningioma' ? 'selected' : '' }}>Meningioma</option>
                                                <option value="neuroblastoma" {{ request('cancer_type')=='neuroblastoma' ? 'selected' : '' }}>Neuroblastoma</option>
                                                <option value="other" {{ request('cancer_type')=='other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Filter by Full Name -->
                                    <div class="col-12 col-md-6 col-xl-4">
                                        <div class="input-block local-forms">
                                            <label>Full Name</label>
                                            <input type="text" name="full_name" class="form-control" placeholder="Enter full name" value="{{ request('full_name') }}">
                                        </div>
                                    </div>
                                    <!-- Filter by Gender -->
                                    <div class="col-12 col-md-6 col-xl-4">
                                        <div class="input-block local-forms">
                                            <label>Gender</label>
                                            <select name="gender" class="form-control select">
                                                <option value="">All</option>
                                                <option value="Male" {{ request('gender')=='Male' ? 'selected' : '' }}>Male</option>
                                                <option value="Female" {{ request('gender')=='Female' ? 'selected' : '' }}>Female</option>
                                                <option value="Other" {{ request('gender')=='Other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Filter by Insurance Status -->
                                    <div class="col-12 col-md-6 col-xl-4">
                                        <div class="input-block local-forms">
                                            <label>Insurance Status</label>
                                            <select name="insurance_status" class="form-control select">
                                                <option value="">All</option>
                                                <option value="Insured" {{ request('insurance_status')=='Insured' ? 'selected' : '' }}>Insured</option>
                                                <option value="Uninsured" {{ request('insurance_status')=='Uninsured' ? 'selected' : '' }}>Uninsured</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Filter by Occupation -->
                                    <div class="col-12 col-md-6 col-xl-4">
                                        <div class="input-block local-forms">
                                            <label>Occupation</label>
                                            <input type="text" name="occupation" class="form-control" placeholder="Enter occupation" value="{{ request('occupation') }}">
                                        </div>
                                    </div>
                                    <!-- From Date -->
                                    <div class="col-12 col-md-6 col-xl-4">
                                        <div class="input-block local-forms cal-icon">
                                            <label>From Date</label>
                                            <input type="text" name="from" class="form-control datetimepicker" placeholder="YYYY-MM-DD" value="{{ request('from') }}">
                                        </div>
                                    </div>
                                    <!-- To Date -->
                                    <div class="col-12 col-md-6 col-xl-4">
                                        <div class="input-block local-forms cal-icon">
                                            <label>To Date</label>
                                            <input type="text" name="to" class="form-control datetimepicker" placeholder="YYYY-MM-DD" value="{{ request('to') }}">
                                        </div>
                                    </div>
                                    <!-- Submit Filters -->
                                    <div class="col-12 col-md-6 col-xl-4 ms-auto">
                                        <div class="doctor-submit">
                                            <button type="submit" class="btn btn-primary submit-list-form me-2">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /Filters -->

                        <!-- Таблица -->
                        <div class="table-responsive">
                            <table class="table border-0 custom-table comman-table datatable mb-0">
                                <thead>
                                <tr>
                                    <th>
                                        <div class="form-check check-tables">
                                            <input type="checkbox" class="form-check-input">
                                        </div>
                                    </th>
                                    <th>Patient ID</th>
                                    <th>Full Name</th>
                                    <th>Gender</th>
                                    <th>Date of Birth</th>
                                    <th>Insurance Status</th>
                                    <th>Phone Number</th>
                                    <th>Reg. Date</th>
                                    <th>Monitoring Count</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($patients as $patient)
                                    <tr class="{{ $loop->iteration % 2 == 0 ? 'even' : 'odd' }}">
                                        <td>
                                            <div class="form-check check-tables">
                                                <input type="checkbox" class="form-check-input" value="{{ $patient->id }}">
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('patients.show', $patient->id) }}">
                                                {{ 'P-' . str_pad($patient->id, 6, '0', STR_PAD_LEFT) }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('patients.show', $patient->id) }}">
                                                {{ $patient->full_name }}
                                            </a>
                                        </td>
                                        <td>
                                            @if($patient->gender == 'Male')
                                                <span class="custom-badge status-blue">{{ $patient->gender }}</span>
                                            @elseif($patient->gender == 'Female')
                                                <span class="custom-badge status-red">{{ $patient->gender }}</span>
                                            @else
                                                <span class="custom-badge status-secondary">{{ $patient->gender }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $patient->date_of_birth ? \Carbon\Carbon::parse($patient->date_of_birth)->format('d.m.Y') : 'N/A' }}
                                        </td>
                                        <td>
                                            {{ $patient->insurance_status ?? 'N/A' }}
                                        </td>
                                        <td>
                                            {{ $patient->phone_number ?? 'N/A' }}
                                        </td>
                                        <td>
                                            {{ $patient->created_at ? $patient->created_at->format('d.m.Y') : 'N/A' }}
                                        </td>
                                        <td>
                                            {{ $patient->monitorings->count() }}
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-sm btn-outline-primary" title="View">
                                                <i class="feather-eye"></i>
                                            </a>
                                            <a href="{{ route('monitoring.create', ['patient_id' => $patient->id]) }}" class="btn btn-sm btn-outline-info" title="Add Monitoring">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                            <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-sm btn-outline-success" title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <a href="javascript:;" class="btn btn-sm btn-outline-danger" title="Delete"
                                               onclick="if(confirm('Are you sure you want to delete this patient?')) { document.getElementById('delete-form-{{ $patient->id }}').submit(); }">
                                                <i class="fa fa-trash-alt"></i>
                                            </a>
                                            <form id="delete-form-{{ $patient->id }}" action="{{ route('patients.destroy', $patient->id) }}" method="POST" style="display:none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <a href="{{ route('patients.pdf', $patient->id) }}" class="btn btn-sm btn-outline-primary" title="Download Patient File">
                                                <i class="fa fa-download"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /Таблица -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Обработчик для кнопки "refresh"
        document.addEventListener('DOMContentLoaded', function() {
            const refreshBtn = document.getElementById('refreshBtn');
            if (refreshBtn) {
                refreshBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.getElementById('topSearchForm').submit();
                });
            }
        });
    </script>
@endpush
