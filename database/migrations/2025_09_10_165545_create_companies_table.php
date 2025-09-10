<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('phone_number');
            $table->string('phone_country_code');
            $table->string('company_type');
            $table->string('subscription_type');
            $table->string('industry_type');
            $table->boolean('is_schut')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
