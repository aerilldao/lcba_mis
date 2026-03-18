<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cg_studies', function (Blueprint $table) {
            $table->id();

            // Student
            $table->string('id_no', 50);
            $table->string('last_name', 80)->nullable();
            $table->string('first_name', 80)->nullable();
            $table->string('middle_name', 80)->nullable();
            $table->date('birthdate')->nullable();
            $table->string('sex', 10)->nullable();
            $table->unsignedTinyInteger('age')->nullable();

            // Parents / Guardian
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('guardian_name')->nullable();
            $table->string('guardian_contact', 30)->nullable();

            // Address (single composite)
            $table->string('address')->nullable();

            // Metadata
            $table->foreignId('recorded_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cg_studies');
    }
};
