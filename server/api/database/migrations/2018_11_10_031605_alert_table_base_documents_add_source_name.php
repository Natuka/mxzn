<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlertTableBaseDocumentsAddSourceName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('base_documents', function (Blueprint $table) {
            //
            $table->string('source_name', 100)->notnull()->default('')->comment('原始文件名称')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('base_documents', function (Blueprint $table) {
            //
        });
    }
}
