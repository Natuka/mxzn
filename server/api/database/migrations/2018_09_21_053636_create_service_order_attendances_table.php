<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceOrderAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     * Table
     * 工程师签到记录
     * @return void
     */
    public function up()
    {
        Schema::create('service_order_attendances', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('staff_id')->nullable()->comment('工程师id');
            $table->string('staff_name',10)->nullable()->comment('工程师名字');
            $table->datetime('signin_time')->nullable()->comment('打卡时间');
            $table->string('location',200)->nullable()->comment('位置');
            $table->string('coordinate',200)->nullable()->comment('坐标');
            $table->softDeletes();
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
        Schema::dropIfExists('service_order_attendances');
    }
}
