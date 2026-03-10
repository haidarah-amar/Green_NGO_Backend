<?php

namespace Database\Factories;

use App\Models\Grant;
use App\Models\Donor;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class GrantFactory extends Factory
{
    protected $model = Grant::class;

    public function definition(): array
    {
        $total = fake()->numberBetween(50000, 500000);
        $received = fake()->numberBetween(10000, $total);
        $spent = fake()->numberBetween(5000, $received);

        return [
            'number' => fake()->unique()->numerify('GR-#####'),

            'name' => fake()->randomElement([
                'Youth Empowerment Grant',
                'Women Development Grant',
                'Climate Action Grant',
                'Education Support Grant',
                'Community Development Grant',
                'Green Energy Grant'
            ]),

            'total_amount_usd' => $total,
            'received_amount_usd' => $received,
            'spent_amount_usd' => $spent,

            'start_date' => fake()->dateTimeBetween('-2 years', '-6 months'),
            'end_date' => fake()->dateTimeBetween('+6 months', '+2 years'),

            'status' => fake()->randomElement([
                'active',
                'expired',
                'draft',
                'approved',
                'suspended',
                'cancelled'
            ]),

            
            'donor_id' => Donor::inRandomOrder()->value('id')
                ?? Donor::factory(),
        ];
    }
}