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
        Schema::create('beneficiaries', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            $table->id();
            $table->enum('gender', ['male', 'female']);
            $table->date('date_of_birth');
            $table->string('national_id')->unique();
            $table->integer('age');
            $table->string('region');
            $table->string('address');
            $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed']);
            $table->integer('family_size')->default(1);
            $table->enum('education_level', ['none', 'primary', 'secondary', 'university' , 'higher'])->default('none');
            $table->double('income_before')->default(0);
            $table->double('income_after')->default(0);
            $table->enum('employment_status', ['employed', 'unemployed'])->default('unemployed');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beneficiaries');
    }
};
