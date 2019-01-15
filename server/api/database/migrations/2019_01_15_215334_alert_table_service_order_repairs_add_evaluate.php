<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlertTableServiceOrderRepairsAddEvaluate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_order_repairs', function (Blueprint $table) {
            // $table->integer('next_step')->nullable()->comment('下一步处理: 完工关闭 1，暂不关闭 2，内部派工 3，派给网点 4')->after('cause_doc_ids');
            $table->tinyInteger('is_solve')->nullable()->comment('是否解决: 1是,0否')->after('next_step');
            $table->tinyInteger('overall_satisfaction')->nullable()->comment('整体满意度,5星,10分制')->after('is_solve');
            $table->tinyInteger('timeliness')->nullable()->comment('服务及时性,5星,10分制')->after('overall_satisfaction');
            $table->tinyInteger('service_staff_atisfaction')->nullable()->comment('服务人员满意度,5星,10分制')->after('timeliness');
            $table->tinyInteger('cost_performance')->nullable()->comment('性价比满意度,5星,10分制')->after('service_staff_atisfaction');
            $table->integer('confirm_user_id')->nullable()->comment('确认用户id')->after('cost_performance');
            $table->string('confirm_user_name',20)->nullable()->comment('确认用户名字')->after('confirm_user_id');
            $table->string('opinions_suggestions',250)->nullable()->comment('意见与建议')->after('confirm_user_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_order_repairs', function (Blueprint $table) {
            //
        });
    }
}
