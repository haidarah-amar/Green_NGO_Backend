<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('grant_project', function (Blueprint $table) {

            $table->foreignId('grant_id')
                ->after('id')
                ->constrained('grants')
                ->cascadeOnDelete();

            $table->foreignId('project_id')
                ->after('grant_id')
                ->constrained('projects')
                ->cascadeOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('grant_project', function (Blueprint $table) {

            $table->dropForeign(['grant_id']);
            $table->dropForeign(['project_id']);

            $table->dropColumn(['grant_id','project_id']);

        });
    }
};
