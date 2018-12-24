<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceOrderPartsTable extends Migration
{
    /**
     * Run the migrations.
     * Table
     * 配件耗材
     * @return void
     */
    public function up()
    {
        Schema::create('service_order_parts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('service_order_id')->nullable()->comment('工单id');
            $table->integer('base_part_id')->nullable()->comment('配件id');
            $table->integer('base_code_id')->nullable()->comment('code id');
            $table->string('number',20)->nullable()->comment('料号');
            $table->string('name',30)->nullable()->comment('品名');
            $table->string('model',100)->nullable()->comment('规格型号');
            $table->char('unit',4)->nullable()->comment('单位');
            $table->float('quantity',5,2)->default(1)->commnet('数量');
            $table->float('price',8,2)->default(0)->commnet('单价');
            $table->float('amount',8,2)->default(0)->commnet('金额');
            $table->float('discount',4,2)->default(0)->commnet('折扣');
            $table->float('amount_dis',8,2)->default(0)->commnet('折扣后金额');
            $table->integer('tax_rate')->default(6)->comment('税率: 16% 16，10% 10，6% 6，不含税 0');
            $table->tinyInteger('warranty_months')->default(12)->commnet('保修月数');
            $table->date('warranty_date')->nullable()->commnet('保修截至日期');
            $table->string('created_by',20)->nullable()->comment('创建人员');
            $table->string('updated_by',20)->nullable()->comment('修改人员');
            $table->text('remark')->nullable()->comment('备注');
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
        Schema::dropIfExists('service_order_parts');
    }
}
