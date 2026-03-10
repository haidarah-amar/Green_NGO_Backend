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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->string('title');
            $table->text('description');
            $table->enum('category', ['salaries_wages','supplies_materials','equipment','administrative_expenses','transportation','hospitality','services']);
            $table->unsignedBigInteger('amount_usd');
            $table->date('date');
            $table->enum('payment_method', ['bank_transfer','cash','check','bank_card','e-wallet']);
            $table->foreignId('program_id')->constrained('programs')->cascadeOnDelete();
            $table->foreignId('grant_id')->constrained('grants')->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
