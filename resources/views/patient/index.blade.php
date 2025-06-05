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
                                        <!-- Enhanced Actions Column -->
                                        <td class="text-end">
                                            <div class="action-container">
                                                <!-- Quick Actions -->
                                                <div class="quick-actions d-inline-flex me-2">
                                                    <a href="{{ route('patients.show', $patient->id) }}"
                                                       class="btn btn-sm btn-outline-info action-quick-btn"
                                                       data-bs-toggle="tooltip"
                                                       title="View patient details">
                                                        <i class="fas fa-eye"></i>
                                                        <span class="d-none d-xl-inline ms-1">View</span>
                                                    </a>
                                                    <a href="{{ route('patients.edit', $patient->id) }}"
                                                       class="btn btn-sm btn-outline-warning action-quick-btn ms-1"
                                                       data-bs-toggle="tooltip"
                                                       title="Edit patient information">
                                                        <i class="fas fa-edit"></i>
                                                        <span class="d-none d-xl-inline ms-1">Edit</span>
                                                    </a>
                                                </div>

                                                <!-- More Actions -->
                                                <div class="more-actions d-inline-block">
                                                    <div class="btn-group">
                                                        <button type="button"
                                                                class="btn btn-sm btn-outline-secondary dropdown-toggle action-more-btn"
                                                                data-bs-toggle="dropdown"
                                                                aria-expanded="false"
                                                                data-bs-toggle="tooltip"
                                                                title="More actions">
                                                            <i class="fas fa-ellipsis-h"></i>
                                                            <span class="d-none d-xl-inline ms-1">More</span>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end modern-dropdown">
                                                            <!-- Monitoring Actions -->
                                                            <li class="dropdown-header">
                                                                <i class="fas fa-heartbeat me-1"></i>Monitoring
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="{{ route('monitoring.create', ['patient_id' => $patient->id]) }}">
                                                                    <i class="fas fa-plus-circle text-success me-2"></i>
                                                                    <div>
                                                                        <strong>Add Monitoring</strong>
                                                                        <small class="text-muted d-block">Create new monitoring record</small>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                            @if($patient->monitorings->count() > 0)
                                                                <li>
                                                                    <a class="dropdown-item" href="{{ route('monitoring.index', ['patient_id' => $patient->id]) }}">
                                                                        <i class="fas fa-chart-line text-primary me-2"></i>
                                                                        <div>
                                                                            <strong>View History</strong>
                                                                            <small class="text-muted d-block">{{ $patient->monitorings->count() }} monitoring records</small>
                                                                        </div>
                                                                    </a>
                                                                </li>
                                                            @endif

                                                            <li><hr class="dropdown-divider"></li>

                                                            <!-- File Actions -->
                                                            <li class="dropdown-header">
                                                                <i class="fas fa-file me-1"></i>Files & Reports
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="{{ route('patients.pdf', $patient->id) }}" target="_blank">
                                                                    <i class="fas fa-file-pdf text-danger me-2"></i>
                                                                    <div>
                                                                        <strong>Download PDF</strong>
                                                                        <small class="text-muted d-block">Complete patient record</small>
                                                                    </div>
                                                                </a>
                                                            </li>

                                                            <li><hr class="dropdown-divider"></li>

                                                            <!-- Danger Zone -->
                                                            <li class="dropdown-header text-danger">
                                                                <i class="fas fa-exclamation-triangle me-1"></i>Danger Zone
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item text-danger" href="#"
                                                                   onclick="showDeleteModal({{ $patient->id }}, '{{ addslashes($patient->full_name) }}')">
                                                                    <i class="fas fa-trash-alt me-2"></i>
                                                                    <div>
                                                                        <strong>Delete Patient</strong>
                                                                        <small class="d-block">Permanently remove patient</small>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
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
    </div>

    <!-- Единое модальное окно для удаления пациента -->
    <div class="modal fade" id="deletePatientModal" tabindex="-1" aria-labelledby="deletePatientModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletePatientModalLabel">
                        <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                        Confirm Delete
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <i class="fas fa-user-times text-danger" style="font-size: 3rem;"></i>
                    </div>
                    <p class="text-center mb-3">Are you sure you want to delete patient:</p>
                    <p class="text-center mb-3">
                        <strong id="patientNameToDelete" class="text-primary"></strong>
                    </p>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Warning:</strong> This action cannot be undone. All monitoring records associated with this patient will also be permanently deleted.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>
                        Cancel
                    </button>
                    <form id="deletePatientForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash-alt me-1"></i>
                            Delete Patient
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // Функция для показа модального окна удаления
        function showDeleteModal(patientId, patientName) {
            // Устанавливаем имя пациента в модальном окне
            document.getElementById('patientNameToDelete').textContent = patientName;

            // Устанавливаем action для формы удаления
            const deleteForm = document.getElementById('deletePatientForm');
            deleteForm.action = `{{ url('/patients') }}/${patientId}`;

            // Показываем модальное окно
            const modal = new bootstrap.Modal(document.getElementById('deletePatientModal'));
            modal.show();
        }

        // Обработчик для кнопки "refresh"
        document.addEventListener('DOMContentLoaded', function() {
            const refreshBtn = document.getElementById('refreshBtn');
            if (refreshBtn) {
                refreshBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.getElementById('topSearchForm').submit();
                });
            }

            // Инициализация tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>

    <style>
        /* Дополнительные стили для улучшения внешнего вида */
        .action-container {
            white-space: nowrap;
        }

        .action-quick-btn,
        .action-more-btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            border-radius: 0.375rem;
            transition: all 0.2s ease-in-out;
        }

        .action-quick-btn:hover,
        .action-more-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .modern-dropdown {
            border: none;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            border-radius: 0.5rem;
            padding: 0.5rem 0;
            min-width: 250px;
        }

        .modern-dropdown .dropdown-header {
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 0.5rem 1rem 0.25rem;
            color: #6b7280;
        }

        .modern-dropdown .dropdown-item {
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            transition: all 0.2s ease;
        }

        .modern-dropdown .dropdown-item:hover {
            background-color: #f8fafc;
            transform: translateX(2px);
        }

        .modern-dropdown .dropdown-item div {
            flex: 1;
        }

        .modern-dropdown .dropdown-item small {
            font-size: 0.75rem;
            opacity: 0.7;
        }

        /* Только стили для модального окна - затемнение фона и анимация */
        .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.7) !important;
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
        }

        .modal.fade .modal-dialog {
            transform: scale(0.9) translateY(-30px);
            transition: all 0.3s ease-out;
        }

        .modal.show .modal-dialog {
            transform: scale(1) translateY(0);
        }

        .modal-content {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .modal-header {
            border-bottom: 1px solid #e5e7eb;
            padding: 1.5rem;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            border-top: 1px solid #e5e7eb;
            padding: 1.5rem;
        }

        @media (max-width: 768px) {
            .action-quick-btn span,
            .action-more-btn span {
                display: none !important;
            }

            .modern-dropdown {
                min-width: 200px;
            }
        }
    </style>
@endpush