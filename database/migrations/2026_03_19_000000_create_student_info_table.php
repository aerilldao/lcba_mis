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
        if (!Schema::hasTable('student_info')) {
            Schema::create('student_info', function (Blueprint $table) {
                $table->id();
                $table->string('id_number', 50)->unique()->index();
                $table->string('last_name', 100)->nullable();
                $table->string('first_name', 100)->nullable();
                $table->string('middle_name', 100)->nullable();
                $table->date('date_of_birth')->nullable();
                $table->string('sex', 20)->nullable();
                $table->integer('age')->nullable();
                $table->string('father_name', 150)->nullable();
                $table->string('mother_name', 150)->nullable();
                $table->string('guardian_name', 150)->nullable();
                $table->string('guardian_contact', 50)->nullable();
                $table->text('address')->nullable();
                
                // Educational details
                $table->string('grade_level', 50)->nullable();
                $table->string('course', 150)->nullable();
                $table->string('major', 150)->nullable();
                $table->string('strand', 150)->nullable();
                $table->string('section', 50)->nullable();
                
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_info');
    }
};
