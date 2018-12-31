<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlertTableServiceOrderFaultsAddDateRemark extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_order_faults', function (Blueprint $table) {
            //
            $table->date('installation_date')->nullable()->comment('安装日期')->after('fault_doc_ids');
            $table->date('warranty_date')->nullable()->comment('保修日期')->after('installation_date');
            $table->string('remark',200)->nullable()->comment('备注')->after('warranty_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_order_faults', function (Blueprint $table) {
            //
        });
    }
}
