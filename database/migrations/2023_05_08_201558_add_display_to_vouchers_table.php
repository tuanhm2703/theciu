<?php

use App\Enums\DisplayType;
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
        Schema::table('vouchers', function (Blueprint $table) {
            $table->enum('display', [DisplayType::PUBLIC, DisplayType::PRIVATE, DisplayType::SYSTEM])->default(DisplayType::PUBLIC)->comment('Voucher is public or private');
            $table->integer('total_can_use')->comment('Total number of voucher that customer can use on all voucher that released');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vouchers', function (Blueprint $table) {
            //
        });
    }
};
