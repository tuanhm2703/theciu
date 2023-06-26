<?php

use App\Enums\DisplayType;
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
            $table->bigInteger('customer_id');
            $table->bigInteger('inventory_id');
            $table->integer('product_score');
            $table->enum('display', [DisplayType::PUBLIC, DisplayType::PRIVATE]);
            $table->integer('customer_service_score');
            $table->integer('shipping_service_score');
            $table->mediumText('color');
            $table->mediumText('reality');
            $table->mediumText('material');
            $table->mediumText('details');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('inventory_id')->references('id')->on('inventories');
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
