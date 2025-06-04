<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('monitoring', function (Blueprint $table) {
            $table->id();

            // Связь с пациентом: один пациент может иметь много записей мониторинга
            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')
                ->references('id')
                ->on('patients')
                ->onDelete('cascade');

            // Основные даты
            $table->date('visit_date');
            $table->date('diagnosis_date');

            // Основные поля мониторинга
            $table->string('cancer_type', 100)->nullable();       // тип опухоли, например, glioblastoma, meningioma и т.д.
            $table->string('stage', 50)->nullable();                // стадия
            $table->string('grade', 50)->nullable();                // грейд

            // Файл отчётов патологии (хранится путь к файлу)
            $table->string('pathology_reports', 255)->nullable();

            // Оперативная информация
            $table->text('surgeries')->nullable();                // подробности по хирургическим вмешательствам

            // Лечение
            $table->text('chemotherapy')->nullable();
            $table->text('radiation_therapy')->nullable();

            // Даты и файлы МРТ и КТ
            $table->date('mri_date')->nullable();
            $table->string('mri_findings', 255)->nullable();
            $table->date('ct_date')->nullable();
            $table->string('ct_findings', 255)->nullable();

            // Повторяющиеся секции: follow-up и прогрессия
            // Здесь followup_date и progression_date сохраняются как тип DATE
            $table->date('followup_date')->nullable();
            $table->text('followup_results')->nullable();       // результаты последующего визита
            $table->date('progression_date')->nullable();
            $table->text('progression_site')->nullable();         // сайт рецидива/прогрессии
            $table->text('progression_treatment')->nullable();    // назначенное лечение при прогрессировании

            // Дополнительные данные
            $table->text('functional_status')->nullable();
            $table->text('genetic_testing')->nullable();
            $table->text('biomarker_data')->nullable();
            $table->text('genetic_mutations')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitoring');
    }
};
