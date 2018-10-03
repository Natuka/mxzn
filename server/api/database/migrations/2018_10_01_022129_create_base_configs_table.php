<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBaseConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('base_configs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->default(0)->commnet('parent id');
            $table->string('number',20)->nullable()->comment('no');
            $table->string('name',50)->nullable()->comment('名字');
            $table->string('sort',10)->nullable()->comment('排序');
            $table->tinyInteger('status')->default(1)->comment('状态: 0 禁用,1 使用');
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
        Schema::dropIfExists('base_configs');
    }
}
