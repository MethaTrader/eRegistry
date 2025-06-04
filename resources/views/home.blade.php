@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="content">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                        <li class="breadcrumb-item active">Dashboard Admin</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <!-- Greeting Block -->
        <div class="good-morning-blk mb-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="morning-user">
                        <h2>Hi, <span>{{ auth()->user()->name }}</span></h2>
                        <p>Good Day!</p>
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <div class="morning-img">
                        <img src="{{ asset('assets/img/morning-img-01.png') }}" alt="Morning Image" style="max-width: 150px;">
                    </div>
                </div>
            </div>
        </div>

        <!-- Dashboard Widgets -->
        <div class="row">
            <!-- Patients Widget -->
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="dash-widget">
                    <div class="dash-boxs comman-flex-center">
                        <img src="{{ asset('assets/img/icons/calendar.svg') }}" alt="Calendar Icon">
                    </div>
                    <div class="dash-content dash-count">
                        <h4>Patients</h4>
                        <h2><span class="counter-up">{{ $patientsCount }}</span></h2>
                        <p>
                        <span class="passive-view">
                            <i class="feather-arrow-up-right me-1"></i>{{ $percentChangePatients }}%
                        </span> vs last month
                        </p>
                    </div>
                </div>
            </div>
            <!-- On Monitoring Widget -->
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="dash-widget">
                    <div class="dash-boxs comman-flex-center">
                        <img src="{{ asset('assets/img/icons/profile-add.svg') }}" alt="Profile Add Icon">
                    </div>
                    <div class="dash-content dash-count">
                        <h4>On Monitoring</h4>
                        <h2><span class="counter-up">{{ $onMonitoringCount }}</span></h2>
                        <p>
                        <span class="passive-view">
                            <i class="feather-arrow-up-right me-1"></i>{{ $percentChangeMonitoring }}%
                        </span> vs last month
                        </p>
                    </div>
                </div>
            </div>
            <!-- Doctors Widget -->
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="dash-widget">
                    <div class="dash-boxs comman-flex-center">
                        <img src="{{ asset('assets/img/icons/scissor.svg') }}" alt="Scissor Icon">
                    </div>
                    <div class="dash-content dash-count">
                        <h4>Doctors</h4>
                        <h2><span class="counter-up">{{ $doctorsCount }}</span></h2>
                        <p>
                        <span class="negative-view">
                            <i class="feather-arrow-down-right me-1"></i>{{ $percentChangeDoctors }}%
                        </span> vs last month
                        </p>
                    </div>
                </div>
            </div>
            <!-- Admins Widget -->
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="dash-widget">
                    <div class="dash-boxs comman-flex-center">
                        <img src="{{ asset('assets/img/icons/empty-wallet.svg') }}" alt="Wallet Icon">
                    </div>
                    <div class="dash-content dash-count">
                        <h4>Admins</h4>
                        <h2><span class="counter-up">{{ $adminsCount }}</span></h2>
                        <p>
                        <span class="passive-view">
                            <i class="feather-arrow-up-right me-1"></i>{{ $percentChangeAdmins }}%
                        </span> vs last month
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="chart-title patient-visit">
                            <h4>New patients</h4>
                            <div >
                                <ul class="nav chat-user-total">
                                    <li><i class="fa fa-circle current-users" aria-hidden="true"></i>Men 75%</li>
                                    <li><i class="fa fa-circle old-users" aria-hidden="true"></i> Women 25%</li>
                                </ul>
                            </div>
                            <div class="input-block mb-0">
                                <select class="form-control select">
                                    <option>2024</option>
                                    <option>2023</option>
                                    <option>2022</option>
                                    <option>2021</option>
                                </select>
                            </div>
                        </div>
                        <div id="patient-chart"></div>
                    </div>
                </div>
            </div>
{{--            <div class="col-12 col-md-12 col-lg-6 col-xl-3 d-flex">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="chart-title">--}}
{{--                            <h4>Patients by age</h4>--}}
{{--                        </div>--}}
{{--                        <div id="donut-chart-dash" class="chart-user-icon">--}}
{{--                            <img src="assets/img/icons/user-icon.svg" alt="">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
        <div class="row">
            <div class="col-12 col-md-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title d-inline-block">List of Doctors</h4>
                        <a href="{{ route('doctors.index') }}" class="patient-views float-end">Show all</a>
                    </div>
                    <div class="card-body p-0 table-dash">
                        <div class="table-responsive">
                            <table class="table mb-0 border-0 datatable custom-table">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Specialty</th>
                                    <th>Workplace</th>
                                    <th>Registered At</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($doctors as $doctor)
                                    <tr>
                                        <td>{{ 'D-' . str_pad($doctor->id, 4, '0', STR_PAD_LEFT) }}</td>
                                        <td class="table-image appoint-doctor">
                                            <a href="{{ route('doctors.show', $doctor->id) }}"><h2>{{ $doctor->name }}</h2></a>
                                        </td>
                                        <td>{{ $doctor->specialty ?? 'N/A' }}</td>
                                        <td>{{ $doctor->workplace ?? 'N/A' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($doctor->created_at)->format('d.m.Y') }}</td>
                                        <td class="text-end">
                                            <!-- Кнопка для просмотра -->
                                            <a href="{{ route('doctors.show', $doctor->id) }}" class="btn btn-sm btn-outline-primary" title="View">
                                                <i class="feather-eye"></i>
                                            </a>
                                            <!-- Кнопка для редактирования -->
                                            <a href="{{ route('doctors.edit', $doctor->id) }}" class="btn btn-sm btn-outline-success" title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <!-- Кнопка для удаления с подтверждением -->
                                            <a href="javascript:;" class="btn btn-sm btn-outline-danger" title="Delete"
                                               onclick="if(confirm('Are you sure you want to delete this doctor?')) { document.getElementById('delete-form-{{ $doctor->id }}').submit(); }">
                                                <i class="fa fa-trash-alt"></i>
                                            </a>
                                            <form id="delete-form-{{ $doctor->id }}" action="{{ route('doctors.destroy', $doctor->id) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-12 col-xl-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h4 class="card-title d-inline-block">Recently Added Patients</h4>
                        <a href="{{ route('patients.index') }}" class="float-end patient-views">Show all</a>
                    </div>
                    <div class="card-block table-dash">
                        <div class="table-responsive">
                            <table class="table mb-0 border-0 datatable custom-table">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Full Name</th>
                                    <th>Age</th>
                                    <th>Doctor</th>
                                    <th>Diagnosis</th>
                                    <th>Registered</th>
                                    <th>Monitoring Count</th>
                                    <th>Download</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($recentPatients as $patient)
                                    <tr>
                                        <!-- Форматированный ID -->
                                        <td>{{ 'P-' . str_pad($patient->id, 6, '0', STR_PAD_LEFT) }}</td>
                                        <!-- Имя пациента, кликабельно -->
                                        <td>
                                            <a href="{{ route('patients.show', $patient->id) }}">
                                                {{ $patient->full_name }}
                                            </a>
                                        </td>
                                        <!-- Возраст -->
                                        <td>
                                            @if($patient->date_of_birth)
                                                {{ \Carbon\Carbon::parse($patient->date_of_birth)->age }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <!-- Имя доктора. Предполагается, что у модели Patient есть связь doctor -->
                                        <td>
                                            @if($patient->doctor_id && $patient->doctor)
                                                <a href="{{ route('doctors.show', $patient->doctor_id) }}">
                                                    {{ $patient->doctor->name }}
                                                </a>
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <!-- Диагноз - используем данные из последнего мониторинга, если есть -->
                                        <td>
                                            @php
                                                $lastMonitoring = $patient->monitorings->sortByDesc('created_at')->first();
                                            @endphp
                                            {{ $lastMonitoring ? $lastMonitoring->cancer_type : 'N/A' }}
                                        </td>
                                        <!-- Дата регистрации -->
                                        <td>{{ $patient->created_at->format('d.m.Y') }}</td>
                                        <!-- Количество мониторингов -->
                                        <td>{{ $patient->monitorings->count() }}</td>
                                        <!-- Кнопка скачивания файла пациента (PDF) -->
                                        <td>
                                            <a href="{{ route('patients.pdf', $patient->id) }}" class="btn btn-sm btn-outline-primary" title="Download Patient File">
                                                <i class="fa fa-download"></i>
                                            </a>
                                        </td>
                                        <!-- Действия: Edit, Delete -->
                                        <td class="text-end">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="{{ route('patients.edit', $patient->id) }}">
                                                        <i class="fa-solid fa-pen-to-square m-r-5"></i> Edit
                                                    </a>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_patient_{{ $patient->id }}">
                                                        <i class="fa fa-trash-alt m-r-5"></i> Delete
                                                    </a>
                                                </div>
                                            </div>
                                            <!-- Modal для подтверждения удаления -->
                                            <div class="modal fade" id="delete_patient_{{ $patient->id }}" tabindex="-1" role="dialog" aria-labelledby="deletePatientLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deletePatientLabel">Delete Patient</h5>
                                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to delete this patient?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <form action="{{ route('patients.destroy', $patient->id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">Delete</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
