<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableFansAddColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fans', function (Blueprint $table) {
            //
            $table->tinyInteger('is_check')->length(1)->default(0)->comment('是否审核');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fans', function (Blueprint $table) {
            if (Schema::hasColumn('fans', 'is_check')) {
                $table->dropColumn('is_check');
            }
        });
    }
}
