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
        Schema::create('kiot_customers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kiot_customer_id');
            $table->bigInteger('customer_id')->unsigned()->nullable();
            $table->string('code');
            $table->double('total_point')->nullable();
            $table->double('reward_point')->nullable();
            $table->foreign('customer_id')->references('id')->on('customers');
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
        Schema::dropIfExists('kiot_customers');
    }
};
