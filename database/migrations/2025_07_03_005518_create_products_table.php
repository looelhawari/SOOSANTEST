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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->string('model_name')->nullable();
            $table->foreignId('category_id')->constrained('product_categories');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->nullable();

            // Specifications - SI Units (admin enters these)
            $table->decimal('body_weight', 8, 2)->nullable(); // kg
            $table->decimal('operating_weight', 8, 2)->nullable(); // kg
            $table->decimal('overall_length', 8, 2)->nullable(); // mm
            $table->decimal('overall_width', 8, 2)->nullable(); // mm
            $table->decimal('overall_height', 8, 2)->nullable(); // mm
            $table->string('required_oil_flow')->nullable(); // l/min (can be range like "20 ~ 40")
            $table->string('operating_pressure')->nullable(); // kgf/cm² (can be range like "90 ~ 120")
            $table->string('impact_rate_std')->nullable(); // BPM (can be range like "700 ~ 1,200")
            $table->string('impact_rate_soft_rock')->nullable(); // BPM (can be "~" or range)
            $table->string('hose_diameter')->nullable(); // in (can be "3/8, 1/2")
            $table->decimal('rod_diameter', 8, 2)->nullable(); // mm
            $table->string('applicable_carrier')->nullable(); // ton (can be range like "1.2 ~ 3")

            // Metadata
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->timestamps();

            $table->index('name');
            
            $table->index('model_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
