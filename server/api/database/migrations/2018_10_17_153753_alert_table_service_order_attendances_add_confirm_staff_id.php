<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlertTableServiceOrderAttendancesAddConfirmStaffId extends Migration
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
            $table->integer('confirm_user_id')->nullable()->comment('确认者id')->after('coordinate');
            $table->string('confirm_user_name',10)->nullable()->comment('确认者名字')->after('confirm_user_id');
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
