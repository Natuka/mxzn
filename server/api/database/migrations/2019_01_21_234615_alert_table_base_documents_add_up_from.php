<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlertTableBaseDocumentsAddUpFrom extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('base_documents', function (Blueprint $table) {
            $table->string('thumbnail_name',120)->nullable()->comment('缩略图名称')->after('size');
            $table->tinyInteger('up_from')->nullable()->comment('上传自1后台,0微信')->after('thumbnail_name');
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
