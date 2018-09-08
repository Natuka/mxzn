<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email', 120)->unique();
            $table->string('password');
            $table->tinyInteger('sex')->length(1)->default(1)->comment('1男，2女');
            $table->string('mobile', 11)->default('')->comment('手机号')->index();
            $table->tinyInteger('disabled')->length(1)->default(0)->comment('是否禁用');
            $table->timestamp('last_login_at')->comment('最后登录时间');
            $table->string('last_login_ip')->comment('最后登录IP');
            $table->string('remark')->comment('备注');
            $table->string('created_by')->comment('创建人');
            $table->string('updated_by')->comment('修改人');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
