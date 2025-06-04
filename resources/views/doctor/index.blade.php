@extends('layouts.app')

@section('content')
    <div class="content">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">{{ __('Doctors') }}</a></li>
                        <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                        <li class="breadcrumb-item active">{{ __('List of doctors') }}</li>
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
                                        <h3>{{ __('List of doctors') }}</h3>
                                        <div class="doctor-search-blk">
                                            <div class="top-nav-search table-search-blk">
                                                <!-- Форма поиска -->
                                                <form id="topSearchForm" action="{{ route('doctors.index') }}" method="GET">
                                                    <input type="text" name="search" class="form-control" placeholder="Search by name, email, workplace" value="{{ request('search') }}">
                                                    <button type="submit" class="btn">
                                                        <img src="{{ asset('assets/img/icons/search-normal.svg') }}" alt="Search">
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="add-group">
                                                <a href="{{ route('doctors.create') }}" class="btn btn-primary add-pluss ms-2">
                                                    <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="Add Doctor">
                                                </a>
                                                <a href="javascript:;" class="btn btn-primary doctor-refresh ms-2" id="refreshBtn">
                                                    <img src="{{ asset('assets/img/icons/re-fresh.svg') }}" alt="Refresh">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Экспортные кнопки с передачей текущих GET-параметров -->
                                <div class="col-auto text-end float-end ms-auto download-grp">
                                    <a href="javascript:;" id="exportPdfBtn" class="me-2">
                                        <img src="{{ asset('assets/img/icons/pdf-icon-01.svg') }}" alt="PDF Report">
                                    </a>
                                    <a href="javascript:;" id="exportExcelBtn" class="me-2">
                                        <img src="{{ asset('assets/img/icons/pdf-icon-04.svg') }}" alt="Excel Report">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- /Table Header -->

                        <!-- Фильтры -->
                        <div class="staff-search-table">
                            <form action="{{ route('doctors.index') }}" method="GET">
                                <div class="row">
                                    <div class="col-12 col-md-6 col-xl-4">
                                        <div class="input-block local-forms cal-icon">
                                            <label>{{ __('From') }}</label>
                                            <input class="form-control datetimepicker" type="text" name="from" value="{{ request('from') }}" placeholder="YYYY-MM-DD">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-xl-4">
                                        <div class="input-block local-forms cal-icon">
                                            <label>{{ __('To') }}</label>
                                            <input class="form-control datetimepicker" type="text" name="to" value="{{ request('to') }}" placeholder="YYYY-MM-DD">
                                        </div>
                                    </div>

                                    <!-- Фильтр по специальности -->
                                    <div class="col-12 col-md-6 col-xl-4">
                                        <div class="input-block local-forms">
                                            <label>{{ __('Specialty') }}</label>
                                            <select class="form-control select" name="specialty">
                                                <option value="">{{ __('Select Specialty') }}</option>
                                                <option value="Cardiology" {{ request('specialty') == 'Cardiology' ? 'selected' : '' }}>{{ __('Cardiology') }}</option>
                                                <option value="Neurology" {{ request('specialty') == 'Neurology' ? 'selected' : '' }}>{{ __('Neurology') }}</option>
                                                <option value="Pediatrics" {{ request('specialty') == 'Pediatrics' ? 'selected' : '' }}>{{ __('Pediatrics') }}</option>
                                                <option value="Orthopedics" {{ request('specialty') == 'Orthopedics' ? 'selected' : '' }}>{{ __('Orthopedics') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-xl-4 ms-auto">
                                        <div class="doctor-submit">
                                            <button type="submit" class="btn btn-primary submit-list-form me-2">{{ __('Search') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /Фильтры -->

                        <!-- Таблица списка докторов -->
                        <div class="table-responsive">
                            <table class="table border-0 custom-table comman-table datatable mb-0" id="DataTables_Table_0">
                                <thead>
                                <tr role="row">
                                    <th style="width: 62.8438px;">
                                        <div class="form-check check-tables">
                                            <!-- Чекбокс для "выбрать все" без привязки к $doctor -->
                                            <input class="form-check-input" type="checkbox" id="select-all" value="all">
                                        </div>
                                    </th>
                                    <th>User ID</th>
                                    <th>Full Name</th>
                                    <th>Workplace</th>
                                    <th>Specialty</th>
                                    <th>Appointments</th>
                                    <th>Role</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($doctors as $doctor)
                                    @php
                                        $role = $doctor->getRoleNames()->first() ?? 'N/A';
                                        switch($role) {
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
                                    <tr class="{{ $loop->iteration % 2 == 0 ? 'even' : 'odd' }}">
                                        <td>
                                            <div class="form-check check-tables">
                                                <input type="checkbox" class="form-check-input row-checkbox" value="{{ $doctor->id }}">
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('doctors.show', $doctor->id) }}">
                                                {{ $prefix . str_pad($doctor->id, 4, '0', STR_PAD_LEFT) }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('doctors.show', $doctor->id) }}">
                                                {{ $doctor->name }}
                                            </a>
                                        </td>
                                        <td>{{ $doctor->workplace ?? 'N/A' }}</td>
                                        <td>{{ $doctor->specialty ?? 'N/A' }}</td>
                                        <td>{{ rand(1, 20) }}</td>
                                        <td>
                                            <button class="custom-badge {{ $badgeClass }}">
                                                {{ $role }}
                                            </button>
                                        </td>
                                        <td class="text-end">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="{{ route('doctors.edit', $doctor->id) }}">
                                                        <i class="fa-solid fa-pen-to-square m-r-5"></i> Edit
                                                    </a>
                                                    <a class="dropdown-item" href="{{ route('doctors.show', $doctor->id) }}">
                                                        <i class="feather-eye m-r-5"></i> View
                                                    </a>
                                                    <!-- Пункт Download для экспорта в PDF одной модели -->
                                                    <a class="dropdown-item" href="{{ route('doctors.pdf', $doctor->id) }}">
                                                        <i class="feather-download m-r-5"></i> Download
                                                    </a>
                                                    <!-- Пункт Delete с подтверждением -->
                                                    <a class="dropdown-item" href="#"
                                                       onclick="if(confirm('Are you sure you want to delete this doctor?')) { document.getElementById('delete-form-{{ $doctor->id }}').submit(); } return false;">
                                                        <i class="fa fa-trash-alt m-r-5"></i> Delete
                                                    </a>
                                                    <!-- Форма для удаления (скрытая) -->
                                                    <form id="delete-form-{{ $doctor->id }}" action="{{ route('doctors.destroy', $doctor->id) }}" method="POST" style="display:none;">
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
                $(document).ready(function() {

                    // Обработчик для чекбокса "выбрать все"
                    $('#select-all').on('change', function() {
                        $('.row-checkbox').prop('checked', $(this).prop('checked'));
                    });

                    // Обработчик для кнопки "refresh"
                    $('#refreshBtn').on('click', function(e) {
                        e.preventDefault();
                        $('#topSearchForm').submit();
                    });

                    // Функция для сбора выбранных id
                    function getSelectedIds() {
                        return $('.row-checkbox:checked').map(function() {
                            return $(this).val();
                        }).get().join(',');
                    }

                    // Экспорт PDF
                    $('#exportPdfBtn').on('click', function(e) {
                        e.preventDefault();
                        var ids = getSelectedIds();
                        var url = new URL("{{ route('doctors.reports.pdf') }}", window.location.origin);
                        var params = new URLSearchParams(window.location.search);
                        if(ids.length > 0) {
                            params.set('ids', ids);
                        }
                        url.search = params.toString();
                        window.location.href = url.toString();
                    });

                    // Экспорт Excel
                    $('#exportExcelBtn').on('click', function(e) {
                        e.preventDefault();
                        var ids = getSelectedIds();
                        var url = new URL("{{ route('doctors.reports.excel') }}", window.location.origin);
                        var params = new URLSearchParams(window.location.search);
                        if(ids.length > 0) {
                            params.set('ids', ids);
                        }
                        url.search = params.toString();
                        window.location.href = url.toString();
                    });
                });
            </script>
    @endpush
