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
        Schema::table('cg_studies', function (Blueprint $table) {
            $table->json('approvals')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('cg_studies', function (Blueprint $table) {
            $table->dropColumn('approvals');
        });
    }
};
