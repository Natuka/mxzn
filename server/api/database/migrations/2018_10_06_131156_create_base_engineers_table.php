<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBaseEngineersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('base_engineers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable()->comment('登录帐号id');
            $table->integer('org_id')->nullable()->comment('公司组织id');
            $table->integer('staff_id')->nullable()->comment('员工id');
            $table->string('staff_name',20)->nullabel()->comment('姓名');
            $table->tinyInteger('status')->default(1)->comment('状态: 1使用,0禁用');
            $table->string('remark',100)->nullable()->comment('备注');
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
        Schema::dropIfExists('base_engineers');
    }
}
