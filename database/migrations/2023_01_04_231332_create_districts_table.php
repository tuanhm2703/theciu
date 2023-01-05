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
        Schema::create('districts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text("name");
            $table->text("slug");
            $table->text("name_with_type");
            $table->text("path");
            $table->text("path_with_type");
            $table->text("code");
            $table->boolean('status');
            $table->bigInteger('parent_id')->unsigned();
            $table->text('type');
            $table->index('code');
            $table->foreign('parent_id')->on('provinces')->references('id');
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
        Schema::dropIfExists('districts');
    }
};
