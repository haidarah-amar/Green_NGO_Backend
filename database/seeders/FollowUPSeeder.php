<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FollowUP;

class FollowUPSeeder extends Seeder
{
    public function run(): void
    {
        FollowUP::factory()
            ->count(40)
            ->create();
    }
}