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
        Schema::create('customer_vouchers', function (Blueprint $table) {
            $table->bigInteger('customer_id')->unsigned();
            $table->bigInteger('voucher_id')->unsigned();
            $table->string('type');
            $table->boolean('is_used')->default(0);
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('voucher_id')->references('id')->on('vouchers');
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
        Schema::dropIfExists('customer_vouchers');
    }
};
