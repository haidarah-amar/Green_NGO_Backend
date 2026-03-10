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
        Schema::create('kpi_summaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id')->nullable();
            $table->unsignedBigInteger('program_id')->nullable();
            $table->unsignedBigInteger('activity_id')->nullable();
            $table->unsignedBigInteger('survey_id')->nullable();
            $table->unsignedBigInteger('grant_id')->nullable();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->string('kpi_name');
            $table->enum('kpi_type', ['financial','program','impact','growth']);
            $table->integer('target_value');
            $table->integer('actual_value');
            $table->string('unit');
            $table->enum('status', ['in_progress', 'completed'])->default('in_progress');
            $table->unsignedBigInteger('calculation_period')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kpi_summaries');
    }
};
