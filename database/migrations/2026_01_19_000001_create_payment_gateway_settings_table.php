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
        Schema::create('payment_gateway_settings', function (Blueprint $table) {
            $table->id();
            $table->string('gateway_name')->unique(); // stripe, sslcommerz, bkash
            $table->boolean('is_enabled')->default(false);
            $table->text('api_key')->nullable();
            $table->text('api_secret')->nullable();
            $table->text('store_id')->nullable(); // For SSLCommerz
            $table->text('store_password')->nullable(); // For SSLCommerz
            $table->text('app_key')->nullable(); // For Bkash
            $table->text('app_secret')->nullable(); // For Bkash
            $table->text('username')->nullable(); // For Bkash
            $table->text('password')->nullable(); // For Bkash
            $table->boolean('sandbox_mode')->default(true);
            $table->text('webhook_secret')->nullable();
            $table->json('additional_settings')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_gateway_settings');
    }
};
