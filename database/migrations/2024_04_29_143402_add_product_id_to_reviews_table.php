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
        Schema::table('reviews', function (Blueprint $table) {
            $table->bigInteger('product_id')->unsigned()->nullable();
            $table->bigInteger('order_id')->nullable()->unsigned()->change();
            $table->bigInteger('customer_id')->nullable()->unsigned()->change();
            $table->string('buyer_username')->nullable();
            $table->bigInteger('shopee_comment_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn('product_id');
            $table->dropColumn('buyer_username');
        });
    }
};
