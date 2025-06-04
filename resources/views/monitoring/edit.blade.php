@extends('layouts.app')

@section('content')
    <div class="content">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/monitoring') }}">Monitoring</a></li>
                        <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                        <li class="breadcrumb-item active">Edit Monitoring</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

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

                        <!-- Форма для редактирования мониторинга -->
                        <form action="{{ route('monitoring.update', [$monitoring->id]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <!-- Заголовок формы -->
                                <div class="col-12">
                                    <div class="form-heading d-flex justify-content-between align-items-center">
                                        <h4>Clinic Information</h4>
                                        <small class="badge bg-warning">Fields marked with (*) are mandatory</small>
                                    </div>
                                </div>

                                <!-- 1) Выбор пациента (Select2) -->
                                <div class="col-12 col-md-6">
                                    <div class="input-block local-forms">
                                        <label>Select Patient <span class="login-danger">*</span></label>
                                        <select name="patient_id" class="form-control select2" required>
                                            <option value="">Select patient</option>
                                            @foreach($patients as $patient)
                                                <option value="{{ $patient->id }}" {{ old('patient_id', $monitoring->patient_id) == $patient->id ? 'selected' : '' }}>
                                                    {{ $patient->full_name }} ({{ 'P-' . str_pad($patient->id, 6, '0', STR_PAD_LEFT) }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- 2) Дата визита -->
                                <div class="col-12 col-md-6">
                                    <div class="input-block local-forms cal-icon">
                                        <label>Date of Visit <span class="login-danger">*</span></label>
                                        <input name="visit_date" class="form-control datetimepicker" type="text" placeholder="YYYY-MM-DD" required value="{{ old('visit_date', $monitoring->visit_date) }}">
                                    </div>
                                </div>

                                <!-- 3) Основные поля мониторинга -->
                                <!-- Type of Neurological Cancer -->
                                <div class="col-12 col-md-6">
                                    <div class="input-block local-forms">
                                        <label>Type of Neurological Cancer</label>
                                        <select name="cancer_type" class="form-control select2">
                                            <option value="">Select type</option>
                                            <option value="glioblastoma" {{ old('cancer_type', $monitoring->cancer_type) == 'glioblastoma' ? 'selected' : '' }}>Glioblastoma</option>
                                            <option value="meningioma" {{ old('cancer_type', $monitoring->cancer_type) == 'meningioma' ? 'selected' : '' }}>Meningioma</option>
                                            <option value="neuroblastoma" {{ old('cancer_type', $monitoring->cancer_type) == 'neuroblastoma' ? 'selected' : '' }}>Neuroblastoma</option>
                                            <option value="other" {{ old('cancer_type', $monitoring->cancer_type) == 'other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Stage -->
                                <div class="col-12 col-md-6">
                                    <div class="input-block local-forms">
                                        <label>Stage</label>
                                        <input name="stage" class="form-control" type="text" placeholder="Enter stage" value="{{ old('stage', $monitoring->stage) }}">
                                    </div>
                                </div>

                                <!-- Grade -->
                                <div class="col-12 col-md-6">
                                    <div class="input-block local-forms">
                                        <label>Grade</label>
                                        <input name="grade" class="form-control" type="text" placeholder="Enter grade" value="{{ old('grade', $monitoring->grade) }}">
                                    </div>
                                </div>

                                <!-- Date of Diagnosis -->
                                <div class="col-12 col-md-6">
                                    <div class="input-block local-forms cal-icon">
                                        <label>Date of Diagnosis <span class="login-danger">*</span></label>
                                        <input name="diagnosis_date" class="form-control datetimepicker" type="text" placeholder="YYYY-MM-DD" required value="{{ old('diagnosis_date', $monitoring->diagnosis_date) }}">
                                    </div>
                                </div>

                                <!-- Pathology Reports with File Manager -->
                                <div class="col-12">
                                    <div class="input-block local-forms">
                                        <label>Pathology Reports</label>
                                        <div class="input-group">
                                            <input type="text" id="fm_pathology_reports" class="form-control" name="pathology_reports" value="{{ old('pathology_reports', $monitoring->pathology_reports) }}" aria-label="Pathology Reports" aria-describedby="btn_fm_pathology_reports">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="button" id="btn_fm_pathology_reports">Select</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- MRI Findings with File Manager -->
                                <div class="col-12">
                                    <div class="input-block local-forms">
                                        <label>MRI Findings</label>
                                        <div class="input-group">
                                            <input type="text" id="fm_mri_findings" class="form-control" name="mri_findings" value="{{ old('mri_findings', $monitoring->mri_findings) }}" aria-label="MRI Findings" aria-describedby="btn_fm_mri_findings">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="button" id="btn_fm_mri_findings">Select</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- CT Scan Findings with File Manager -->
                                <div class="col-12">
                                    <div class="input-block local-forms">
                                        <label>CT Scan Findings</label>
                                        <div class="input-group">
                                            <input type="text" id="fm_ct_findings" class="form-control" name="ct_findings" value="{{ old('ct_findings', $monitoring->ct_findings) }}" aria-label="CT Scan Findings" aria-describedby="btn_fm_ct_findings">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="button" id="btn_fm_ct_findings">Select</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- MRI Date -->
                                <div class="col-12 col-md-6">
                                    <div class="input-block local-forms cal-icon">
                                        <label>Date of MRI</label>
                                        <input name="mri_date" class="form-control datetimepicker" type="text" placeholder="YYYY-MM-DD" value="{{ old('mri_date', $monitoring->mri_date) }}">
                                    </div>
                                </div>

                                <!-- CT Date -->
                                <div class="col-12 col-md-6">
                                    <div class="input-block local-forms cal-icon">
                                        <label>Date of CT Scan</label>
                                        <input name="ct_date" class="form-control datetimepicker" type="text" placeholder="YYYY-MM-DD" value="{{ old('ct_date', $monitoring->ct_date) }}">
                                    </div>
                                </div>

                                <!-- Follow-up and Monitoring -->
                                <div class="col-12">
                                    <div class="form-heading d-flex justify-content-between align-items-center mt-4">
                                        <h4>Follow-up and Monitoring</h4>
                                        <small class="badge bg-info">These fields are optional</small>
                                    </div>
                                    <div class="input-block local-forms">
                                        <label>Follow-up Visit Date</label>
                                        <input name="followup_date" class="form-control datetimepicker" type="text" placeholder="YYYY-MM-DD" value="{{ old('followup_date', $monitoring->followup_date) }}">
                                    </div>
                                    <div class="input-block local-forms">
                                        <label>Follow-up Results</label>
                                        <textarea name="followup_results" class="form-control" rows="2" placeholder="Results of follow-up visit">{{ old('followup_results', $monitoring->followup_results) }}</textarea>
                                    </div>
                                </div>

                                <!-- Disease Progression or Recurrence -->
                                <div class="col-12">
                                    <div class="input-block local-forms">
                                        <label>Disease Progression Date</label>
                                        <input name="progression_date" class="form-control datetimepicker" type="text" placeholder="YYYY-MM-DD" value="{{ old('progression_date', $monitoring->progression_date) }}">
                                    </div>
                                    <div class="input-block local-forms">
                                        <label>Progression Site</label>
                                        <input name="progression_site" class="form-control" type="text" placeholder="Site of recurrence" value="{{ old('progression_site', $monitoring->progression_site) }}">
                                    </div>
                                    <div class="input-block local-forms">
                                        <label>Progression Treatment</label>
                                        <textarea name="progression_treatment" class="form-control" rows="2" placeholder="Treatment administered">{{ old('progression_treatment', $monitoring->progression_treatment) }}</textarea>
                                    </div>
                                </div>

                                <!-- Functional Status and Quality of Life Assessments -->
                                <div class="col-12">
                                    <div class="input-block local-forms">
                                        <label>Functional Status and Quality of Life Assessments</label>
                                        <textarea name="functional_status" class="form-control" rows="3" placeholder="Describe functional status and quality of life">{{ old('functional_status', $monitoring->functional_status) }}</textarea>
                                    </div>
                                </div>

                                <!-- Genetic and Biomarker Data -->
                                <div class="col-12">
                                    <div class="form-heading d-flex justify-content-between align-items-center mt-4">
                                        <h4>Genetic and Biomarker Data</h4>
                                        <small class="badge bg-info">Optional fields</small>
                                    </div>
                                </div>
                                <!-- Genetic Testing Results -->
                                <div class="col-12 col-md-6">
                                    <div class="input-block local-forms">
                                        <label>Genetic Testing Results</label>
                                        <textarea name="genetic_testing" class="form-control" rows="3" placeholder="Enter genetic testing results">{{ old('genetic_testing', $monitoring->genetic_testing) }}</textarea>
                                    </div>
                                </div>
                                <!-- Biomarker Data -->
                                <div class="col-12 col-md-6">
                                    <div class="input-block local-forms">
                                        <label>Biomarker Data</label>
                                        <textarea name="biomarker_data" class="form-control" rows="3" placeholder="Enter biomarker data">{{ old('biomarker_data', $monitoring->biomarker_data) }}</textarea>
                                    </div>
                                </div>
                                <!-- Genetic Mutations -->
                                <div class="col-12">
                                    <div class="input-block local-forms">
                                        <label>Genetic Mutations</label>
                                        <input name="genetic_mutations" class="form-control" type="text" placeholder="Enter genetic mutations" value="{{ old('genetic_mutations', $monitoring->genetic_mutations) }}">
                                    </div>
                                </div>

                                <!-- Кнопки Submit и Cancel -->
                                <div class="col-12">
                                    <div class="doctor-submit text-end mt-4">
                                        <button type="submit" class="btn btn-primary submit-form me-2">Save</button>
                                        <button type="reset" class="btn btn-secondary cancel-form">Cancel</button>
                                    </div>
                                </div>
                            </div> <!-- /row -->
                        </form>
                    </div><!-- /card-body -->
                </div><!-- /card -->
            </div><!-- /col-lg-12 -->
        </div><!-- /row -->
    </div><!-- /content -->
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Инициализация select2 (если используется)
            if ($('.select2').length > 0) {
                $('.select2').select2({ width: '100%' });
            }
        });

        document.addEventListener("DOMContentLoaded", function() {
            // Функция для открытия файлового менеджера для указанного input и каталога
            function openFileManager(buttonId, inputId, folderPath) {
                document.getElementById(buttonId).addEventListener('click', function(event) {
                    event.preventDefault();
                    window.open('/file-manager/fm-button?path=' + encodeURIComponent(folderPath), 'fm', 'width=1000,height=800');
                    window.selectedInputId = inputId;
                });
            }

            openFileManager('btn_fm_pathology_reports', 'fm_pathology_reports', 'monitoring/pathology_reports');
            openFileManager('btn_fm_mri_findings', 'fm_mri_findings', 'monitoring/mri_findings');
            openFileManager('btn_fm_ct_findings', 'fm_ct_findings', 'monitoring/ct_findings');
        });

        function fmSetLink(url) {
            if (window.selectedInputId) {
                document.getElementById(window.selectedInputId).value = url;
            }
        }
    </script>
@endpush
