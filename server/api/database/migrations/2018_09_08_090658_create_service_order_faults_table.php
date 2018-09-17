<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceOrderFaultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_order_faults', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('service_order_id')->nullable()->comment('工单id');
            $table->integer('equipment_id')->nullable()->comment('设备id');
            $table->tinyInteger('type')->default(0)->comment('故障类型: 软件故障 1,硬件故障 2，软硬件故障 3，待定 4');
            $table->tinyInteger('sequence')->default(1)->comment('故障频率: 偶尔发生 1,经常出现 2,一直出现 3');
            $table->string('code',50)->nullable()->comment('故障代码');
            $table->tinyInteger('is_line_broken')->default(2)->comment('线路是否破损: 否 0，是 1, 待定 2');
            $table->tinyInteger('is_part_broken')->default(2)->comment('部品是否损坏: 否 0，是 1, 待定 2');
            $table->string('desc',255)->nullable()->comment('故障描述');
            $table->string('fault_doc_ids',50)->nullable()->comment('故障附件');
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
        Schema::dropIfExists('service_order_faults');
    }
}
