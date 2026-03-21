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
        Schema::create('follow_ups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('beneficiary_id')->constrained('beneficiaries')->cascadeOnDelete();
            $table->foreignId('program_id')->constrained('programs')->cascadeOnDelete();
            $table->foreignId('mel_officer_id')->constrained('employees')->cascadeOnDelete();
            $table->date('follow_up_date');
            $table->enum('type', ['week', 'month', '3 month', '6 month', 'year'])->default('month');
            $table->unsignedBigInteger('income_at_follow_up')->nullable();
            $table->boolean('sustained_improvement');
            $table->enum('employment_status', ['unemployeed','entrepreneur','seeker','part_time','full_time','retired'])->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('follow_ups');
    }
};
