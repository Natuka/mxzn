<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBaseCodesTable extends Migration
{
    /**
     * Run the migrations.
     * Table
     * 设备二维码，唯一编号，系列号对应表
     * @return void
     */
    public function up()
    {
        Schema::create('base_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('item_id')->nullable()->comment('物料id');
            $table->string('number',30)->comment('编号');
            $table->string('name',30)->nullable()->comment('物料名称');
            $table->string('model',200)->nullable()->comment('规格型号');
            $table->date('manufacture_date')->nullable()->comment('制造日期');
            $table->date('purchase_date')->nullable()->comment('采购日期');
            $table->string('qr_code',255)->nullable()->comment('二维码');
            $table->string('serial_number',30)->nullable()->comment('系列号');
            $table->string('remark',200)->nullable()->comment('备注');
            $table->string('created_by',20)->nullable()->comment('建立人员');
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
        Schema::dropIfExists('base_codes');
    }
}
