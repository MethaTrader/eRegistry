<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Массивы для генерации случайных данных
        $specialties = ['Cardiology', 'Neurology', 'Pediatrics', 'Orthopedics'];
        $workplaces = [
            'Kyiv Medical Center',
            'Lviv Clinic',
            'Odesa Hospital',
            'Dnipro Health Institute',
            'Kharkiv Central Hospital'
        ];

        return [
            'name'                 => $this->faker->name,
            'email'                => $this->faker->unique()->safeEmail,
            'workplace'            => $this->faker->randomElement($workplaces),
            'specialty'            => $this->faker->randomElement($specialties),
            'additional_information' => $this->faker->optional()->paragraph,
            // Так как выводим список врачей, явно задаём роль "Doctor"
            'email_verified_at'    => now(),
            'password'             => bcrypt('password'), // стандартный пароль для теста
            'remember_token'       => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
