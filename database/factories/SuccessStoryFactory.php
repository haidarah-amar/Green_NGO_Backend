<?php

namespace Database\Factories;

use App\Models\SuccessStory;
use App\Models\Beneficiary;
use App\Models\Program;
use Illuminate\Database\Eloquent\Factories\Factory;

class SuccessStoryFactory extends Factory
{
    protected $model = SuccessStory::class;

    public function definition(): array
    {
        $before = $this->faker->numberBetween(200, 1000);
        $after = $this->faker->numberBetween(1200, 5000);

        $stories = [
            "كانت حياتي صعبة قبل الانضمام إلى البرنامج، حيث كنت أعاني من قلة الدخل وعدم القدرة على تلبية احتياجات أسرتي. بعد حصولي على التدريب والدعم، تمكنت من بدء مشروع صغير وتحسن دخلي بشكل كبير.",
            "من خلال هذا البرنامج تعلمت مهارات جديدة في إدارة المشاريع الصغيرة، مما ساعدني على زيادة دخلي وتحسين مستوى معيشتي أنا وعائلتي.",
            "قبل المشاركة في البرنامج كنت أعتمد على دخل بسيط وغير ثابت، لكن بعد التدريب والدعم المالي استطعت تطوير عملي وتحقيق استقرار مالي.",
            "ساعدني البرنامج على اكتساب مهارات جديدة وثقة أكبر في نفسي، وأصبحت قادرًا على توفير احتياجات عائلتي بشكل أفضل.",
            "بفضل هذا المشروع تمكنت من بدء نشاطي الخاص، وأصبح لدي مصدر دخل مستقر ساعدني على تحسين حياتي وحياة أسرتي."
        ];

        $titles = [
            "قصة نجاح ملهمة",
            "من التحديات إلى النجاح",
            "رحلة تغيير حقيقية",
            "تحسن كبير في مستوى المعيشة",
            "بداية جديدة نحو الاستقرار"
        ];

        return [
            'title' => $this->faker->randomElement($titles),

            'story_content' => $this->faker->randomElement($stories),

            'income_before' => $before,
            'income_after' => $after,
            'income_improvemnet_pct' => round((($after - $before) / $before) * 100, 2),

            'image_url' => $this->faker->imageUrl(640, 480, 'people'),
            'video_url' => $this->faker->optional()->url(),

            'status' => $this->faker->randomElement([
                'active',
                'expired',
                'draft',
                'approved',
                'suspended',
                'cancelled'
            ]),

            'published_date' => $this->faker->optional()->date(),

            'consent_given' => $this->faker->boolean(80),

            'beneficiary_id' => Beneficiary::inRandomOrder()->value('id'),
            'program_id' => Program::inRandomOrder()->value('id'),
        ];
    }
}