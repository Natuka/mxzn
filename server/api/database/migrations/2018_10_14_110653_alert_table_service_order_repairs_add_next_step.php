<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlertTableServiceOrderRepairsAddNextStep extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_order_repairs', function (Blueprint $table) {
            //
            $table->integer('next_step')->nullable()->comment('下一步处理: 完工关闭 1，暂不关闭 2，内部派工 3，派给网点 4')->after('cause_doc_ids');
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
