<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlertTableServiceOrderAttendancesAddRemark2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_order_attendances', function (Blueprint $table) {
            $table->text('remark')->nullable()->after('confirm_user_name');
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
