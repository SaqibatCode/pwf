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
        Schema::create('home_page_sliders', function (Blueprint $table) {
            $table->id();
            $table->string('sub_heading')->nullable();
            $table->string('heading');
            $table->string('description');
            $table->string('another_heading');
            $table->string('button_text');
            $table->string('button_url');
            $table->text('image_desktop');
            $table->text('image_mobile');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_page_sliders');
    }
};
