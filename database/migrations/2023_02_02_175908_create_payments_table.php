<?php

use App\Enums\PaymentStatus;
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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->float('amount', 20);
            $table->enum('payment_status', [PaymentStatus::PAID, PaymentStatus::PENDING, PaymentStatus::REFUND, PaymentStatus::FAILED]);
            $table->string('trans_id')->nullable()->comment('Transaction ID that response from payment method that apply for order');
            $table->string('order_number')->nullable();
            $table->json('data')->nullable();
            $table->string('note')->nullable();
            $table->bigInteger('payment_method_id')->unsigned();
            $table->bigInteger('order_id')->unsigned();
            $table->bigInteger('customer_id')->unsigned();
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('payment_method_id')->references('id')->on('payment_methods');
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
        Schema::dropIfExists('payments');
    }
};
