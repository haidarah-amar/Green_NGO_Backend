<?php

namespace Database\Factories;

use App\Models\Expense;
use App\Models\Program;
use App\Models\Grant;
use App\Models\Employee;
use App\Models\Expenses;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExpensesFactory extends Factory
{
    protected $model = Expenses::class;

    public function definition(): array
    {
        return [
            'invoice_number' => fake()->unique()->numerify('INV-#####'),

            'title' => fake()->randomElement([
                'Office Supplies Purchase',
                'Monthly Staff Salaries',
                'Transportation Costs',
                'Training Materials',
                'Equipment Purchase',
                'Administrative Expenses',
                'Consulting Services',
            ]),

            'description' => fake()->sentence(10),

            'category' => fake()->randomElement([
                'salaries_wages',
                'supplies_materials',
                'equipment',
                'administrative_expenses',
                'transportation',
                'hospitality',
                'services'
            ]),

            'amount_usd' => fake()->numberBetween(100, 10000),

            'date' => fake()->dateTimeBetween('-1 year', 'now'),

            'payment_method' => fake()->randomElement([
                'bank_transfer',
                'cash',
                'check',
                'bank_card',
                'e-wallet'
            ]),

            'program_id' => Program::inRandomOrder()->value('id')
                ?? Program::factory(),

            'grant_id' => Grant::inRandomOrder()->value('id')
                ?? Grant::factory(),

            'employee_id' => Employee::where('position', 'finance_officer')
                ->inRandomOrder()
                ->value('id'),

        ];
    }
}