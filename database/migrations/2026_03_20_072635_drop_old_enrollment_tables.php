<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('basic_education');
        Schema::dropIfExists('cg_studies');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No going back after dropping the tables, but we could recreate them empty if needed.
    }
};
