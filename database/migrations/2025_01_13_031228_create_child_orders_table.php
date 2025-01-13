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
        Schema::create('child_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders'); // Foreign key to main order
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('seller_id')->constrained('users'); // Seller (vendor) ID
            $table->integer('quantity')->default(1);
            $table->string('payment_screenshot')->nullable(); // Payment screenshot (if applicable)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('child_orders');
    }
};
