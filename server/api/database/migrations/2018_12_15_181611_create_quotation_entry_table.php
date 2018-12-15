<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotationEntryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotation_entry', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->nullable()->comment('父表id');
            $table->integer('item_id')->nullable()->comment('物料id');
            $table->string('number',20)->nullable()->comment('物料编号');
            $table->string('name',30)->nullable()->comment('物料名称');
            $table->string('model',200)->nullable()->comment('规格型号');
            $table->char('unit',4)->nullable()->comment('单位');
            $table->integer('quantity')->nullable()->comment('数量');
            $table->float('price',8,2)->nullable()->comment('单价');
            $table->float('amount',8,2)->nullable()->comment('金额');
            $table->float('discount',4,3)->nullable()->comment('折扣');
            $table->float('discount_amount',8,2)->nullable()->comment('折扣后金额');
            $table->integer('tax_rate')->comment('税率: 16% 16，10% 10，6% 6，不含税 0');
            $table->date('delivery_date')->nullable()->comment('交货日期');
            $table->string('remark',200)->nullable()->comment('备注');
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
        Schema::dropIfExists('quotation_entry');
    }
}
