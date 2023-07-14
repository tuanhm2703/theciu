<?php

use App\Enums\DisplayType;
use App\Enums\StatusType;
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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('customer_id')->unsigned();
            $table->bigInteger('order_id')->unsigned();
            $table->integer('product_score');
            $table->enum('display', [DisplayType::PUBLIC, DisplayType::PRIVATE]);
            $table->integer('customer_service_score');
            $table->integer('shipping_service_score');
            $table->mediumText('color');
            $table->mediumText('reality');
            $table->mediumText('material');
            $table->mediumText('details');
            $table->mediumText('reply');
            $table->tinyInteger('status')->default(StatusType::ACTIVE);
            $table->bigInteger('reply_by')->unsigned()->nullable();
            $table->integer('likes')->default(0)->unsigned();
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('order_id')->references('id')->on('orders');
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
        Schema::dropIfExists('reviews');
    }
};
