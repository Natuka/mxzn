<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceOrderConfirmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_order_confirms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('service_order_id')->nullable()->comment('order id');
            $table->tinyInteger('is_solve')->nullable()->comment('是否解决: 1是,0否');
            $table->tinyInteger('overall_satisfaction')->nullable()->comment('整体满意度,5星,10分制');
            $table->tinyInteger('timeliness')->nullable()->comment('服务及时性,5星,10分制');
            $table->tinyInteger('service_staff_atisfaction')->nullable()->comment('服务人员满意度,5星,10分制');
            $table->tinyInteger('cost_performance')->nullable()->comment('性价比满意度,5星,10分制');
            $table->integer('confirm_user_id')->nullable()->comment('确认用户id');
            $table->string('confirm_user_name',20)->nullable()->comment('确认用户名字');
            $table->string('opinions_suggestions',250)->nullable()->comment('意见与建议');
            $table->string('created_by',20)->nullable()->comment('建档人员');
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
        Schema::dropIfExists('service_order_confirms');
    }
}
