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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->text('description');
            $table->text('reason_to_sell');
            $table->decimal('price', 10, 2);
            $table->decimal('sale_price', 10,2)->nullable();
            $table->integer('stock_quanity')->default(0);
            $table->string('slug')->unique();
            $table->string('sku')->unique();
            $table->enum('product_type', ['new', 'used', 'complete_pc', 'laptop']);
            $table->enum('status', ['pending', 'approved', 'rejected', 'sold out'])->default('pending');
            $table->foreignId('category_id')->constrained()->onDelete('cascade')->nullable();
            $table->foreignId('brand_id')->constrained()->onDelete('cascade')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // linked to the seller
            $table->string('warranty')->nullable();
            $table->string('condition')->nullable();
            $table->string('year_of_make')->nullable();
            $table->timestamps();
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
