<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlertTableUsersAddUserable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // 超级管理员标识
            $table->tinyInteger('is_super')->length(1)->default(0)->notnull()->comment('超级管理员')->after('valid');
            $table->integer('userable_id')->default(0)->notnull()->comment('多态类型ID')->after('is_super');
            $table->string('userable_type', 100)->notnull()->default('')->comment('多态类型表名')->after('userable_id');
            $table->index(['userable_id', 'userable_type'], 'userable_id_type_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_super');
            $table->dropColumn('userable_id');
            $table->dropColumn('userable_type');
            $table->dropIndex('userable_id_type_index');
        });
    }
}
