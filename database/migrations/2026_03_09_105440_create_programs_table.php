<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->enum('type', ['economic_empowerment','vocational_training','psychosocial_support','agricultural_development','community_leadership','entrepreneurship']);
            $table->unsignedTinyInteger('target_age_min');
            $table->unsignedTinyInteger('target_age_max');
            $table->enum('target_gender', ['male', 'female', 'all']);
            $table->enum('location', [
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
            ]);
            $table->double('total_budget_usd', 15, 2);
            $table->double('spent_budget_usd', 15, 2)->default(0);
            $table->enum('status', ['active','expired','draft','approved','suspended','cancelled'])->default('draft');
            $table->date('start_date');
            $table->date('end_date');
            $table->foreignId('program_manager_id')->constrained('employees')->cascadeOnDelete();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
