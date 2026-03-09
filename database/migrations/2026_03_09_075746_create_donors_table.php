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
        Schema::create('donors', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            $table->id();
            $table->enum('donor_type' , ['un_agency','government','private_sector','international_organization','ingo']);
            $table->string('country');
            $table->string('contact_person');
            $table->string('contact_email');
            $table->string('contact_phone');
            $table->double('total_grants_usd')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donors');
    }
};
