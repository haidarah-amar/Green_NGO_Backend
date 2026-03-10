<?php

namespace Database\Factories;

use App\Models\Activity;
use App\Models\Beneficial;
use App\Models\Beneficiary;
use App\Models\Program;
use App\Models\Survey;
use Illuminate\Database\Eloquent\Factories\Factory;

class SurveyFactory extends Factory
{
    protected $model = Survey::class;

    public function definition(): array
    {
        $type = fake()->randomElement(['in', 'out']);

        return [
            'title' => fake()->randomElement([
                'استبيان تقييم التدريب',
                'استبيان رضا المستفيدين',
                'استبيان تقييم النشاط',
                'استبيان تقييم البرنامج',
                'استبيان المتابعة النهائية',
                'استبيان الأثر والاستفادة',
            ]),

            'date' => fake()->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),

            'type' => $type,

            'general_rating' => (string) fake()->numberBetween(1, 5),
            'traing_rating' => (string) fake()->numberBetween(1, 5),
            'content_rating' => (string) fake()->numberBetween(1, 5),

            'top_benefits' => fake()->optional(0.8)->randomElement([
                'اكتساب مهارات جديدة وتحسين الثقة بالنفس.',
                'تحسن القدرة على التواصل والعمل ضمن فريق.',
                'الاستفادة من محتوى عملي قابل للتطبيق.',
                'التعرف على فرص جديدة للتدريب والعمل.',
                'تحسن المعرفة العامة بالموضوع المطروح.',
            ]),

            'improvement_suggestions' => fake()->optional(0.7)->randomElement([
                'زيادة مدة الجلسات العملية.',
                'توفير مواد تدريبية إضافية.',
                'تنظيم الأنشطة في مواعيد أكثر ملاءمة.',
                'زيادة عدد الورش التطبيقية.',
                'تخصيص وقت أكبر للأسئلة والنقاش.',
            ]),

            'beneficiary_id' => Beneficiary::inRandomOrder()->value('id')
                ?? Beneficiary::factory()->create()->id,

            'activity_id' => fake()->boolean(70)
                ? (Activity::inRandomOrder()->value('id') ?? Activity::factory()->create()->id)
                : null,

            'program_id' => fake()->boolean(80)
                ? (Program::inRandomOrder()->value('id') ?? Program::factory()->create()->id)
                : null,
        ];
    }
}