<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\Donor;
use App\Models\Beneficiary;
class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */


public function run(): void
{
    Employee::factory()->count(40)->create();
    Donor::factory()->count(20)->create();
    Beneficiary::factory()->count(2000)->create();
}
}
