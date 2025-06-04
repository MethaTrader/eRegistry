@extends('layouts.app')

@section('content')
    <div class="content">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/doctors')}}">Doctors </a></li>
                        <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                        <li class="breadcrumb-item active">Add doctor</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <div class="row">
            <div class="col-sm-12">

                <div class="card">
                    <div class="card-body">

                        @if(session('credentials'))
                            <div class="alert alert-success" id="credentialsBlock">
                                <h4>Account credentials</h4>
                                <p><strong>Role:</strong> {{ session('credentials.role') }}</p>
                                <p><strong>Email:</strong> <strong id="credEmail">{{ session('credentials.email') }}</strong></p>
                                <p><strong>Password:</strong> <strong id="credPassword">{{ session('credentials.password') }}</strong></p>
                                <button type="button" class="btn btn-secondary" id="copyBtn">
                                    <i class="fas fa-copy"></i> Copy credentials
                                </button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif


                        <form action="{{route('doctors.store')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-heading d-flex justify-content-between align-items-center">
                                        <h4>Information about doctor</h4>
                                        <small class="badge bg-warning">Fields marked with (*) are mandatory</small>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-xl-4 mt-2">
                                    <div class="input-block local-forms">
                                        <label>Name <span class="login-danger">*</span></label>
                                        <input class="form-control" type="text" name="name" placeholder="">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-xl-6">
                                    <div class="input-block local-forms">
                                        <label>Email <span class="login-danger">*</span></label>
                                        <input class="form-control" type="email" name="email" placeholder="">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-xl-4">
                                    <div class="input-block local-forms">
                                        <label>Workplace</label>
                                        <input class="form-control" type="text" name="workplace" placeholder="">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-xl-4">
                                    <div class="input-block local-forms">
                                        <label>Specialty</label>
                                        <select class="form-control select select2-hidden-accessible" name="specialty" tabindex="-1" aria-hidden="true">
                                            <option>Select Specialty</option>
                                            <option>Neurology</option>
                                            <option>Oncology</option>
                                            <option>Neurosurgery</option>
                                            <option>Radiology</option>
                                            <option>Pathology</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12">
                                    <div class="input-block local-forms">
                                        <label>Additional information</label>
                                        <textarea class="form-control" name="additional_information" rows="3" cols="30"></textarea>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-xl-4 mt-2">
                                    <div class="input-block local-forms">
                                        <label>{{ __('Role') }} <span class="login-danger">*</span></label>
                                        <select class="form-control select" name="role" required>
                                            <option value="Doctor" {{ old('role', 'Doctor') == 'Doctor' ? 'selected' : '' }}>Doctor</option>
                                            <option value="User" {{ old('role') == 'User' ? 'selected' : '' }}>User</option>
                                            <option value="Administrator" {{ old('role') == 'Administrator' ? 'selected' : '' }}>Administrator</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="col-12 col-md-12 col-xl-12">
                                    <div class="input-block select-gender">
                                        <label class="gen-label">Send authorization details via email</label>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" checked="" name="password-send" class="form-check-input mt-0">Send immediately
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" name="password-send" class="form-check-input mt-0">Do not send
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="doctor-submit text-end">
                                        <button type="submit" class="btn btn-primary submit-form me-2">Create</button>
                                        <button type="submit" class="btn btn-primary cancel-form">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const copyBtn = document.getElementById('copyBtn');
            if (copyBtn) {
                copyBtn.addEventListener('click', function() {
                    const role = "{{ session('credentials.role') }}";
                    const email = "{{ session('credentials.email') }}";
                    const password = "{{ session('credentials.password') }}";
                    const textToCopy = `Account credentials\nRole: ${role}\nEmail: ${email}\nPassword: ${password}`;
                    navigator.clipboard.writeText(textToCopy)
                        .then(() => { alert('Credentials copied to clipboard!'); })
                        .catch(err => { console.error('Error copying text: ', err); });
                });
            }
        });
    </script>
@endpush