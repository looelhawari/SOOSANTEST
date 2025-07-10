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
        Schema::create('pending_changes', function (Blueprint $table) {
            $table->id();
            $table->string('model_type'); // e.g., 'App\Models\SoldProduct'
            $table->unsignedBigInteger('model_id'); // The ID of the record being changed
            $table->string('action'); // 'update', 'delete'
            $table->json('original_data'); // Original data before changes
            $table->json('new_data'); // New data being proposed
            $table->foreignId('requested_by')->constrained('users'); // Employee who requested the change
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('reviewed_by')->nullable()->constrained('users'); // Admin who reviewed
            $table->timestamp('reviewed_at')->nullable();
            $table->text('review_notes')->nullable();
            $table->timestamps();

            $table->index(['model_type', 'model_id']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pending_changes');
    }
};
