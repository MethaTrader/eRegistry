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
                        <li class="breadcrumb-item"><a href="{{ url('/monitoring') }}">Monitoring</a></li>
                        <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                        <li class="breadcrumb-item active">Monitoring Records</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table show-entire">
                    <div class="card-body">
                        <!-- Table Header -->
                        <div class="page-table-header mb-2">
                            <div class="row align-items-center">
                                <div class="col">
                                    <div class="doctor-table-blk">
                                        <h3>Monitoring Records</h3>
                                        <div class="doctor-search-blk">
                                            <div class="top-nav-search table-search-blk">
                                                <!-- Форма поиска -->
                                                <form id="topSearchForm" action="{{ route('monitoring.index') }}" method="GET">
                                                    <input type="text" name="patient_name" class="form-control" placeholder="Search by patient name" value="{{ request('patient_name') }}">
                                                    <button type="submit" class="btn">
                                                        <img src="{{ asset('assets/img/icons/search-normal.svg') }}" alt="Search">
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
{{--                                <!-- Экспортные кнопки (без JS логики скачивания) -->--}}
{{--                                <div class="col-auto text-end float-end ms-auto download-grp">--}}
{{--                                    <a href="javascript:;" class="me-2">--}}
{{--                                        <img src="{{ asset('assets/img/icons/pdf-icon-01.svg') }}" alt="PDF Report">--}}
{{--                                    </a>--}}
{{--                                    <a href="javascript:;" class="me-2">--}}
{{--                                        <img src="{{ asset('assets/img/icons/pdf-icon-04.svg') }}" alt="Excel Report">--}}
{{--                                    </a>--}}
{{--                                </div>--}}
                            </div>
                        </div>
                        <!-- /Table Header -->

                        <!-- Форма фильтров -->
                        <div class="staff-search-table mb-3">
                            <form action="{{ route('monitoring.index') }}" method="GET">
                                <div class="row">
                                    <!-- Фильтр по имени пациента -->
                                    <div class="col-12 col-md-6 col-xl-4">
                                        <div class="input-block local-forms">
                                            <label>Patient Name</label>
                                            <input type="text" name="patient_name" class="form-control" placeholder="Enter patient name" value="{{ request('patient_name') }}">
                                        </div>
                                    </div>
                                    <!-- Фильтр по дате визита: от -->
                                    <div class="col-12 col-md-6 col-xl-4">
                                        <div class="input-block local-forms cal-icon">
                                            <label>Visit Date From</label>
                                            <input type="text" name="visit_from" class="form-control datetimepicker" placeholder="YYYY-MM-DD" value="{{ request('visit_from') }}">
                                        </div>
                                    </div>
                                    <!-- Фильтр по дате визита: до -->
                                    <div class="col-12 col-md-6 col-xl-4">
                                        <div class="input-block local-forms cal-icon">
                                            <label>Visit Date To</label>
                                            <input type="text" name="visit_to" class="form-control datetimepicker" placeholder="YYYY-MM-DD" value="{{ request('visit_to') }}">
                                        </div>
                                    </div>
                                    <!-- Фильтр по типу рака -->
                                    <div class="col-12 col-md-6 col-xl-4">
                                        <div class="input-block local-forms">
                                            <label>Cancer Type</label>
                                            <select name="cancer_type" class="form-control select">
                                                <option value="">Select Cancer Type</option>
                                                <option value="glioblastoma" {{ request('cancer_type') == 'glioblastoma' ? 'selected' : '' }}>Glioblastoma</option>
                                                <option value="meningioma" {{ request('cancer_type') == 'meningioma' ? 'selected' : '' }}>Meningioma</option>
                                                <option value="neuroblastoma" {{ request('cancer_type') == 'neuroblastoma' ? 'selected' : '' }}>Neuroblastoma</option>
                                                <option value="other" {{ request('cancer_type') == 'other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Фильтр по стадии -->
                                    <div class="col-12 col-md-6 col-xl-4">
                                        <div class="input-block local-forms">
                                            <label>Stage</label>
                                            <input type="text" name="stage" class="form-control" placeholder="Enter stage" value="{{ request('stage') }}">
                                        </div>
                                    </div>
                                    <!-- Фильтр по грейду -->
                                    <div class="col-12 col-md-6 col-xl-4">
                                        <div class="input-block local-forms">
                                            <label>Grade</label>
                                            <input type="text" name="grade" class="form-control" placeholder="Enter grade" value="{{ request('grade') }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-xl-4 ms-auto">
                                        <div class="doctor-submit">
                                            <button type="submit" class="btn btn-primary submit-list-form me-2">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /Форма фильтров -->

                        <!-- Таблица мониторингов -->
                        <div class="table-responsive">
                            <table class="table border-0 custom-table comman-table datatable mb-0" id="DataTables_Table_0">
                                <thead>
                                <tr role="row">
                                    <th style="width: 50px;">
                                        <div class="form-check check-tables">
                                            <input type="checkbox" class="form-check-input" id="select-all">
                                        </div>
                                    </th>
                                    <th>ID</th>
                                    <th>Patient</th>
                                    <th>Visit Date</th>
                                    <th>Diagnosis Date</th>
                                    <th>Cancer Type</th>
                                    <th>Stage</th>
                                    <th>Grade</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($monitorings as $monitoring)
                                    <tr class="{{ $loop->iteration % 2 == 0 ? 'even' : 'odd' }}">
                                        <td>
                                            <div class="form-check check-tables">
                                                <input type="checkbox" class="form-check-input row-checkbox" value="{{ $monitoring->id }}">
                                            </div>
                                        </td>
                                        <td>{{ $monitoring->id }}</td>
                                        <td>
                                            <a href="{{ route('monitoring.show', [$monitoring->id]) }}">
                                                {{ $monitoring->patient->full_name ?? 'N/A' }}
                                            </a>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($monitoring->visit_date)->format('d.m.Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($monitoring->diagnosis_date)->format('d.m.Y') }}</td>
                                        <td>{{ ucfirst($monitoring->cancer_type) ?: 'N/A' }}</td>
                                        <td>{{ $monitoring->stage ?: 'N/A' }}</td>
                                        <td>{{ $monitoring->grade ?: 'N/A' }}</td>
                                        <td class="text-end">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="{{ route('monitoring.edit', [$monitoring->id]) }}">
                                                        <i class="fa-solid fa-pen-to-square m-r-5"></i> Edit
                                                    </a>
                                                    <a class="dropdown-item" href="{{ route('monitoring.show', $monitoring) }}">
                                                        <i class="feather-eye m-r-5"></i> View
                                                    </a>
                                                    <a class="dropdown-item" href="#">
                                                        <i class="feather-download m-r-5"></i> Download
                                                    </a>
                                                    <a class="dropdown-item" href="#"
                                                       onclick="if(confirm('Are you sure you want to delete this monitoring record?')) { document.getElementById('delete-form-{{ $monitoring->id }}').submit(); } return false;">
                                                        <i class="fa fa-trash-alt m-r-5"></i> Delete
                                                    </a>
                                                    <form id="delete-form-{{ $monitoring->id }}" action="{{ route('monitoring.destroy', [$monitoring->patient_id, $monitoring->id]) }}" method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </div>
                                            </div>
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
        @endsection

        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Инициализация select2, если используется
                    if ($('.select2').length > 0) {
                        $('.select2').select2({ width: '100%' });
                    }
                });
            </script>
    @endpush
