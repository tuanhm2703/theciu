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
        Schema::create('wards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("name");
            $table->string("slug");
            $table->string("name_with_type");
            $table->string("path");
            $table->string("path_with_type");
            $table->string("code")->nullable();
            $table->bigInteger('parent_id')->unsigned();
            $table->string("type");
            $table->integer("support_type")->default(0);
            $table->foreign('parent_id')->on('districts')->references('id');
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
        Schema::dropIfExists('wards');
    }
};
