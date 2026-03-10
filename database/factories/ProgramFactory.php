<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Program;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProgramFactory extends Factory
{
    protected $model = Program::class;

    public function definition(): array
    {
        $start = fake()->dateTimeBetween('-1 year', '+3 months');
        $end = fake()->dateTimeBetween($start, '+2 years');

        $budget = fake()->randomFloat(2, 20000, 300000);
        $spent = fake()->randomFloat(2, 0, $budget);

        $minAge = fake()->numberBetween(16, 35);
        $maxAge = min($minAge + fake()->numberBetween(5, 25), 80);

        return [
            'name' => fake()->randomElement([
                'برنامج التمكين الاقتصادي',
                'برنامج التدريب المهني للشباب',
                'برنامج الدعم النفسي المجتمعي',
                'برنامج التنمية الزراعية',
                'برنامج القيادة المجتمعية',
                'برنامج ريادة الأعمال للشباب',
            ]),

            'description' => fake()->randomElement([
                'يهدف البرنامج إلى تعزيز فرص العمل وتحسين سبل العيش للفئات المستهدفة.',
                'برنامج تدريبي لتطوير المهارات المهنية لدى الشباب في المناطق المتضررة.',
                'برنامج يقدم جلسات دعم نفسي واجتماعي للأفراد المتأثرين بالأزمات.',
                'يساهم البرنامج في تطوير القطاع الزراعي وتحسين الإنتاج المحلي.',
                'يعمل البرنامج على تعزيز دور القادة المحليين في خدمة المجتمع.',
            ]),

            'type' => fake()->randomElement([
                'economic_empowerment',
                'vocational_training',
                'psychosocial_support',
                'agricultural_development',
                'community_leadership',
                'entrepreneurship',
            ]),

            'target_age_min' => $minAge,
            'target_age_max' => $maxAge,

            'target_gender' => fake()->randomElement([
                'male',
                'female',
                'all',
            ]),

            'location' => fake()->randomElement([
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
                'إدلب',
            ]),

            'total_budget_usd' => $budget,
            'spent_budget_usd' => $spent,

            'status' => fake()->randomElement([
                'active',
                'expired',
                'draft',
                'approved',
                'suspended',
                'cancelled',
            ]),

            'start_date' => $start->format('Y-m-d'),
            'end_date' => $end->format('Y-m-d'),

            'program_manager_id' => Employee::where('position', 'program_manager')
                ->inRandomOrder()
                ->value('id'),
            'project_id' => \App\Models\Project::inRandomOrder()->value('id')
                ?? \App\Models\Project::factory()->create()->id,
        ];
    }
}