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
        Schema::create('shipping_order_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('shipping_order_id')->unsigned();
            $table->string('status')->nullable();
            $table->string('status_code')->nullable();
            $table->integer('order_status_id');
            $table->timestamp('time');
            $table->string('reason')->nullable();
            $table->double('fee');
            $table->double('cod_amount');
            $table->foreign('shipping_order_id')->references('id')->on('shipping_orders');
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
        Schema::dropIfExists('shipping_order_histories');
    }
};
