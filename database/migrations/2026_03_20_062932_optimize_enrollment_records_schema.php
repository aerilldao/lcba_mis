<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('enrollment_records', function (Blueprint $table) {
            $table->dropColumn(['last_name', 'first_name', 'middle_name']);
        });
    }

    public function down(): void
    {
        Schema::table('enrollment_records', function (Blueprint $table) {
            $table->string('last_name', 80)->after('student_id_no')->nullable();
            $table->string('first_name', 80)->after('last_name')->nullable();
            $table->string('middle_name', 80)->after('first_name')->nullable();
        });
    }
};
