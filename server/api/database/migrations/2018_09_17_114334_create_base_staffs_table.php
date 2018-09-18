<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBaseStaffsTable extends Migration
{
    /**
     * Run the migrations.
     * Table:
     * 员工
     * @return void
     */
    public function up()
    {
        Schema::create('base_staffs', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('org_id')->nullable()->comment('组织id');
            $table->string('number',20)->nullable()->comment('编号');
            $table->string('name',20)->nullable()->comment('姓名');
            $table->tinyInteger('sex')->nullable()->comment('性别, 男 1, 女 0');
            $table->date('birthday')->nullable()->comment('出生日期');
            $table->tinyInteger('dep_id')->nullable()->comment('部门id');
            $table->string('department',20)->nullable()->comment('部门');
            $table->string('post',10)->nullable()->comment('职位');
            $table->string('job',20)->nullable()->comment('职务');
            $table->string('graduated_school',50)->nullable()->comment('毕业院校');
            $table->string('education',10)->nullable()->comment('学历');
            $table->string('skill_expertise',100)->nullable()->comment('技能专长');
            $table->string('hobby',100)->nullable()->comment('兴趣爱好');
            $table->string('mobile',20)->nullable()->comment('手机');
            $table->string('weixin',20)->nullable()->comment('微信');
            $table->string('qq',20)->nullable()->comment('QQ');
            $table->string('email',30)->nullable()->comment('邮箱');
            $table->tinyInteger('status')->default(1)->comment('状态：离职 0，在职 1');
            $table->date('entry_date')->nullable()->comment('入职日期');
            $table->date('leave_date')->nullable()->comment('离职日期');
            $table->integer('province_id')->nullable()->comment('所在省');
            $table->integer('city_id')->nullable()->comment('市');
            $table->integer('district_id')->nullable()->comment('区县');
            $table->string('address',100)->nullable()->comment('详细地址');
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
        Schema::dropIfExists('base_staffs');
    }
}
