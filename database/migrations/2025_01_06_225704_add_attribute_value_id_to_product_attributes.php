<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('product_attributes', function (Blueprint $table) {
            // Add the 'attribute_value_id' column
            $table->unsignedBigInteger('attribute_value_id')->nullable();

            // Add the foreign key constraint
            $table->foreign('attribute_value_id')
                ->references('id')
                ->on('attribute_values')
                ->onDelete('cascade');  // This will delete product attributes if the related attribute value is deleted
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('product_attributes', function (Blueprint $table) {
            $table->dropForeign(['attribute_value_id']);  // Drop the foreign key
            $table->dropColumn('attribute_value_id');  // Drop the column
        });
    }
};
