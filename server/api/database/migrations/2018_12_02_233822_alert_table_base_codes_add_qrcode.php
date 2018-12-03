<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlertTableBaseCodesAddQrcode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('base_codes', function (Blueprint $table) {
            $table->string('qrcode_key',64)->nullable()->unique()->comment('二维码唯一值');
            $table->string('qrcode_url',200)->nullable()->comment('二维码网址');
            $table->string('qrcode_img',120)->nullable()->comment('二维码图片路径');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('base_codes', function (Blueprint $table) {
            //
        });
    }
}
