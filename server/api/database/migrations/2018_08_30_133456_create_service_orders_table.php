<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceOrdersTable extends Migration
{
    /**
     * Run the migrations.
     * Table
     * 服务工单
     * @return void
     */
    public function up()
    {
        Schema::create('service_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number', 10)->index()->comment('工单编号,R1809-0001,R+年份2码+月份2码+流水码4码');
            // 工单类别
            $table->tinyInteger('type')->default(1)->comment('服务类别: 安装工单 1,保养工单 2,维修工单 3,投诉工单 4,巡检工单 5,移机调试 6，工艺调试 7，试焊申请 8，设备整改 9，培训工单 10');
            $table->tinyInteger('source')->default(0)->comment('服务来源: 公司计划安排 1,PC WEB 2,微信 3, 400客服电话 4，其他 5');
            $table->integer('customer_id')->nullable()->comment('客户id');
            $table->tinyInteger('emergency_degree')->default(3)->comment('紧急程度: 非常紧急 1,紧急 2，一般 3');
            $table->tinyInteger('level')->default(3)->comment('服务级别,A级 1，B级 2，C级 3，D级 4');
            $table->datetime('feedback_at')->nullable()->comment('报修反馈时间');
            $table->integer('feedback_staff_id')->nullable()->comment('报修反馈人员id,关联客户联系人员id');
            $table->datetime('receive_at')->nullable()->comment('受理时间');
            $table->integer('receive_staff_id')->nullable()->comment('受理人id');
            $table->timestamp('confirm_at')->nullable()->comment('工单确认时间');
            $table->integer('confirm_staff_id')->nullable()->comment('工单确认人员id');
            $table->string('engineer_ids',50)->nullable()->comment('维修工程师ids');
            $table->tinyInteger('is_out')->default(2)->comment('是否上门服务: 否 0，是 1, 待定 2');
            $table->datetime('plan_out_at')->nullable()->comment('预计上门时间');
            $table->datetime('plan_finish_at')->nullable()->comment('预计完成时间');
            $table->tinyInteger('is_charge')->default(2)->comment('是否服务收费: 否 0，是 1, 待定 2');
            $table->tinyInteger('is_quote')->default(2)->comment('是否报价: 否 0，是 1, 待定 2');
            $table->string('attach_ids',50)->nullable()->comment('附件ids');
            $table->string('remark')->nullable()->comment('备注');
            $table->tinyInteger('settle_status')->default(0)->comment('结算: 未结算 0, 结算中 1, 已结算 2, 免费 3');
            $table->tinyInteger('status')->default(0)->comment('单据状态: 制单中 0, 已受理 1,待派单 2,处理中 3,已取消 4,已关闭 5,无法处理 6');
            $table->string('created_by',10)->nullable()->comment('创建人员');
            $table->string('updated_by',10)->nullable()->comment('修改人员');
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
        Schema::dropIfExists('service_orders');
    }
}
