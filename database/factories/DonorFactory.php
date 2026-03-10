<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Donor>
 */
class DonorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
public function definition(): array
{
    return [
        'user_id' => \App\Models\User::factory()->donor(),
        'donor_type' => fake()->randomElement([
            'un_agency',
            'government',
            'private_sector',
            'international_organization',
            'ingo',
        ]),
        'country' => fake()->country(),
        'contact_person' => fake()->name(),
        'contact_email' => fake()->safeEmail(),
        'contact_phone' => fake()->phoneNumber(),
        'image_url' => $this->faker->imageUrl(640, 480, 'people'),
        'total_grants_usd' => fake()->randomFloat(2, 1000, 500000),
    ];
}
}
