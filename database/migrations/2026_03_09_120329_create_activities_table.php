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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->enum('type', ['workshop','meeting','training','support_session','field_activity']);
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
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedBigInteger('planned_attendees');
            $table->unsignedBigInteger('actual_attendees')->default(0);
            $table->unsignedBigInteger('duration_hours');
            $table->double('planned_budget_usd', 15, 2);
            $table->double('actual_budget_usd', 15, 2)->default(0);
            $table->foreignId('responsible_mel_officer_id')->constrained('employees')->cascadeOnDelete();
            $table->foreignId('program_id')->constrained('programs')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
