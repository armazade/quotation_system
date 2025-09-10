<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_delivery_options', function (Blueprint $table) {
            $table->id();
            $table->uuid('product_id');
            $table->string('processing_term_type');
            $table->integer('days');
            $table->timestamps();

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_delivery_options');
    }
};
