<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlertTableServiceOrderFollowupsAddFollowupTime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_order_followups', function (Blueprint $table) {
            //
            $table->integer('followup_staff_id')->nullable()->comment('催单人员id')->after('service_order_id');
            $table->datetime('followup_time')->nullable()->comment('催单时间')->after('followup_staff_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_order_followups', function (Blueprint $table) {
            //
        });
    }
}
