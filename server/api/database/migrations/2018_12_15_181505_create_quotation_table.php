<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotation', function (Blueprint $table) {
            $table->increments('id');
            $table->string('billno',20)->nullable()->comment('报价编号,Q1809-0001,Q+年份2码+月份2码+流水码4码');
            $table->integer('service_order_id')->nullable()->comment('工单id');
            $table->integer('customer_id')->nullable()->comment('客户id');
            $table->integer('customer_contact_id')->nullable()->comment('联系人id');
            $table->integer('pay')->nullable()->comment('付款方式: 款到发货 1，货到付款 2，月结 3，其他 0');
            $table->integer('carriage')->nullable()->comment('运费支付： 寄付 1，到付 2，其他 0');
            $table->date('effective_date')->nullable()->comment('生效日期');
            $table->date('expiration_date')->nullable()->comment('失效日期');
            $table->date('delivery_date')->nullable()->comment('交货日期');
            $table->string('remark',200)->nullable()->comment('备注');
            $table->string('created_by',20)->nullable()->comment('创建人员');
            $table->string('updated_by',20)->nullable()->comment('修改人员');
            $table->string('checked_by',20)->nullable()->comment('审核人员');
            $table->datetime('checked_date')->nullable()->comment('审核日期');
            $table->tinyInteger('status')->default(0)->comment('单据状态: 制单中 0, 已审核 1');
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
        Schema::dropIfExists('quotation');
    }
}
