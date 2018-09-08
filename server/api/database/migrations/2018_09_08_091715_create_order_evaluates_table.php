<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderEvaluatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_evaluates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->default(0)->index()->comment();
            $table->integer('resolved')->default(0)->comment('是否解决, 1是');
            $table->integer('all')->default(0)->comment('整体满意度');
            $table->integer('response')->default(0)->comment('服务及时性');
            $table->integer('engineer')->default(0)->comment('服务人员满意度');
            $table->string('feedback')->comment('建议与意见');
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
        Schema::dropIfExists('order_evaluates');
    }
}
