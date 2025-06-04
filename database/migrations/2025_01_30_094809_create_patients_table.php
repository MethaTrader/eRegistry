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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();

            // Информация о пациенте
            $table->string('full_name');
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->string('phone_number', 18)->nullable();
            $table->string('email')->unique();
            $table->text('address')->nullable();

            // Демографическая и социально-экономическая информация
            $table->string('ethnicity')->nullable(); // Изменено с enum на string
            $table->string('race')->nullable();      // Изменено с enum на string
            $table->string('occupation')->nullable();
            $table->enum('insurance_status', ['Insured', 'Uninsured'])->nullable();
            $table->text('socioeconomic_factors')->nullable();

            // Образ жизни
            $table->enum('alcohol_consumption', ['Never', 'Former', 'Current'])->nullable();
            $table->enum('smoking_status', ['Never', 'Former', 'Current'])->nullable();
            $table->text('radiation_exposure')->nullable();

            // Дополнительные медицинские данные
            $table->unsignedTinyInteger('karnofsky_performance_scale')->nullable(); // от 0 до 100
            $table->text('symptoms_reported')->nullable();
            $table->text('quality_of_life_assessments')->nullable();
            $table->text('ophthalmologic_assessment')->nullable();
            $table->text('eeg_results')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
