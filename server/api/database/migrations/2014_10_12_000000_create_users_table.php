<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('name')->length(16);
            $table->string('email')->length(50)->unique();
            $table->string('password')->length(100);
            $table->char('code')->length(10)->index('code');
            $table->bigInteger('mobile')->length(11)->index();
            $table->bigInteger('qq')->length(14);
            $table->string('wechat')->length(30);
            $table->tinyInteger('valid')->length(1)->default(0)->comment('审核，0未审核，1审核');
            $table->rememberToken();
            $table->timestamps();
            // 新增软删除
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
