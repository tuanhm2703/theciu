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
        Schema::create('order_combo', function (Blueprint $table) {
            $table->bigInteger('order_id')->unsigned();
            $table->bigInteger('combo_id')->unsigned();
            $table->integer('number_of_combos')->comment('number of combo that was bought');
            $table->double('total_discount', 20);
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('combo_id')->references('id')->on('combos');
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
        Schema::dropIfExists('order_combo');
    }
};
