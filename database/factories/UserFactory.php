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
    return [
        'first_name' => fake()->randomElement([
    'أحمد','محمد','عمر','خالد','يوسف','عبدالله',
    'سارة','نور','لينا','آية','مريم','رنا'
]),
        'last_name' => fake()->randomElement([
    'الحسن','العلي','الحموي','الدمشقي','الخطيب',
    'النجار','الزعبي','الرفاعي','السلوم','المحمود'
]),
        'email' => fake()->unique()->safeEmail(),
        'email_verified_at' => now(),
        'password' => 'password',
        'phone' => fake()->numerify('09########'),
        'role' => 'beneficiary',
        'status' => fake()->randomElement(['active', 'inactive']),
        'last_login_at' => fake()->optional()->dateTime(),
        'remember_token' => Str::random(10),
    ];
}

public function employee(): static
{
    return $this->state(fn (array $attributes) => [
        'role' => 'employee',
    ]);
}

public function donor(): static
{
    return $this->state(fn (array $attributes) => [
        'role' => 'donor',
    ]);
}

public function beneficiary(): static
{
    return $this->state(fn (array $attributes) => [
        'role' => 'beneficiary',
    ]);
}

public function trainer(): static
{
    return $this->state(fn (array $attributes) => [
        'role' => 'trainer',
    ]);
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
