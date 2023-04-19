<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::table('kiot_customers', function (Blueprint $table) {
            $table->json('data')->nullable();
        });
        DB::statement('ALTER TABLE `kiot_customers`
        MODIFY COLUMN `customer_id` bigint(20) UNSIGNED NULL DEFAULT NULL AFTER `kiot_customer_id`;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kiot_customers', function (Blueprint $table) {
            //
        });
    }
};
