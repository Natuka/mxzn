<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no', 10)->index()->default('')->comment('订单编号');
            // 工单类别
            $table->integer('service_type')->index()->default(0)->comment('服务类别');
            $table->integer('service_from')->index()->default(0)->comment('服务来源');
            $table->timestamp('received_at')->index()->comment('反馈时间');
            $table->string('created_by', 30)->comment('受理人');
            $table->integer('created_admin_id', 30)->comment('受理人ID');
            $table->integer('customer_id')->index()->comment('客户ID');
            $table->string('customer_name', 100)->index()->comment('客户名称');
            $table->string('customer_tel', 20)->index()->comment('客户电话');
            $table->string('customer_addr')->index()->comment('客户联系地址');
            $table->integer('service_level')->default(0)->comment('服务级别');
            $table->integer('staff_id')->default(0)->index()->comment('值班工程师');
            
            $table->integer('service_out')->default(0)->comment('是否上门服务');
            $table->timestamp('service_out_at')->comment('预计上门时间');
            $table->timestamp('service_plane_at')->comment('预计完成时间');
            $table->tinyInteger('is_service_fee')->default(0)->comment('是否有服务收费');
            $table->tinyInteger('is_quote')->default(0)->comment('是否报价');
            $table->integer('attach_id')->default(0)->comment('附件');
            $table->integer('machine_id')->default(0)->comment('机器ID');
            $table->string('machine_no', 64)->default('')->comment('机器编号/序列号');
            $table->timestamp('setup_at')->comment('安装日期');
            $table->timestamp('warranty_at')->comment('安装日期');

            $table->string('remark')->default('')->comment('备注');

            $table->tinyInteger('order_status')->default(1)->comment('单据状态 已受理|待派单|处理中|已取消|已关闭|无法处理');
            $table->tinyInteger('repair_status')->default(0)->comment('维修结果, 0 维修中 1 已完成');
            
            $table->tinyInteger('settle_status')->default(0)->comment('结算 未结算|结算中|已结算|免费');
            
            $table->timestamp('staff_received_at')->index()->comment('响应时间, 值班工程师 确认');
            $table->timestamp('repair_received_at')->index()->comment('维修工程师 确认');

            // $table->string('machine_no', 64)->default('')->comment('保修日期');

            // $table->string('customer_contact', 100)->index()->comment('客户ID');
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
        Schema::dropIfExists('orders');
    }
}
