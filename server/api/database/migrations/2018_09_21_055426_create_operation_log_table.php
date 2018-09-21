<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperationLogTable extends Migration
{
    /**
     * Run the migrations.
     * Table
     * 操作日志
     * @return void
     */
    public function up()
    {
        Schema::create('operation_log', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('module_id')->nullable()->commnet('模块id: 服务工单 1，其他 2');
            $table->string('events',200)->nullable()->comment('操作事件');
            $table->string('operator',10)->nullable()->comment('操作人员');
            $table->datetime('operation_time')->nullable()->comment('操作时间');
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
        Schema::dropIfExists('operation_log');
    }
}
