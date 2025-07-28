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
                        <li class="breadcrumb-item active">Add Monitoring</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <!-- Кнопка Load Last Monitoring (размещена в правом верхнем углу формы) -->
        <div class="d-flex justify-content-end mb-3">
            @if($selectedPatientId)
                <a href="{{ route('monitoring.create', ['patient_id' => $selectedPatientId, 'load_last' => 1]) }}" class="btn btn-outline-info" title="Load Last Monitoring">
                    <i class="fa fa-history"></i> Load Last Monitoring
                </a>
            @endif
        </div>

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

                        <!-- Форма для создания мониторинга -->
                        <form action="{{ route('monitoring.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
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
                                        <select id="patientSelect" name="patient_id" class="form-control select2" required>
                                            <option value="">Select patient</option>
                                            @foreach($patients as $p)
                                                <option value="{{ $p->id }}" {{ old('patient_id', $selectedPatientId) == $p->id ? 'selected' : '' }}>
                                                    {{ $p->full_name }} ({{ 'P-' . str_pad($p->id, 6, '0', STR_PAD_LEFT) }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- 2) Дата визита -->
                                <div class="col-12 col-md-6">
                                    <div class="input-block local-forms cal-icon">
                                        <label>Date of Visit <span class="login-danger">*</span></label>
                                        <input name="visit_date" class="form-control datetimepicker" type="text" placeholder="YYYY-MM-DD" required value="{{ old('visit_date', $lastMonitoring ? $lastMonitoring->visit_date : '') }}">
                                    </div>
                                </div>

                                <!-- 3) Основные поля мониторинга -->
                                <!-- Type of Neurological Cancer -->
                                <!-- Type of Neurological Cancer -->
                                <div class="col-12 col-md-6">
                                    <div class="input-block local-forms">
                                        <label>Type of Neurological Cancer</label>
                                        <input list="cancer_types" name="cancer_type" class="form-control" placeholder="Select or enter cancer type" value="{{ old('cancer_type', $lastMonitoring ? $lastMonitoring->cancer_type : '') }}">
                                        <datalist id="cancer_types">
                                            <!-- Глиомы взрослого типа -->
                                            <option value="Astrocytoma, IDH-mutant">Astrocytoma, IDH-mutant</option>
                                            <option value="Oligodendroglioma, IDH-mutant and 1p/19q-codeleted">Oligodendroglioma, IDH-mutant and 1p/19q-codeleted</option>
                                            <option value="Glioblastoma, IDH-wildtype">Glioblastoma, IDH-wildtype</option>

                                            <!-- Педиатрические диффузные глиомы низкой степени -->
                                            <option value="Diffuse astrocytoma, MYB- or MYBL1-altered">Diffuse astrocytoma, MYB- or MYBL1-altered</option>
                                            <option value="Angiocentric glioma">Angiocentric glioma</option>
                                            <option value="Polymorphous low-grade neuroepithelial tumor of the young">Polymorphous low-grade neuroepithelial tumor of the young</option>
                                            <option value="Diffuse low-grade glioma, MAPK pathway-altered">Diffuse low-grade glioma, MAPK pathway-altered</option>

                                            <!-- Педиатрические диффузные глиомы высокой степени -->
                                            <option value="Diffuse midline glioma, H3 K27-altered">Diffuse midline glioma, H3 K27-altered</option>
                                            <option value="Diffuse hemispheric glioma, H3 G34-mutant">Diffuse hemispheric glioma, H3 G34-mutant</option>
                                            <option value="Diffuse pediatric-type high-grade glioma, H3-wildtype and IDH-wildtype">Diffuse pediatric-type high-grade glioma, H3-wildtype and IDH-wildtype</option>
                                            <option value="Infant-type hemispheric glioma">Infant-type hemispheric glioma</option>

                                            <!-- Ограниченные астроцитарные глиомы -->
                                            <option value="Pilocytic astrocytoma">Pilocytic astrocytoma</option>
                                            <option value="High-grade astrocytoma with piloid features">High-grade astrocytoma with piloid features</option>
                                            <option value="Pleomorphic xanthoastrocytoma">Pleomorphic xanthoastrocytoma</option>
                                            <option value="Subependymal giant cell astrocytoma">Subependymal giant cell astrocytoma</option>
                                            <option value="Chordoid glioma">Chordoid glioma</option>
                                            <option value="Astroblastoma, MN1-altered">Astroblastoma, MN1-altered</option>

                                            <!-- Глионевральные и нейрональные опухоли -->
                                            <option value="Ganglioglioma">Ganglioglioma</option>
                                            <option value="Gangliocytoma">Gangliocytoma</option>
                                            <option value="Dysembryoplastic neuroepithelial tumor">Dysembryoplastic neuroepithelial tumor</option>
                                            <option value="Multinodular and vacuolating neuronal tumor">Multinodular and vacuolating neuronal tumor</option>
                                            <option value="Diffuse glioneuronal tumor with oligodendroglioma-like features and nuclear clusters">Diffuse glioneuronal tumor with oligodendroglioma-like features and nuclear clusters</option>
                                            <option value="Papillary glioneuronal tumor">Papillary glioneuronal tumor</option>
                                            <option value="Rosette-forming glioneuronal tumor">Rosette-forming glioneuronal tumor</option>
                                            <option value="Myxoid glioneuronal tumor">Myxoid glioneuronal tumor</option>
                                            <option value="Diffuse leptomeningeal glioneuronal tumor">Diffuse leptomeningeal glioneuronal tumor</option>
                                            <option value="Central neurocytoma">Central neurocytoma</option>
                                            <option value="Cerebellar liponeurocytoma">Cerebellar liponeurocytoma</option>
                                            <option value="Extraventricular neurocytoma">Extraventricular neurocytoma</option>

                                            <!-- Эпендимальные опухоли -->
                                            <option value="Supratentorial ependymoma">Supratentorial ependymoma</option>
                                            <option value="ZFTA fusion-positive ependymoma">ZFTA fusion-positive ependymoma</option>
                                            <option value="YAP1 fusion-positive ependymoma">YAP1 fusion-positive ependymoma</option>
                                            <option value="Posterior fossa ependymoma">Posterior fossa ependymoma</option>
                                            <option value="PFA ependymoma">PFA ependymoma</option>
                                            <option value="PFB ependymoma">PFB ependymoma</option>
                                            <option value="Spinal ependymoma">Spinal ependymoma</option>
                                            <option value="Myxopapillary ependymoma">Myxopapillary ependymoma</option>
                                            <option value="Subependymoma">Subependymoma</option>

                                            <!-- Опухоли сосудистого сплетения -->
                                            <option value="Choroid plexus papilloma">Choroid plexus papilloma</option>
                                            <option value="Atypical choroid plexus papilloma">Atypical choroid plexus papilloma</option>
                                            <option value="Choroid plexus carcinoma">Choroid plexus carcinoma</option>

                                            <!-- Эмбриональные опухоли -->
                                            <option value="Medulloblastoma, WNT-activated">Medulloblastoma, WNT-activated</option>
                                            <option value="Medulloblastoma, SHH-activated and TP53-wildtype">Medulloblastoma, SHH-activated and TP53-wildtype</option>
                                            <option value="Medulloblastoma, SHH-activated and TP53-mutant">Medulloblastoma, SHH-activated and TP53-mutant</option>
                                            <option value="Medulloblastoma, non-WNT/non-SHH">Medulloblastoma, non-WNT/non-SHH</option>
                                            <option value="Atypical teratoid/rhabdoid tumor">Atypical teratoid/rhabdoid tumor</option>
                                            <option value="Cribriform neuroepithelial tumor">Cribriform neuroepithelial tumor</option>
                                            <option value="Embryonal tumor with multilayered rosettes">Embryonal tumor with multilayered rosettes</option>
                                            <option value="CNS neuroblastoma">CNS neuroblastoma</option>
                                            <option value="CNS ganglioneuroblastoma">CNS ganglioneuroblastoma</option>
                                            <option value="CNS embryonal tumor, NEC">CNS embryonal tumor, NEC</option>

                                            <!-- Опухоли пинеальной области -->
                                            <option value="Pineocytoma">Pineocytoma</option>
                                            <option value="Pineal parenchymal tumor of intermediate differentiation">Pineal parenchymal tumor of intermediate differentiation</option>
                                            <option value="Pineoblastoma">Pineoblastoma</option>
                                            <option value="Papillary tumor of the pineal region">Papillary tumor of the pineal region</option>

                                            <!-- Опухоли черепных и параспинальных нервов -->
                                            <option value="Schwannoma">Schwannoma</option>
                                            <option value="Melanotic schwannoma">Melanotic schwannoma</option>
                                            <option value="Neurofibroma">Neurofibroma</option>
                                            <option value="Perineurioma">Perineurioma</option>
                                            <option value="Malignant peripheral nerve sheath tumor">Malignant peripheral nerve sheath tumor</option>
                                            <option value="Hybrid nerve sheath tumor">Hybrid nerve sheath tumor</option>

                                            <!-- Менингиомы -->
                                            <option value="Meningioma">Meningioma</option>
                                            <option value="Meningothelial meningioma">Meningothelial meningioma</option>
                                            <option value="Fibrous meningioma">Fibrous meningioma</option>
                                            <option value="Transitional meningioma">Transitional meningioma</option>
                                            <option value="Psammomatous meningioma">Psammomatous meningioma</option>
                                            <option value="Angiomatous meningioma">Angiomatous meningioma</option>
                                            <option value="Microcystic meningioma">Microcystic meningioma</option>
                                            <option value="Secretory meningioma">Secretory meningioma</option>
                                            <option value="Lymphoplasmacyte-rich meningioma">Lymphoplasmacyte-rich meningioma</option>
                                            <option value="Metaplastic meningioma">Metaplastic meningioma</option>
                                            <option value="Chordoid meningioma">Chordoid meningioma</option>
                                            <option value="Clear cell meningioma">Clear cell meningioma</option>
                                            <option value="Atypical meningioma">Atypical meningioma</option>
                                            <option value="Papillary meningioma">Papillary meningioma</option>
                                            <option value="Rhabdoid meningioma">Rhabdoid meningioma</option>
                                            <option value="Anaplastic meningioma">Anaplastic meningioma</option>

                                            <!-- Мезенхимальные неменингиальные опухоли -->
                                            <option value="Solitary fibrous tumor/Hemangiopericytoma">Solitary fibrous tumor/Hemangiopericytoma</option>
                                            <option value="Hemangioblastoma">Hemangioblastoma</option>

                                            <!-- Меланоцитарные опухоли -->
                                            <option value="Meningeal melanocytoma">Meningeal melanocytoma</option>
                                            <option value="Meningeal melanoma">Meningeal melanoma</option>
                                            <option value="Meningeal melanomatosis">Meningeal melanomatosis</option>

                                            <!-- Лимфомы -->
                                            <option value="Primary CNS lymphoma">Primary CNS lymphoma</option>
                                            <option value="Primary CNS T-cell lymphoma">Primary CNS T-cell lymphoma</option>

                                            <!-- Гистиоцитарные опухоли -->
                                            <option value="Langerhans cell histiocytosis">Langerhans cell histiocytosis</option>
                                            <option value="Erdheim-Chester disease">Erdheim-Chester disease</option>
                                            <option value="Rosai-Dorfman disease">Rosai-Dorfman disease</option>

                                            <!-- Герминативно-клеточные опухоли -->
                                            <option value="Germinoma">Germinoma</option>
                                            <option value="Non-germinomatous germ cell tumor">Non-germinomatous germ cell tumor</option>
                                            <option value="Embryonal carcinoma">Embryonal carcinoma</option>
                                            <option value="Yolk sac tumor">Yolk sac tumor</option>
                                            <option value="Choriocarcinoma">Choriocarcinoma</option>
                                            <option value="Teratoma">Teratoma</option>
                                            <option value="Mixed germ cell tumor">Mixed germ cell tumor</option>

                                            <!-- Опухоли турецкого седла -->
                                            <option value="Craniopharyngioma, adamantinomatous">Craniopharyngioma, adamantinomatous</option>
                                            <option value="Craniopharyngioma, papillary">Craniopharyngioma, papillary</option>
                                            <option value="Granular cell tumor of the sellar region">Granular cell tumor of the sellar region</option>
                                            <option value="Pituitary adenoma">Pituitary adenoma</option>
                                            <option value="Pituitary blastoma">Pituitary blastoma</option>
                                            <option value="Spindle cell oncocytoma">Spindle cell oncocytoma</option>

                                            <!-- Метастатические опухоли -->
                                            <option value="Brain metastases">Brain metastases</option>
                                            <option value="Leptomeningeal metastases">Leptomeningeal metastases</option>
                                            <option value="Spinal metastases">Spinal metastases</option>

                                            <!-- Другие редкие типы -->
                                            <option value="Chordoma">Chordoma</option>
                                            <option value="Chondrosarcoma">Chondrosarcoma</option>
                                            <option value="Olfactory neuroblastoma">Olfactory neuroblastoma</option>
                                            <option value="Other">Other</option>
                                        </datalist>
                                    </div>
                                </div>

                                <!-- Stage -->
                                <div class="col-12 col-md-6">
                                    <div class="input-block local-forms">
                                        <label>Stage</label>
                                        <input name="stage" class="form-control" type="text" placeholder="Enter stage" value="{{ old('stage', $lastMonitoring ? $lastMonitoring->stage : '') }}">
                                    </div>
                                </div>

                                <!-- Grade -->
                                <div class="col-12 col-md-6">
                                    <div class="input-block local-forms">
                                        <label>Grade</label>
                                        <input name="grade" class="form-control" type="text" placeholder="Enter grade" value="{{ old('grade', $lastMonitoring ? $lastMonitoring->grade : '') }}">
                                    </div>
                                </div>

                                <!-- Date of Diagnosis -->
                                <div class="col-12 col-md-6">
                                    <div class="input-block local-forms cal-icon">
                                        <label>Date of Diagnosis <span class="login-danger">*</span></label>
                                        <input name="diagnosis_date" class="form-control datetimepicker" type="text" placeholder="YYYY-MM-DD" required value="{{ old('diagnosis_date', $lastMonitoring ? $lastMonitoring->diagnosis_date : '') }}">
                                    </div>
                                </div>

                                <!-- Pathology Reports with File Manager -->
                                <div class="col-12">
                                    <div class="input-block local-forms">
                                        <label>Pathology Reports</label>
                                        <div class="input-group">
                                            <input type="text" id="fm_pathology_reports" class="form-control" name="pathology_reports" value="{{ old('pathology_reports', $lastMonitoring ? $lastMonitoring->pathology_reports : '') }}" aria-label="Pathology Reports" aria-describedby="btn_fm_pathology_reports">
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
                                            <input type="text" id="fm_mri_findings" class="form-control" name="mri_findings" value="{{ old('mri_findings', $lastMonitoring ? $lastMonitoring->mri_findings : '') }}" aria-label="MRI Findings" aria-describedby="btn_fm_mri_findings">
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
                                            <input type="text" id="fm_ct_findings" class="form-control" name="ct_findings" value="{{ old('ct_findings', $lastMonitoring ? $lastMonitoring->ct_findings : '') }}" aria-label="CT Scan Findings" aria-describedby="btn_fm_ct_findings">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="button" id="btn_fm_ct_findings">Select</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="input-block local-forms">
                                        <label>Immunohistochemistry</label>
                                        <div class="input-group">
                                            <input type="text" id="fm_immunohistochemistry" class="form-control" name="immunohistochemistry" value="{{ old('immunohistochemistry', $lastMonitoring ? $lastMonitoring->immunohistochemistry : '') }}" aria-label="Immunohistochemistry" aria-describedby="btn_fm_immunohistochemistry">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="button" id="btn_fm_immunohistochemistry">Select</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- MRI Date -->
                                <div class="col-12 col-md-6">
                                    <div class="input-block local-forms cal-icon">
                                        <label>Date of MRI</label>
                                        <input name="mri_date" class="form-control datetimepicker" type="text" placeholder="YYYY-MM-DD" value="{{ old('mri_date', $lastMonitoring ? $lastMonitoring->mri_date : '') }}">
                                    </div>
                                </div>

                                <!-- CT Date -->
                                <div class="col-12 col-md-6">
                                    <div class="input-block local-forms cal-icon">
                                        <label>Date of CT Scan</label>
                                        <input name="ct_date" class="form-control datetimepicker" type="text" placeholder="YYYY-MM-DD" value="{{ old('ct_date', $lastMonitoring ? $lastMonitoring->ct_date : '') }}">
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
                                        <input name="followup_date" class="form-control datetimepicker" type="text" placeholder="YYYY-MM-DD" value="{{ old('followup_date', $lastMonitoring ? $lastMonitoring->followup_date : '') }}">
                                    </div>
                                    <div class="input-block local-forms">
                                        <label>Follow-up Results</label>
                                        <textarea name="followup_results" class="form-control" rows="2" placeholder="Results of follow-up visit">{{ old('followup_results', $lastMonitoring ? $lastMonitoring->followup_results : '') }}</textarea>
                                    </div>
                                </div>

                                <!-- Disease Progression or Recurrence -->
                                <div class="col-12">
                                    <div class="input-block local-forms">
                                        <label>Disease Progression Date</label>
                                        <input name="progression_date" class="form-control datetimepicker" type="text" placeholder="YYYY-MM-DD" value="{{ old('progression_date', $lastMonitoring ? $lastMonitoring->progression_date : '') }}">
                                    </div>
                                    <div class="input-block local-forms">
                                        <label>Progression Site</label>
                                        <input name="progression_site" class="form-control" type="text" placeholder="Site of recurrence" value="{{ old('progression_site', $lastMonitoring ? $lastMonitoring->progression_site : '') }}">
                                    </div>
                                    <div class="input-block local-forms">
                                        <label>Progression Treatment</label>
                                        <textarea name="progression_treatment" class="form-control" rows="2" placeholder="Treatment administered">{{ old('progression_treatment', $lastMonitoring ? $lastMonitoring->progression_treatment : '') }}</textarea>
                                    </div>
                                </div>

                                <!-- Functional Status and Quality of Life Assessments -->
                                <div class="col-12">
                                    <div class="input-block local-forms">
                                        <label>Functional Status and Quality of Life Assessments</label>
                                        <textarea name="functional_status" class="form-control" rows="3" placeholder="Describe functional status and quality of life">{{ old('functional_status', $lastMonitoring ? $lastMonitoring->functional_status : '') }}</textarea>
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
                                        <textarea name="genetic_testing" class="form-control" rows="3" placeholder="Enter genetic testing results">{{ old('genetic_testing', $lastMonitoring ? $lastMonitoring->genetic_testing : '') }}</textarea>
                                    </div>
                                </div>
                                <!-- Biomarker Data -->
                                <div class="col-12 col-md-6">
                                    <div class="input-block local-forms">
                                        <label>Biomarker Data</label>
                                        <textarea name="biomarker_data" class="form-control" rows="3" placeholder="Enter biomarker data">{{ old('biomarker_data', $lastMonitoring ? $lastMonitoring->biomarker_data : '') }}</textarea>
                                    </div>
                                </div>

                                <!-- Diagnoz -->
                                <div class="col-12">
                                    <div class="input-block local-forms">
                                        <label>Diagnoz</label>
                                        <textarea name="diagnoz" class="form-control" rows="3" placeholder="Enter diagnoz details">{{ old('diagnoz', $lastMonitoring ? $lastMonitoring->diagnoz : '') }}</textarea>
                                    </div>
                                </div>

                                <!-- Genetic Mutations -->
                                <div class="col-12">
                                    <div class="input-block local-forms">
                                        <label>Genetic Mutations</label>
                                        <input name="genetic_mutations" class="form-control" type="text" placeholder="Enter genetic mutations" value="{{ old('genetic_mutations', $lastMonitoring ? $lastMonitoring->genetic_mutations : '') }}">
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
            openFileManager('btn_fm_immunohistochemistry', 'fm_immunohistochemistry', 'monitoring/immunohistochemistry');
        });

        function fmSetLink(url) {
            if (window.selectedInputId) {
                document.getElementById(window.selectedInputId).value = url;
            }
        }
    </script>
@endpush
