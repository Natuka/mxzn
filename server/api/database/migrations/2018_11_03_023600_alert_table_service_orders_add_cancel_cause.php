<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlertTableServiceOrdersAddCancelCause extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_orders', function (Blueprint $table) {
            //增加取消原因栏位
            $table->tinyInteger('cancel_status')->length(1)->default(0)->notnull()->comment('取消状态1')->after('remark');
            $table->string('cancel_type', 60)->notnull()->default('')->comment('取消原因')->after('cancel_status');
            $table->string('cancel_cause', 600)->notnull()->default('')->comment('原因描述')->after('cancel_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_orders', function (Blueprint $table) {
            //
        });
    }
}
