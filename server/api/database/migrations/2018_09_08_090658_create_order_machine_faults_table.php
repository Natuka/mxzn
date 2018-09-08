<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderMachineFaultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_machine_faults', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->index()->default(0)->comment('订单ID');
            $table->integer('machine_id')->index()->default(0)->comment('设备ID');
            $table->integer('type')->index()->default(0)->comment('故障类型');
            $table->tinyInteger('sequence')->default(0)->comment('故障类型');
            $table->string('code', 40)->default('')->comment('故障代码');
            $table->string('line_broken', 40)->default('')->comment('线路是否破损');
            $table->string('part_broken', 40)->default('')->comment('部品是否损坏');
            $table->string('desc', 500)->default('')->comment('故障描述');
            $table->string('image_id', 40)->default('')->comment('故障照片');
            $table->string('attach_id', 40)->default('')->comment('故障附件资料');
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
        Schema::dropIfExists('order_machine_faults');
    }
}
