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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('suggestedQuantity')->nullable();
            $table->boolean('action')->default(false);
            $table->float('charge')->default(0.00);
            $table->string('code');
            $table->decimal('weight', 10, 2);
            $table->decimal('unitFactor', 10, 2)->nullable();
            $table->string('productName');
            $table->boolean('kit')->default(false);
            $table->string('material');
            $table->boolean('polarized')->default(false);
            $table->decimal('unitPrice', 10, 2);
            $table->string('priceTable');
            $table->string('orderType')->nullable();
            $table->string('segment')->nullable();
            $table->string('brand')->nullable();
            $table->string('category')->nullable();
            $table->string('packagingType')->nullable();
            $table->string('groupKonnect')->nullable();
            $table->string('deliveryType')->nullable();
            $table->string('flavor')->nullable();
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
};
