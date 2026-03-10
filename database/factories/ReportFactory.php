<?php

namespace Database\Factories;

use App\Models\Report;
use App\Models\Project;
use App\Models\Grant;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReportFactory extends Factory
{
    protected $model = Report::class;

    public function definition(): array
    {
        $periodStart = fake()->dateTimeBetween('-1 year', '-3 months');
        $periodEnd = fake()->dateTimeBetween($periodStart, 'now');

        return [
            'title' => fake()->randomElement([
                'Quarterly Progress Report',
                'Donor Financial Report',
                'Project Implementation Report',
                'Internal Monitoring Report',
                'Final Project Report',
                'Program Performance Report',
            ]),

            'content' => fake()->optional()->paragraphs(3, true),

            'type' => fake()->randomElement([
                'donor',
                'internal',
                'progress',
                'final'
            ]),

            'report_date' => fake()->dateTimeBetween($periodEnd, 'now'),

            'period_start' => $periodStart,
            'period_end' => $periodEnd,

            'file_url' => fake()->url(),

            'status' => fake()->randomElement([
                'active',
                'expired',
                'draft',
                'approved',
                'suspended',
                'cancelled'
            ]),

            'notes' => fake()->optional()->sentence(),

            'project_id' => Project::inRandomOrder()->value('id')
                ?? Project::factory(),

            'grant_id' => Grant::inRandomOrder()->value('id')
                ?? Grant::factory(),

            'employee_id' => Employee::inRandomOrder()->value('id')
                ?? Employee::factory(),
        ];
    }
}