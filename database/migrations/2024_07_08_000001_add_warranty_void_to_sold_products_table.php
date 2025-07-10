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
        Schema::table('sold_products', function (Blueprint $table) {
            $table->boolean('warranty_voided')->default(false);
            $table->text('warranty_void_reason')->nullable();
            $table->unsignedBigInteger('warranty_voided_by')->nullable();
            $table->timestamp('warranty_voided_at')->nullable();
            $table->foreign('warranty_voided_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sold_products', function (Blueprint $table) {
            $table->dropForeign(['warranty_voided_by']);
            $table->dropColumn([
                'warranty_voided',
                'warranty_void_reason',
                'warranty_voided_by',
                'warranty_voided_at',
            ]);
        });
    }
};
