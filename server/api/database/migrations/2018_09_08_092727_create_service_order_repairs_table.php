<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceOrderRepairsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_order_repairs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('service_order_id')->comment('工单id');
            $table->integer('staff_id')->nullable()->comment('工程师id');
            $table->string('staff_name',10)->nullable()->comment('工程师');
            $table->integer('process_id')->nullable()->comment('处理进度: 故障检测中 1，配件维修中 2，等待配件更换 3，测试观察中 4，已处理完成 5，不能处理 6，其他 7');
            $table->string('process')->nullable()->comment('处理进度');
            $table->string('step_result',255)->nullable()->comment('处理措施,结果');
            $table->string('step_doc_ids',50)->nullable()->comment('处理措施,结果附件ids');
            $table->datetime('arrived_at')->nullable()->comment('到达时间');
            $table->datetime('complete_at')->nullable()->comment('完成时间');
            $table->integer('cause_id')->nullable()->comment('故障原因id');
            $table->string('cause',255)->nullable()->comment('故障原因');
            $table->string('cause_doc_ids',50)->nullable()->comment('故障原因附件ids');
            $table->string('created_by',20)->nullable()->comment('建立人员');
            $table->string('updated_by',20)->nullable()->comment('修改人员');
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
        Schema::dropIfExists('service_order_repairs');
    }
}
