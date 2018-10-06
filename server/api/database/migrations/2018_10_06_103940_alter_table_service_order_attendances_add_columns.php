<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableServiceOrderAttendancesAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_order_attendances', function (Blueprint $table) {
            //
            $table->integer('service_order_id')->nullable()->comment('order id');
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
            $table->dropColumn('service_order_id');
        });
    }
}
