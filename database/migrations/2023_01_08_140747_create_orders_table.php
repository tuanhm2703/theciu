<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('customer_id')->unsigned();
            $table->float('total', 20);
            $table->float('subtotal', 20)->comment('Subtotal after promotion and other discounts');
            $table->float('origin_subtotal', 20)->comment('Total before promotion and other discounts');
            $table->float('shipping_fee', 20)->comment('Shipping fee of the order');
            $table->string('order_number');
            $table->integer('order_status');
            $table->string('cancel_reason');
            $table->integer('canceled_by');
            $table->bigInteger('payment_method_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('orders');
    }
};
