<?php

namespace Database\Factories;

use App\Models\Activity;
use App\Models\Employee;
use App\Models\Program;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityFactory extends Factory
{
    protected $model = Activity::class;

    public function definition(): array
    {
        $start = fake()->dateTimeBetween('-8 months', '+2 months');
        $end = (clone $start)->modify('+' . fake()->numberBetween(1, 10) . ' days');

        $plannedAttendees = fake()->numberBetween(10, 120);
        $actualAttendees = fake()->numberBetween(0, $plannedAttendees);

        $plannedBudget = fake()->randomFloat(2, 500, 15000);
        $actualBudget = fake()->randomFloat(2, 0, $plannedBudget);

        return [
            'name' => fake()->randomElement([
                'ورشة تدريب مهني',
                'جلسة دعم نفسي جماعي',
                'اجتماع تنسيقي مع المجتمع المحلي',
                'نشاط ميداني للتوعية',
                'تدريب على ريادة الأعمال',
                'ورشة تمكين اقتصادي',
                'لقاء متابعة مع المستفيدين',
                'جلسة دعم مجتمعي',
            ]),

            'description' => fake()->randomElement([
                'يهدف النشاط إلى تطوير مهارات المشاركين وتعزيز مشاركتهم في البرامج المجتمعية.',
                'نشاط مخصص لدعم المستفيدين وتحسين قدراتهم عبر جلسات تفاعلية عملية.',
                'يأتي هذا النشاط ضمن خطة البرنامج لتحسين الوصول إلى الفئات المستهدفة في المجتمع.',
                'يتضمن النشاط جلسات توعية وتدريب ومتابعة ميدانية للفئات المستفيدة.',
            ]),

            'type' => fake()->randomElement([
                'workshop',
                'meeting',
                'training',
                'support_session',
                'field_activity',
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

            'start_date' => $start->format('Y-m-d'),
            'end_date' => $end->format('Y-m-d'),

            'planned_attendees' => $plannedAttendees,
            'actual_attendees' => $actualAttendees,

            'duration_hours' => fake()->numberBetween(1, 40),

            'planned_budget_usd' => $plannedBudget,
            'actual_budget_usd' => $actualBudget,

            'responsible_mel_officer_id' => Employee::where('position', 'mel_officer')
                ->inRandomOrder()
                ->value('id')
                ?? Employee::factory()->create([
                    'position' => 'mel_officer',
                ])->id,

            'program_id' => Program::inRandomOrder()->value('id')
                ?? Program::factory()->create()->id,
        ];
    }
}