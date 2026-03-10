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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
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
            $table->double('total_budget_usd');
            $table->enum('status', ['active','expired','draft','approved','suspended','cancelled'])->default('draft');
            $table->date('start_date');
            $table->date('end_date');
            $table->foreignId('project_manager_id')->constrained('employees')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
