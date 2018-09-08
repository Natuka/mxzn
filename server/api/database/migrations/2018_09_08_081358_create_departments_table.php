<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dependce_id')->default(0)->index()->comment('所属公司');
            $table->integer('parentid')->default(0)->index()->comment('上级部门');
            $table->string('no', 20)->default('')->index()->comment('部门编号');
            $table->string('name', 30)->default('')->index()->comment('部门名称');
            $table->integer('sort')->default(10)->index()->comment('部门排序');
            $table->string('remark')->default('')->comment('部门备注');
            $table->tinyInteger('disabled')->length(1)->default(0)->comment('是否禁用');

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
        Schema::dropIfExists('departments');
    }
}
