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
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('date');
            $table->enum('type', ['in', 'out'])->default('in');
            $table->enum('general_rating', ['1', '2', '3', '4', '5']);
            $table->enum('traing_rating', ['1', '2', '3', '4', '5']);
            $table->enum('content_rating', ['1', '2', '3', '4', '5']);
            $table->text('top_benefits')->nullable();
            $table->text('improvement_suggestions')->nullable();
            $table->foreignId('beneficiary_id')
                ->constrained('beneficiaries')
                ->onDelete('cascade');
           $table->foreignId('activity_id')
    ->nullable()
    ->constrained('activities')
    ->nullOnDelete();

    $table->foreignId('program_id')
    ->nullable()
    ->constrained('programs')
    ->nullOnDelete();

    $table->timestamps();
});
        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surveys');
    }
};
