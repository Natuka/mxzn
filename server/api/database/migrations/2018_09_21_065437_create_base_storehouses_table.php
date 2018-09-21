<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBaseStorehousesTable extends Migration
{
    /**
     * Run the migrations.
     * Table
     * 仓库
     * @return void
     */
    public function up()
    {
        Schema::create('base_storehouses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number',10)->nullable()->comment('编号');
            $table->string('name',30)->nullable()->comment('名称');
            $table->tinyInteger('is_negative')->default(0)->commnet('是否允许负库存: 不允许 0,允许 1');
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
        Schema::dropIfExists('base_storehouses');
    }
}
