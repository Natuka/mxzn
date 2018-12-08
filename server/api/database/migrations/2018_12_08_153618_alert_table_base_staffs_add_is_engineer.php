<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlertTableBaseStaffsAddIsEngineer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('base_staffs', function (Blueprint $table) {
            //
            $table->tinyInteger('is_engineer')->length(1)->default(0)->comment('是否工程师0否,1是')->after('job');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('base_staffs', function (Blueprint $table) {
            //
        });
    }
}
