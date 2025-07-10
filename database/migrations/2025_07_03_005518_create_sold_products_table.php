<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sold_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('owner_id')->constrained('owners');
            $table->foreignId('user_id')->constrained('users'); // Employee who logged the sale
            $table->string('serial_number')->unique();
            $table->date('sale_date');
            $table->date('warranty_start_date');
            $table->date('warranty_end_date');
            $table->decimal('purchase_price', 12, 2)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('serial_number');
            $table->index(['warranty_start_date', 'warranty_end_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sold_products');
    }
};
