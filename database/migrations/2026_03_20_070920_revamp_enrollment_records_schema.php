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
        Schema::table('enrollment_records', function (Blueprint $table) {
            // Remove redundant columns that are now stored in student_info
            $table->dropColumn(['grade_level', 'strand_course', 'major']);
            
            // Rename enrollment_status to just status for simplicity if desired, 
            // but the user didn't explicitly ask to rename it. 
            // I'll keep it as enrollment_status to avoid breaking current code unnecessarily.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('enrollment_records', function (Blueprint $table) {
            $table->string('grade_level')->nullable();
            $table->string('strand_course')->nullable();
            $table->string('major')->nullable();
        });
    }
};
