<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_attribute', function (Blueprint $table) {
            $table->integer('product_id')->unsigned()->index();
            // $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->integer('attribute_id')->unsigned()->index();
            // $table->foreign('attribute_id')->references('id')->on('attributes')->onDelete('cascade');
            $table->primary(['product_id', 'attribute_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_attribute');
    }
};
