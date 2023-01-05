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
            $table->text("name");
            $table->text("slug");
            $table->text("name_with_type");
            $table->text("path");
            $table->text("path_with_type");
            $table->text("code")->nullable();
            $table->bigInteger('parent_id')->unsigned();
            $table->text("type");
            $table->boolean("sttus");
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
