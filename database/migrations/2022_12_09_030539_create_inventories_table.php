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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id');
            $table->integer('stock_quantity');
            $table->string('sku')->nullable();
            $table->float('price');
            $table->float('promotion_price')->nullable();
            $table->text('promotion_type')->nullable();
            $table->timestamp('promotion_from')->nullable();
            $table->timestamp('promotion_to')->nullable();
            $table->boolean('promotion_status')->default(1);
            $table->softDeletes();
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
        Schema::dropIfExists('inventories');
    }
};
