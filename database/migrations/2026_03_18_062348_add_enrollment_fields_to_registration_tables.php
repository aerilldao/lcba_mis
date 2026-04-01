<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('basic_education', function (Blueprint $table) {
            $table->boolean('is_balik_aral')->default(false);
            $table->boolean('is_senior_high')->default(false);
            $table->boolean('is_freshman')->default(false);
            $table->boolean('is_transferee')->default(false);

            $table->string('grade_level', 50)->nullable();
            $table->string('school_year', 30)->nullable();
            $table->string('section', 50)->nullable();
            $table->string('lrn', 30)->nullable();
            $table->string('ecs', 30)->nullable();
            $table->string('last_school_name', 120)->nullable();
            $table->string('last_school_year', 30)->nullable();
            $table->string('school_id', 30)->nullable();
            $table->string('strand', 50)->nullable();
            $table->string('semester', 30)->nullable();

            $table->json('credentials')->nullable();
        });

        Schema::table('cg_studies', function (Blueprint $table) {
            $table->boolean('is_freshman')->default(false);
            $table->boolean('is_transferee')->default(false);
            $table->boolean('is_cross_enrollee')->default(false);
            $table->boolean('is_returnee')->default(false);

            $table->string('course')->nullable();
            $table->string('major')->nullable();
            $table->string('year_level', 30)->nullable();
            $table->string('school_year', 30)->nullable();
            $table->string('section', 50)->nullable();
            $table->string('semester', 30)->nullable();

            $table->json('credentials')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('basic_education', function (Blueprint $table) {
            $table->dropColumn([
                'is_balik_aral', 'is_senior_high', 'is_freshman', 'is_transferee',
                'grade_level', 'school_year', 'section', 'lrn', 'ecs',
                'last_school_name', 'last_school_year', 'school_id', 'strand', 'semester', 'credentials',
            ]);
        });
        Schema::table('cg_studies', function (Blueprint $table) {
            $table->dropColumn([
                'is_freshman', 'is_transferee', 'is_cross_enrollee', 'is_returnee',
                'course', 'major', 'year_level', 'school_year', 'section', 'semester', 'credentials',
            ]);
        });
    }
};
