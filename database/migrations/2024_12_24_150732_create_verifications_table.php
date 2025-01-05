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
        Schema::create('verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');
            $table->text('cnic_front_picture');
            $table->text('cnic_back_picture');
            $table->text('cnic_holding_selfie')->nullable();
            $table->string('shop_name')->nullable();
            $table->text('shop_picture')->nullable();
            $table->text('shop_business_card_picture')->nullable();
            $table->string('shop_address')->nullable();
            $table->text('rep_post_link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verifications');
    }
};
