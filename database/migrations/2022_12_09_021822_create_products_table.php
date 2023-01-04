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
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('short_description');
            $table->text('description');
            $table->string('code')->unique();
            $table->text('additional_infomation');
            $table->text('shipping_and_return');
            $table->string('model');
            $table->string('material');
            $table->string('style');
            $table->string('type');
            $table->integer('weight')->nullable();
            $table->integer('height')->nullable();
            $table->integer('length')->nullable();
            $table->integer('width')->nullable();
            $table->boolean('is_reorder')->default(false);
            $table->string('condition')->comment('Condition (New or old)');
            $table->string('sku')->unique()->nullable()->comment('Sku code of product');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
