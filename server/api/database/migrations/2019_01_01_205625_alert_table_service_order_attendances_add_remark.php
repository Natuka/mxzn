<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlertTableServiceOrderAttendancesAddRemark extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_order_attendances', function (Blueprint $table) {
            $table->dropColumn('remark'); //删除表的字段
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_order_attendances', function (Blueprint $table) {
            //
        });
    }
}
