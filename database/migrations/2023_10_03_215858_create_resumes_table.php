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
        Schema::create('resumes', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->string('phone');
            $table->string('email');
            $table->date('birthday')->nullable();
            $table->mediumText('self_introduce');
            $table->mediumText('strength');
            $table->mediumText('question');
            $table->float('expected_salary', 20);
            $table->bigInteger('jd_id')->unsigned();
            $table->foreign('jd_id')->references('id')->on('jds');
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
        Schema::dropIfExists('resumes');
    }
};
