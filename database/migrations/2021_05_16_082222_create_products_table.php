<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string("product_id")->unique();
            $table->string("title");
            $table->string("variant")->nullable();
            $table->string("image")->nullable();
            $table->decimal("rating", 3, 2)->nullable();
            $table->decimal("store_price", 10, 2)->nullable();
            $table->decimal("original_price", 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
