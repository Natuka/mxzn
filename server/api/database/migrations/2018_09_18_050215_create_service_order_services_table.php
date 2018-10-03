<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceOrderServicesTable extends Migration
{
    /**
     * Run the migrations.
     * Table
     * 工单服务项目
     * @return void
     */
    public function up()
    {
        Schema::create('service_order_services', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('service_order_id')->nullable()->comment('工单id');
            $table->integer('service_id')->nullable()->comment('服务项目id');
            $table->string('name',30)->comment('服务名称');
            $table->string('content',50)->nullable()->comment('服务内容');
            $table->string('workday',10)->nullable()->comment('服务时间');
            $table->string('area')->nullable()->comment('地区');
            $table->float('price',8,2)->nullable()->comment('单价');
            $table->char('unit',4)->nullable()->comment('单位');
            $table->integer('quantity')->nullable()->comment('数量');
            $table->float('amount',8,2)->nullable()->comment('金额');
            $table->float('reward',8,2)->nullable()->comment('提成');
            $table->string('land_traffic')->nullable()->comment('是否含陆路交通费');
            $table->string('hotel')->nullable()->comment('是否含住宿');
            $table->tinyInteger('settlement_method')->nullable()->comment('结算方式: 客付 1，厂付 2，免费 0');
            $table->float('working_hours',5,1)->nullable()->comment('工时');
            $table->tinyInteger('is_complete')->nullable()->comment('是否完工: 否 0，是 1');
            $table->integer('staff_id')->nullable()->comment('服务工程师id');
            $table->string('staff',20)->nullable()->comment('服务工程师');
            $table->string('remark',200)->nullable()->comment('备注');
            $table->string('created_by',20)->nullable()->comment('创建人员');
            $table->string('updated_by',20)->nullable()->comment('修改人员');
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
        Schema::dropIfExists('service_order_services');
    }
}
