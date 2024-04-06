<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        Schema::create('product_search', function (Blueprint $table) {
            $table->unsignedBigInteger('search_id');
            $table->unsignedBigInteger('product_id');

            $table->foreign('search_id')->references('id')->on('searches');
            $table->foreign('product_id')->references('id')->on('products');

            $table->unique(['search_id', 'product_id']);
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_search');
    }
};
