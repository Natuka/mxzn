<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlertTableCustomerEquipmentsAddDfrom extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_equipments', function (Blueprint $table) {
            $table->tinyInteger('dfrom')->length(1)->default(0)->comment('0客户设备, 1其它设备')->after('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_equipments', function (Blueprint $table) {
            //
        });
    }
}
