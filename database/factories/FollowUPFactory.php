<?php

namespace Database\Factories;

use App\Models\FollowUP;
use App\Models\Beneficiary;
use App\Models\Program;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class FollowUPFactory extends Factory
{
    protected $model = FollowUP::class;

    public function definition(): array
    {
        $notes = [
            "المستفيد مستمر في تطوير مشروعه ويحقق تقدماً ملحوظاً.",
            "لوحظ تحسن في الدخل مقارنة بالفترة السابقة.",
            "المستفيد بحاجة إلى دعم إضافي في التسويق.",
            "الوضع مستقر حالياً ولا توجد مشاكل تذكر.",
            "تم تقديم بعض النصائح لتحسين إدارة المشروع.",
            "المستفيد يعمل على توسيع نشاطه التجاري.",
        ];

        return [

            'beneficiary_id' => Beneficiary::inRandomOrder()->value('id'),

            'program_id' => Program::inRandomOrder()->value('id'),

            'mel_officer_id' => Employee::where('position', 'mel_officer')
                ->inRandomOrder()
                ->value('id'),


            'follow_up_date' => $this->faker->date(),

            'type' => $this->faker->randomElement([
                'week',
                'month',
                '3 month',
                '6 month',
                'year'
            ]),

            'income_at_follow_up' => $this->faker->optional()->numberBetween(500, 6000),

            'sustained_improvement' => $this->faker->boolean(),

            'employment_status' => $this->faker->randomElement([
                'unemployeed',
                'entrepreneur',
                'seeker',
                'part_time',
                'full_time',
                'retired'
            ]),

            'notes' => $this->faker->optional()->randomElement($notes),
        ];
    }
}