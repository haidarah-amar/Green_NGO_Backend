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
        Schema::create('grants', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique();
            $table->string('name');
            $table->unsignedBigInteger('total_amount_usd');
            $table->unsignedBigInteger('received_amount_usd');
            $table->unsignedBigInteger('spent_amount_usd');
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['active','expired','draft','approved','suspended','cancelled'])->default('draft');
            $table->foreignId('donor_id')->constrained('donors')->cascadeOnDelete();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grants');
    }
};
