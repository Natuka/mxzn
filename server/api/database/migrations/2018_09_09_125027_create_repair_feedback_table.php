<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepairFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     * 客户PC WEB或者微信端故障报修
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repair_feedback', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('type')->default(0)->index()->comment('微信 0,PC WEB 1');
            $table->integer('customer_id')->default(0)->index()->comment('客户ID');
            $table->string('fault_description',255)->comment('故障描述');
            $table->string('image_id',60)->default('')->comment('故障照片');
            $table->integer('equipment_id')->default(0)->index()->comment('设备ID');
            $table->string('equipment_no',20)->default('')->comment('设备编号');
            $table->string('equipment_name',50)->default('')->comment('设备名称');
            $table->string('equipment_model',200)->default('')->comment('型号配置');
            $table->integer('contacts_id')->default(0)->index()->comment('联系人员ID');
            $table->string('tel',11)->comment('电话');
            $table->string('weixin',20)->comment('微信');
            $table->string('qq',20)->comment('QQ');
            $table->string('email',50)->comment('邮箱');
            $table->integer('feedback_staffid')->default(0)->index()->comment('反馈人员ID');
            $table->timestamps('feedback_date')->index()->comment('反馈日期');
            $table->tinyInteger('type')->default(0)->index()->comment('单据状态: 受理中 0，处理中 1，已处理 2，已关闭 3，已取消 4');
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
        Schema::dropIfExists('repair_feedback');
    }
}
