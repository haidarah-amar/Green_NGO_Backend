<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
public function definition(): array
{
    return [
        'user_id' => \App\Models\User::factory()->employee(),
        'position' => fake()->randomElement([
            'system_admin',
            'project_manager',
            'program_manager',
            'field_coordinator',
            'finance_officer',
            'mel_officer',
        ]),
    ];
}
}
