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
                        <li class="breadcrumb-item active">Edit Patient</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">

                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Display Validation Errors -->
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>There were some problems with your input:</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Форма редактирования пациента -->
                        <form action="{{ route('patients.update', $patient->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <!-- Full Name -->
                                <div class="col-12 col-md-6 col-xl-4 mt-2">
                                    <div class="input-block local-forms">
                                        <label>Full Name <span class="login-danger">*</span></label>
                                        <input class="form-control @error('full_name') is-invalid @enderror" name="full_name" type="text" placeholder="Enter full name" value="{{ old('full_name', $patient->full_name) }}" required>
                                        @error('full_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Date of Birth (формат DD/MM/YYYY) -->
                                <div class="col-12 col-md-6 col-xl-4">
                                    <div class="input-block local-forms cal-icon">
                                        <label>Date of Birth</label>
                                        <input class="form-control datetimepicker @error('date_of_birth') is-invalid @enderror" name="date_of_birth" type="text" placeholder="DD/MM/YYYY" value="{{ old('date_of_birth', $patient->date_of_birth ? \Carbon\Carbon::parse($patient->date_of_birth)->format('d/m/Y') : '') }}">
                                        @error('date_of_birth')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Gender -->
                                <div class="col-12 col-md-6 col-xl-4">
                                    <div class="input-block select-gender">
                                        <label class="gen-label">Gender <span class="login-danger">*</span></label>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" name="gender" class="form-check-input mt-0" value="Male" {{ old('gender', $patient->gender) == 'Male' ? 'checked' : '' }} required>Male
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" name="gender" class="form-check-input mt-0" value="Female" {{ old('gender', $patient->gender) == 'Female' ? 'checked' : '' }} required>Female
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" name="gender" class="form-check-input mt-0" value="Other" {{ old('gender', $patient->gender) == 'Other' ? 'checked' : '' }}>Other
                                            </label>
                                        </div>
                                        @error('gender')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Phone Number -->
                                <div class="col-12 col-md-6 col-xl-6">
                                    <div class="input-block local-forms">
                                        <label>Phone Number</label>
                                        <input class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" type="tel" placeholder="Enter phone number" value="{{ old('phone_number', $patient->phone_number) }}">
                                        @error('phone_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Email Address -->
                                <div class="col-12 col-md-6 col-xl-6">
                                    <div class="input-block local-forms">
                                        <label>Email Address <span class="login-danger">*</span></label>
                                        <input class="form-control @error('email') is-invalid @enderror" name="email" type="email" placeholder="Enter email address" value="{{ old('email', $patient->email) }}" required>
                                        @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Address -->
                                <div class="col-12">
                                    <div class="input-block local-forms">
                                        <label>Address</label>
                                        <textarea class="form-control @error('address') is-invalid @enderror" name="address" rows="3" placeholder="Enter full address">{{ old('address', $patient->address) }}</textarea>
                                        @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Demographic and Socioeconomic Information -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-heading d-flex justify-content-between align-items-center">
                                        <h4>Demographic and Socioeconomic Information</h4>
                                        <small class="badge bg-info">Optional</small>
                                    </div>
                                </div>

                                <!-- Ethnicity -->
                                <div class="col-12 col-md-6">
                                    <div class="input-block local-forms">
                                        <label>Ethnicity</label>
                                        <select class="form-control @error('ethnicity') is-invalid @enderror" name="ethnicity">
                                            <option value="">Select ethnicity</option>
                                            <option value="hispanic" {{ old('ethnicity', $patient->ethnicity) == 'hispanic' ? 'selected' : '' }}>Hispanic or Latino</option>
                                            <option value="non_hispanic" {{ old('ethnicity', $patient->ethnicity) == 'non_hispanic' ? 'selected' : '' }}>Not Hispanic or Latino</option>
                                            <option value="unknown" {{ old('ethnicity', $patient->ethnicity) == 'unknown' ? 'selected' : '' }}>Unknown</option>
                                        </select>
                                        @error('ethnicity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Race -->
                                <div class="col-12 col-md-6">
                                    <div class="input-block local-forms">
                                        <label>Race</label>
                                        <select class="form-control @error('race') is-invalid @enderror" name="race">
                                            <option value="">Select race</option>
                                            <option value="white" {{ old('race', $patient->race) == 'white' ? 'selected' : '' }}>White</option>
                                            <option value="black" {{ old('race', $patient->race) == 'black' ? 'selected' : '' }}>Black or African American</option>
                                            <option value="asian" {{ old('race', $patient->race) == 'asian' ? 'selected' : '' }}>Asian</option>
                                            <option value="native" {{ old('race', $patient->race) == 'native' ? 'selected' : '' }}>American Indian or Alaska Native</option>
                                            <option value="pacific" {{ old('race', $patient->race) == 'pacific' ? 'selected' : '' }}>Native Hawaiian or Other Pacific Islander</option>
                                            <option value="other" {{ old('race', $patient->race) == 'other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        @error('race')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Occupation -->
                                <div class="col-12 col-md-6">
                                    <div class="input-block local-forms">
                                        <label>Occupation</label>
                                        <input class="form-control @error('occupation') is-invalid @enderror" name="occupation" type="text" placeholder="Enter occupation" value="{{ old('occupation', $patient->occupation) }}">
                                        @error('occupation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Insurance Status -->
                                <div class="col-12 col-md-6">
                                    <div class="input-block local-forms">
                                        <label>Insurance Status</label>
                                        <select class="form-control @error('insurance_status') is-invalid @enderror" name="insurance_status">
                                            <option value="">Select status</option>
                                            <option value="Insured" {{ old('insurance_status', $patient->insurance_status) == 'Insured' ? 'selected' : '' }}>Insured</option>
                                            <option value="Uninsured" {{ old('insurance_status', $patient->insurance_status) == 'Uninsured' ? 'selected' : '' }}>Uninsured</option>
                                        </select>
                                        @error('insurance_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Socioeconomic Factors -->
                                <div class="col-12">
                                    <div class="input-block local-forms">
                                        <label>Socioeconomic Factors</label>
                                        <textarea class="form-control @error('socioeconomic_factors') is-invalid @enderror" name="socioeconomic_factors" rows="3" placeholder="Describe socioeconomic factors">{{ old('socioeconomic_factors', $patient->socioeconomic_factors) }}</textarea>
                                        @error('socioeconomic_factors')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Lifestyle Information -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-heading d-flex justify-content-between align-items-center">
                                        <h4>Lifestyle</h4>
                                        <small class="badge bg-info">Optional</small>
                                    </div>
                                </div>
                                <!-- Alcohol Consumption -->
                                <div class="col-12 col-md-4">
                                    <div class="input-block local-forms">
                                        <label>Alcohol Consumption</label>
                                        <select class="form-control @error('alcohol_consumption') is-invalid @enderror" name="alcohol_consumption">
                                            <option value="">Select status</option>
                                            <option value="Never" {{ old('alcohol_consumption', $patient->alcohol_consumption) == 'Never' ? 'selected' : '' }}>Never</option>
                                            <option value="Former" {{ old('alcohol_consumption', $patient->alcohol_consumption) == 'Former' ? 'selected' : '' }}>Former</option>
                                            <option value="Current" {{ old('alcohol_consumption', $patient->alcohol_consumption) == 'Current' ? 'selected' : '' }}>Current</option>
                                        </select>
                                        @error('alcohol_consumption')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Smoking Status -->
                                <div class="col-12 col-md-4">
                                    <div class="input-block local-forms">
                                        <label>Smoking Status</label>
                                        <select class="form-control @error('smoking_status') is-invalid @enderror" name="smoking_status">
                                            <option value="">Select status</option>
                                            <option value="Never" {{ old('smoking_status', $patient->smoking_status) == 'Never' ? 'selected' : '' }}>Never</option>
                                            <option value="Former" {{ old('smoking_status', $patient->smoking_status) == 'Former' ? 'selected' : '' }}>Former</option>
                                            <option value="Current" {{ old('smoking_status', $patient->smoking_status) == 'Current' ? 'selected' : '' }}>Current</option>
                                        </select>
                                        @error('smoking_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Radiation Exposure -->
                                <div class="col-12 col-md-4">
                                    <div class="input-block local-forms">
                                        <label>Radiation Exposure</label>
                                        <textarea class="form-control @error('radiation_exposure') is-invalid @enderror" name="radiation_exposure" rows="2" placeholder="Describe radiation exposure">{{ old('radiation_exposure', $patient->radiation_exposure) }}</textarea>
                                        @error('radiation_exposure')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Medical Data -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-heading d-flex justify-content-between align-items-center">
                                        <h4>Additional Medical Data</h4>
                                        <small class="badge bg-info">Optional</small>
                                    </div>
                                </div>
                                <!-- Karnofsky Performance Scale -->
                                <div class="col-12 col-md-6">
                                    <div class="input-block local-forms">
                                        <label>Karnofsky Performance Scale</label>
                                        <input class="form-control @error('karnofsky_performance_scale') is-invalid @enderror" name="karnofsky_performance_scale" type="number" min="0" max="100" placeholder="Enter score (0-100)" value="{{ old('karnofsky_performance_scale', $patient->karnofsky_performance_scale) }}">
                                        @error('karnofsky_performance_scale')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Symptoms Reported -->
                                <div class="col-12">
                                    <div class="input-block local-forms">
                                        <label>Symptoms Reported</label>
                                        <textarea class="form-control @error('symptoms_reported') is-invalid @enderror" name="symptoms_reported" rows="3" placeholder="List symptoms">{{ old('symptoms_reported', $patient->symptoms_reported) }}</textarea>
                                        @error('symptoms_reported')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Quality of Life Assessments -->
                                <div class="col-12">
                                    <div class="input-block local-forms">
                                        <label>Quality of Life Assessments</label>
                                        <textarea class="form-control @error('quality_of_life_assessments') is-invalid @enderror" name="quality_of_life_assessments" rows="3" placeholder="Describe quality of life assessments">{{ old('quality_of_life_assessments', $patient->quality_of_life_assessments) }}</textarea>
                                        @error('quality_of_life_assessments')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Ophthalmologic Assessment -->
                                <div class="col-12 col-md-6">
                                    <div class="input-block local-forms">
                                        <label>Ophthalmologic Assessment</label>
                                        <textarea class="form-control @error('ophthalmologic_assessment') is-invalid @enderror" name="ophthalmologic_assessment" rows="3" placeholder="Describe ophthalmologic assessment">{{ old('ophthalmologic_assessment', $patient->ophthalmologic_assessment) }}</textarea>
                                        @error('ophthalmologic_assessment')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <!-- EEG Results -->
                                <div class="col-12 col-md-6">
                                    <div class="input-block local-forms">
                                        <label>EEG Results</label>
                                        <textarea class="form-control @error('eeg_results') is-invalid @enderror" name="eeg_results" rows="3" placeholder="Describe EEG results">{{ old('eeg_results', $patient->eeg_results) }}</textarea>
                                        @error('eeg_results')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Submit and Cancel Buttons -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="doctor-submit text-end">
                                        <button type="submit" class="btn btn-primary submit-form me-2">Update Patient</button>
                                        <button type="reset" class="btn btn-secondary cancel-form">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div><!-- /card-body -->
                </div><!-- /card -->
            </div><!-- /col-sm-12 -->
        </div><!-- /row -->
    </div><!-- /content -->
@endsection
