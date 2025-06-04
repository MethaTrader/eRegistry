@extends('layouts.app')

@section('content')
    <div class="content">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('doctors.index') }}">{{ __('Doctors') }}</a></li>
                        <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                        <li class="breadcrumb-item active">{{ __('Doctor Details') }}</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-md-12">
                <div class="card">

                    <div class="col-auto text-end float-end ms-auto download-grp">
                        <a href="{{ route('doctors.pdf', $doctor->id) }}" class="me-2 btn btn-white">
                            <img src="{{ asset('assets/img/icons/pdf-icon-01.svg') }}" alt="Export PDF">
                        </a>
                        <a href="{{ route('doctors.excel', $doctor->id) }}" class="me-2 btn btn-white">
                            <img src="{{ asset('assets/img/icons/pdf-icon-04.svg') }}" alt="Excel Report">
                        </a>
                        <!-- Другие кнопки, если необходимо -->
                    </div>

                    <!-- Заголовок карточки -->
                    <div class="card-header">
                        <h2 class="title">{{ $doctor->name }}</h2>
                    </div>
                    <!-- Тело карточки с информацией о враче -->
                    <div class="card-body">
                        @php
                            // Определяем префикс для ID и класс плашки для роли
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

                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>{{ __('Doctor ID:') }}</strong> {{ $prefix . str_pad($doctor->id, 4, '0', STR_PAD_LEFT) }}</p>
                                <p><strong>{{ __('Email:') }}</strong> {{ $doctor->email }}</p>
                                <p><strong>{{ __('Workplace:') }}</strong> {{ $doctor->workplace ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>{{ __('Specialty:') }}</strong> {{ $doctor->specialty ?? 'N/A' }}</p>
                                <p>
                                    <strong>{{ __('Role:') }}</strong>
                                    <span class="custom-badge {{ $badgeClass }}">
                                    {{ $doctor->getRoleNames()->first() }}
                                </span>
                                </p>
                                <p><strong>{{ __('Registration Date:') }}</strong> {{ $doctor->created_at ? $doctor->created_at->format('d.m.Y') : 'N/A' }}</p>
                            </div>
                        </div>

                        @if(!empty($doctor->additional_information))
                            <div class="mt-3">
                                <h5>{{ __('Additional Information') }}</h5>
                                <p>{{ $doctor->additional_information }}</p>
                            </div>
                        @endif
                    </div>
                    <!-- Футер карточки с кнопками -->
                    <div class="card-footer text-end">
                        <a href="{{ route('doctors.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
                        <a href="{{ route('doctors.edit', $doctor) }}" class="btn btn-primary">{{ __('Edit') }}</a>
                        <!-- Кнопка для скачивания PDF-отчёта -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
