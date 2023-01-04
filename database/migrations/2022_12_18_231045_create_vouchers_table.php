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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('discount_type');
            $table->string('code')->unique();
            $table->boolean('status')->default(1);
            $table->bigInteger('voucher_type_id')->unsigned();
            $table->foreign('voucher_type_id')->references('id')->on('voucher_types');
            $table->float('value')->comment('discount_value');
            $table->float('min_order_value')->comment('Minimum value of order to apply the voucher');
            $table->integer('customer_limit')->comment('Maximum times of a customer to use the voucher');
            $table->integer('quantity');
            $table->float('max_discount_amount')->comment('Max discount amount for voucher');
            $table->dateTime('begin');
            $table->dateTime('end');
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
        Schema::dropIfExists('vouchers');
    }
};
