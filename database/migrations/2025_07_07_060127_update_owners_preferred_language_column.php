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
        Schema::table('owners', function (Blueprint $table) {
            // Change the enum to a varchar with more language options
            $table->string('preferred_language', 5)->default('en')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('owners', function (Blueprint $table) {
            // Revert back to the original enum
            $table->enum('preferred_language', ['en', 'ar'])->default('en')->change();
        });
    }
};
