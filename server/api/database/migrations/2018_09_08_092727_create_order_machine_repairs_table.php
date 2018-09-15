<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderMachineRepairsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_machine_repairs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->default(0)->index()->comment('工单ID');
            $table->tinyInteger('type')->default(0)->index()->comment('处理方式');
            $table->integer('engineer_id')->index()->default(0)->comment('工程师ID');
            $table->string('engineer')->comment('工程师IDS');
            $table->timestamp('arrived_at')->index()->comment('到达时间');
            $table->timestamp('complete_at')->index()->comment('完成时间');
            $table->integer('fault_id')->default(0)->index()->comment('故障原因');
            $table->integer('process_id')->default(0)->comment('处理进度');
            $table->integer('next_id')->default(0)->index()->comment('下一步处理人');
            $table->integer('attach_id')->default(0)->comment('附件');
            $table->integer('fault_attach_id')->default(0)->comment('原因附件');
            $table->string('remark', 500)->comment('处理结果');
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
        Schema::dropIfExists('order_machine_repairs');
    }
}
