<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerEquipmentsTable extends Migration
{
    /**
     * Run the migrations.
     * Tabel:
     * 客户设备，配件
     * @return void
     */
    public function up()
    {
        Schema::create('customer_equipments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cust_id')->nullable()->comment('客户id');
            $table->integer('item_id')->nullable()->comment('物料id');
            $table->tinyInteger('type')->nullable()->comment('类别: 系统 1，单机 2, 配件 3，损耗件 4，其他 5');
            $table->integer('code_id')->nullable()->comment('code id');
            $table->string('contract_number',20)->nullable()->comment('合同编号');
            $table->string('installation_staff',20)->nullable()->comment('安装人员');
            $table->string('technology_staff',20)->nullable()->comment('技术专管');
            $table->string('contract_number',20)->nullable()->comment('合同编号');
            $table->date('purchase_date')->nullable()->comment('购买日期');
            $table->date('installation_date')->nullable()->comment('安装日期');
            $table->date('acceptance_date')->nullable()->comment('验收日期');
            $table->date('warranty_date')->nullable()->comment('保修日期');
            $table->integer('maintenance_times')->nullable()->comment('维修次数');
            $table->string('remark',200)->nullable()->comment('备注');
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
        Schema::dropIfExists('customer_equipments');
    }
}
