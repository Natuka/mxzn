<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBaseStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('base_stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('erp_itemid')->nullable()->comment('ERP物料ID');
            $table->string('number',20)->nullable()->comment('物料编号');
            $table->string('name',30)->nullable()->comment('物料名称');
            $table->string('model',200)->nullable()->comment('规格型号');
            $table->char('unit',4)->nullable()->comment('单位');
            $table->float('quantity',8,2)->nullable()->comment('库存数量');
            $table->string('store',20)->nullable()->comment('仓库');
            $table->datetime('syn_datetime')->nullable()->comment('同步时间');
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
        Schema::dropIfExists('base_stocks');
    }
}
