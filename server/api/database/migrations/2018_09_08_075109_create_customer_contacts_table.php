<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cust_id')->comment('隶属客户');
            $table->string('name',20)->nullable()->comment('姓名');
            $table->tinyInteger('sex')->nullable()->comment('性别, 男 1, 女 0');
            $table->date('birthday')->nullable()->comment('生日');
            $table->tinyInteger('department')->nullable()->comment('部门: 董事长室 10,总经理室 20,管理部 30,行政部 40，财务部 50，采购部 60，生产部 70,品管部 80，资材部 90，审计部 100，成本部 110，其他 0');
            $table->tinyInteger('post')->nullable()->comment('职位: 董事长 10，总经理 20，总裁 21，副总经理 30，副总裁 31，协理 40，经理 50，副经理 60，主任 70，课长 80');
            $table->string('job',50)->nullable()->comment('职务');
            $table->string('mobile',20)->nullable()->comment('手机');
            $table->string('weixin',20)->nullable()->comment('微信');
            $table->string('qq',20)->nullable()->comment('QQ');
            $table->string('email',30)->nullable()->comment('邮箱');
            $table->string('hobby',50)->nullable()->comment('兴趣爱好');
            $table->string('address',100)->nullable()->comment('地址');
            $table->string('remark',200)->nullable()->comment('备注');
            $table->tinyInteger('status')->default(1)->comment('状态：离职 0，在职 1');
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
        Schema::dropIfExists('customer_contacts');
    }
}
