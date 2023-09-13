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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cartId');
            $table->string('productId')->nullable();
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->decimal('weight', 10, 2);
            $table->string('label');
            $table->timestamps();

            // Foreign key constraint for cartId
            //$table->foreign('cartId')->references('id')->on('carts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart_items');
    }
};
