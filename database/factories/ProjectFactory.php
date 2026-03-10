<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Employee;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */


public function definition(): array
{
    $start = fake()->dateTimeBetween('-1 year', '+3 months');
    $end = fake()->dateTimeBetween($start, '+2 years');

    return [

        'name' => fake()->randomElement([
            'مشروع دعم سبل العيش',
            'مشروع تمكين المرأة',
            'مشروع التدريب المهني للشباب',
            'برنامج دعم التعليم',
            'مشروع التعافي المبكر',
            'مشروع الأمن الغذائي',
            'برنامج بناء القدرات المجتمعية',
            'مشروع دعم المشاريع الصغيرة',
        ]),

        'description' => fake()->randomElement([
            'يهدف المشروع إلى تحسين الظروف المعيشية للأسر المتضررة من خلال برامج دعم اقتصادي مستدام.',
            'برنامج تدريبي يستهدف الشباب لتطوير مهاراتهم المهنية وزيادة فرص العمل.',
            'يسعى المشروع إلى تمكين المرأة اقتصاديًا عبر التدريب والدعم المالي للمشاريع الصغيرة.',
            'يقدم المشروع دعمًا تعليميًا للأطفال في المناطق المتضررة.',
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
            'إدلب'
        ]),

        'total_budget_usd' => fake()->numberBetween(20000, 500000),

        'status' => fake()->randomElement([
            'active',
            'expired',
            'draft',
            'approved',
            'suspended',
            'cancelled'
        ]),

        'start_date' => $start,

        'end_date' => $end,

        'project_manager_id' => Employee::projectManagers()
    ->inRandomOrder()
    ->first()?->id,
    ];
}
}
