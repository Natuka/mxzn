<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableCustomerEquipmentsAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_equipments', function (Blueprint $table) {
            //
            $table->string('main_model',100)->nullable()->comment('本体型号')->after('main_no');
            $table->string('control_box_model',100)->nullable()->comment('控制箱型号')->after('control_box_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_equipments', function (Blueprint $table) {
            //
            $table->dropColumn('main_model');
            $table->dropColumn('control_box_model');
        });
    }
}
