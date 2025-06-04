<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    protected $model = Patient::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $specialties = ['Cardiology', 'Neurology', 'Pediatrics', 'Orthopedics'];
        $workplaces = [
            'Kyiv Medical Center',
            'Lviv Clinic',
            'Odesa Hospital',
            'Dnipro Health Institute',
            'Kharkiv Central Hospital'
        ];

        return [
            'full_name'       => $this->faker->name,
            'date_of_birth'   => $this->faker->optional()->date('Y-m-d'),
            'gender'          => $this->faker->randomElement(['Male', 'Female', 'Other']),
            'phone_number'    => $this->faker->optional()->phoneNumber,
            'email'           => $this->faker->unique()->safeEmail,
            'address'         => $this->faker->optional()->address,
            'ethnicity'             => $this->faker->optional()->word,
            'race'                  => $this->faker->optional()->word,
            'occupation'            => $this->faker->optional()->jobTitle,
            'insurance_status'      => $this->faker->optional()->randomElement(['Insured', 'Uninsured']),
            'socioeconomic_factors' => $this->faker->optional()->paragraph,
            'alcohol_consumption'   => $this->faker->optional()->randomElement(['Never', 'Former', 'Current']),
            'smoking_status'        => $this->faker->optional()->randomElement(['Never', 'Former', 'Current']),
            'radiation_exposure'    => $this->faker->optional()->sentence,
            'karnofsky_performance_scale' => $this->faker->optional()->numberBetween(0, 100),
            'symptoms_reported'           => $this->faker->optional()->paragraph,
            'quality_of_life_assessments' => $this->faker->optional()->paragraph,
            'ophthalmologic_assessment'   => $this->faker->optional()->paragraph,
            'eeg_results'                 => $this->faker->optional()->paragraph,
            // Создаем created_at в пределах текущего года
            'created_at' => $this->faker->dateTimeBetween('first day of January this year', 'last day of December this year'),
            'updated_at' => now(),
        ];
    }

}
