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
     $this->call([
        UserSeeder::class,
        EmployeeSeeder::class,
        DonorSeeder::class,
        BeneficiarySeeder::class,
        ProjectSeeder::class,
        ProgramSeeder::class,
        ActivitySeeder::class,
        SurveySeeder::class,
        GrantSeeder::class,
        ExpensesSeeder::class,
        ReportSeeder::class,
        SuccessStorySeeder::class,
        FollowUPSeeder::class,
    ]);
}
}


