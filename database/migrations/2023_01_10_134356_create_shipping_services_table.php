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
        Schema::create('shipping_services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('name');
            $table->text('alias');
            $table->text('token');
            $table->text('logo_address');
            $table->boolean('active')->default(1);
            $table->text('domain');
            $table->boolean('default')->default(0)->nullable();
            $table->mediumText('description')->default('')->nullable();
            $table->text('ip_address');
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
        Schema::dropIfExists('shipping_services');
    }
};
