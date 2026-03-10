<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Grant;

class GrantSeeder extends Seeder
{
    public function run(): void
    {
        Grant::factory()
            ->count(30)
            ->create();
    }
}