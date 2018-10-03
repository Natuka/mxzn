<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBaseDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     * Table:
     * 部门
     * @return void
     */
    public function up()
    {
        Schema::create('base_departments', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('org_id')->nullable()->comment('组织/公司id');
            $table->integer('parent_id')->nullable()->comment('parent id');
            $table->string('number',20)->nullable()->comment('编号');
            $table->string('name',20)->nullable()->comment('部门名称');
            $table->string('sort_no',10)->nullable()->comment('排序');
            $table->string('created_by',20)->nullable()->comment('创建人员');
            $table->string('updated_by',20)->nullable()->comment('修改人员');
            $table->softDeletes();
            $table->timestamps();
            //隶属公司，上级部门，部门编号，部门名称，排序，备注，状态
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('base_departments');
    }
}
