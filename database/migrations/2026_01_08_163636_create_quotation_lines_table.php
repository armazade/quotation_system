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
        Schema::create('quotation_lines', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->softDeletes();

            $table->foreignUuid('quotation_id')
                ->references('id')
                ->on('quotations')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignUuid('product_id')
                ->nullable()
                ->references('id')
                ->on('products')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->string('description');
            $table->boolean('has_custom_description')->default(false);
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 10, 2);
            $table->string('line_type')->default('product');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotation_lines');
    }
};
