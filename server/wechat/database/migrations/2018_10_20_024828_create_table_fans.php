<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userable_id')->nullable(false)->default(0)->comment('客户类型');
            $table->string('userable_type', 50)->default('App\\Models\\Engineer')->comment('用户模型类别');
            $table->string('openid', 64)->nullable(false)->comment('OPENID');
            $table->string('password', 100)->nullable(true)->comment('password');
            $table->string('unionid', 64)->nullable(false)->comment('UNIONID');
            $table->string('nickname', 30)->nullable(true)->comment('昵称');
            $table->string('display_name', 30)->nullable(true)->comment('真实姓名');
            // 手机号需要在关注的时候才显示出来
            $table->string('mobile', 11)->unique()->nullable(true)->comment('手机号');
//            $table->string('password', 100)->unique()->nullable(true)->comment('密码');
            $table->string('remark', 255)->nullable(true)->comment('备注');
            $table->string('language', 30)->nullable(true)->comment('语言');
            $table->string('province', 30)->nullable(true)->comment('省');
            $table->string('city', 30)->nullable(true)->comment('市');
            $table->string('country', 30)->nullable(true)->comment('区');
            $table->string('headimage', 30)->nullable(true)->comment('头像');
            $table->tinyInteger('sex')->length(1)->default(1)->comment('性别');
            $table->tinyInteger('is_subscribe')->length(1)->default(0)->comment('是否关注， 1关注，0未关注');
            $table->string('remember_token', 100)->nullable();
            $table->timestamp('subscribed_time')->nullable()->comment('关注时间');
            $table->timestamp('unsubscribed_time')->nullable()->comment('取消关注时间');
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
        Schema::dropIfExists('fans');
    }
}
