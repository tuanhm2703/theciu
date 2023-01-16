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
        Schema::create('shipping_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('order_id')->unsigned();
            $table->bigInteger('shipping_service_id')->unsigned();
            $table->timestamp('estimated_pick_time')->nullable();
            $table->timestamp('estimated_delivery_time')->nullable();
            $table->string('to_address');
            $table->string('status_text')->nullable();
            $table->string("code")->nullable();
            $table->bigInteger('pickup_address_id')->unsigned();
            $table->string('shipping_service_code')->comment('shipping service type for shipping service (fast, standard, etc,...)');
            $table->double("order_value")->comment('total valuation of the order')->nullable();
            $table->double("cod_amount")->comment('cash on delivery')->nullable();
            $table->double("service_fee")->comment("service cost depend on third operation")->nullable();
            $table->double("insurance_fee")->comment("calculate from order value")->nullable();
            $table->double("total_fee")->comment("total of cod_amount, insurant_fee, service_fee")->nullable();
            $table->boolean('ship_at_office_hour')->default(0);
            $table->integer('pickup_shift_id')->nullable()->comment("1: Today Morning - 2: Today afternoon - 3: Tomorrow morning - 4: Tomorrow afternoon - 5: The morning of the day after");
            $table->foreign('pickup_address_id')->on('addresses')->references('id');
            $table->foreign('order_id')->references("id")->on('orders');
            $table->foreign('shipping_service_id')->references("id")->on('shipping_services');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('shipping_orders');
    }
};
