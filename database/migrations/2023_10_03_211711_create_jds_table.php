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
        Schema::create('jds', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('group');
            $table->string('job_type');
            $table->timestamp('from_date');
            $table->timestamp('to_date');
            $table->boolean('status');
            $table->string('short_description');
            $table->longText('description');
            $table->longText('requirement');
            $table->longText('benefit');
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
        Schema::dropIfExists('jds');
    }
};
