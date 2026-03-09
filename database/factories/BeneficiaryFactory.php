<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Beneficiary>
 */
class BeneficiaryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
   public function definition(): array
{
    $birthDate = fake()->dateTimeBetween('-60 years', '-18 years');
    $age = \Carbon\Carbon::parse($birthDate)->age;

    return [
        'user_id' => \App\Models\User::factory()->beneficiary(),
        'gender' => fake()->randomElement(['male', 'female']),
        'date_of_birth' => $birthDate,
        'national_id' => fake()->unique()->numerify('##########'),
        'age' => $age,
        'region' => fake()->randomElement([
    'دمشق',
    'ريف دمشق',
    'حلب',
    'حمص',
    'حماة',
    'اللاذقية',
    'طرطوس',
    'درعا',
    'السويداء',
    'القنيطرة',
    'دير الزور',
    'الرقة',
    'الحسكة',
    'إدلب'
]),
        'address' => fake()->randomElement([
    'شارع الثورة',
    'حي الميدان',
    'حي الزهراء',
    'شارع بغداد',
    'حي الحمدانية',
    'حي المزة',
    'حي الشهباء'
]),
        'marital_status' => fake()->randomElement([
            'single',
            'married',
            'divorced',
            'widowed',
        ]),
        'family_size' => fake()->numberBetween(1, 8),
        'education_level' => fake()->randomElement([
            'none',
            'primary',
            'secondary',
            'university',
            'higher',
        ]),
        'income_before' => fake()->randomFloat(2, 0, 500),
        'income_after' => fake()->randomFloat(2, 0, 1200),
        'employment_status' => fake()->randomElement([
            'employed',
            'unemployed',
        ]),
    ];
}
}
