<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SuccessStory;

class SuccessStorySeeder extends Seeder
{
    public function run(): void
    {
        SuccessStory::factory()
            ->count(20)
            ->create();
    }
}