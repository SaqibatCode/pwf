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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('father_name');
            $table->string('email')->unique();
            $table->date('dob');
            $table->string('address');
            $table->string('city');
            $table->string('cnic');
            $table->string('phone')->unique();
            $table->string('password');
            $table->enum('verification', ['Unverified','Pending','Verified','Verified Plus'])->default('Unverified');
            $table->enum('type', ['admin','seller','buyer']);
            $table->string('seller_type')->nullable();
            $table->boolean('terms')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
