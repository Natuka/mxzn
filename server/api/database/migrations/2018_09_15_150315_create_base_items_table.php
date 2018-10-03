<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBaseItemsTable extends Migration
{
    /**
     * Run the migrations.
     * Table:
     * 物料基础资料
     * @return void
     */
    public function up()
    {
        Schema::create('base_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('erp_itemid')->nullable()->comment('ERP物料ID');
            $table->string('number',20)->nullable()->comment('物料编号');
            $table->string('name',30)->nullable()->comment('物料名称');
            $table->string('model',200)->nullable()->comment('规格型号');
            $table->string('brand',30)->nullable()->comment('品牌');
            $table->char('unit',4)->nullable()->comment('单位');
            $table->float('stock_qty',8,2)->nullable()->comment('库存数量');
            $table->float('safety_stock_qty',8,2)->nullable()->comment('安全库存量');
            $table->string('store',20)->nullable()->comment('默认仓库');
            $table->float('price_ave',8,2)->nullable()->comment('平均采购单价');
            $table->float('price_pur1',8,2)->nullable()->comment('最近采购单价1');
            $table->float('price_pur2',8,2)->nullable()->comment('最近采购单价2');
            $table->float('price_pur3',8,2)->nullable()->comment('最近采购单价3');
            $table->float('price_sale_unified',8,2)->nullable()->comment('统一销售价');
            $table->float('price_sale_least',8,2)->nullable()->comment('最低销售价');
            $table->float('price_sale1',8,2)->nullable()->comment('销售价1');
            $table->float('price_sale2',8,2)->nullable()->comment('销售价2');
            $table->float('price_sale3',8,2)->nullable()->comment('销售价3');
            $table->string('vendor',50)->nullable()->comment('供应商');
            $table->string('remark',200)->nullable()->comment('备注');
            $table->datetime('syn_datetime')->nullable()->comment('同步时间');
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
        Schema::dropIfExists('base_items');
    }
}
