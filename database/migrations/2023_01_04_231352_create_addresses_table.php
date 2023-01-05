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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('addressable_type');
            $table->bigInteger('addressable_id')->unsigned();
            $table->string('type');
            $table->string('details');
            $table->bigInteger('province_id');
            $table->bigInteger('distict_id');
            $table->bigInteger('ward_id');
            $table->string('full_address');
            $table->string('fullname');
            $table->string('phone');
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
        Schema::dropIfExists('addresses');
    }
};
