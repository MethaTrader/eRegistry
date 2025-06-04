@extends('layouts.app')

@section('content')
    <div class="content">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/doctors') }}">{{ __('Doctors') }}</a></li>
                        <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                        <li class="breadcrumb-item active">{{ __('Edit Doctor') }}</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Вывод ошибок валидации -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Форма редактирования врача -->
                        <form action="{{ route('doctors.update', ['doctor' => $doctor->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-heading d-flex justify-content-between align-items-center">
                                        <h4>{{ __('Information about doctor') }}</h4>
                                        <small class="badge bg-warning">{{ __('Fields marked with (*) are mandatory') }}</small>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-xl-4 mt-2">
                                    <div class="input-block local-forms">
                                        <label>{{ __('Name') }} <span class="login-danger">*</span></label>
                                        <input class="form-control" type="text" name="name" placeholder="{{ __('Enter doctor\'s name') }}" value="{{ old('name', $doctor->name) }}" required>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-xl-6 mt-2">
                                    <div class="input-block local-forms">
                                        <label>{{ __('Email') }} <span class="login-danger">*</span></label>
                                        <input class="form-control" type="email" name="email" placeholder="{{ __('Enter doctor\'s email') }}" value="{{ old('email', $doctor->email) }}" required>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-xl-4 mt-2">
                                    <div class="input-block local-forms">
                                        <label>{{ __('Workplace') }}</label>
                                        <input class="form-control" type="text" name="workplace" placeholder="{{ __('Enter workplace') }}" value="{{ old('workplace', $doctor->workplace) }}">
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-xl-4 mt-2">
                                    <div class="input-block local-forms">
                                        <label>{{ __('Specialty') }}</label>
                                        <select class="form-control select" name="specialty">
                                            <option value="">{{ __('Select Specialty') }}</option>
                                            <option value="Neurology" {{ old('specialty', $doctor->specialty) == 'Neurology' ? 'selected' : '' }}>{{ __('Neurology') }}</option>
                                            <option value="Oncology" {{ old('specialty', $doctor->specialty) == 'Oncology' ? 'selected' : '' }}>{{ __('Oncology') }}</option>
                                            <option value="Neurosurgery" {{ old('specialty', $doctor->specialty) == 'Neurosurgery' ? 'selected' : '' }}>{{ __('Neurosurgery') }}</option>
                                            <option value="Radiology" {{ old('specialty', $doctor->specialty) == 'Radiology' ? 'selected' : '' }}>{{ __('Radiology') }}</option>
                                            <option value="Pathology" {{ old('specialty', $doctor->specialty) == 'Pathology' ? 'selected' : '' }}>{{ __('Pathology') }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-12 mt-2">
                                    <div class="input-block local-forms">
                                        <label>{{ __('Additional information') }}</label>
                                        <textarea class="form-control" name="additional_information" rows="3" placeholder="{{ __('Enter additional information') }}">{{ old('additional_information', $doctor->additional_information) }}</textarea>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-xl-4 mt-2">
                                    <div class="input-block local-forms">
                                        <label>{{ __('Role') }} <span class="login-danger">*</span></label>
                                        <select class="form-control select" name="role" required>
                                            @php
                                                // Получаем первую назначенную роль через spatie (предполагаем, что всегда одна роль назначена)
                                                $currentRole = $doctor->getRoleNames()->first() ?? 'Doctor';
                                            @endphp
                                            <option value="Doctor" {{ old('role', $currentRole) == 'Doctor' ? 'selected' : '' }}>Doctor</option>
                                            <option value="User" {{ old('role', $currentRole) == 'User' ? 'selected' : '' }}>User</option>
                                            <option value="Administrator" {{ old('role', $currentRole) == 'Administrator' ? 'selected' : '' }}>Administrator</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Поле отправки авторизационных данных можно оставить как radio, если требуется -->
                                <div class="col-12 col-md-12 col-xl-12 mt-2">
                                    <div class="input-block select-gender">
                                        <label class="gen-label">{{ __('Send authorization details via email') }}</label>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" id="send_immediately" name="password_send" class="form-check-input mt-0" value="immediately" {{ old('password_send', 'immediately') == 'immediately' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="send_immediately">{{ __('Send immediately') }}</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" id="do_not_send" name="password_send" class="form-check-input mt-0" value="do_not_send" {{ old('password_send') == 'do_not_send' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="do_not_send">{{ __('Do not send') }}</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mt-3">
                                    <div class="doctor-submit text-end">
                                        <button type="submit" class="btn btn-primary submit-form me-2">{{ __('Update') }}</button>
                                        <a href="{{ url('/doctors') }}" class="btn btn-secondary cancel-form">{{ __('Cancel') }}</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div><!-- /.card-body -->
                </div><!-- /.card -->
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Дополнительные скрипты, если необходимо
    </script>
@endpush
