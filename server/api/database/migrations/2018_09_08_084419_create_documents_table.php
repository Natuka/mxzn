<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100)->default('')->comment('文件名称');
            $table->string('path')->default('')->comment('文件路径');
            $table->tinyInteger('type')->default(1)->comment('文件类型，1图片，2');
            $table->string('ext', 20)->default('jpg')->comment('文件扩展名');
            $table->bigInteger('size')->comment('档案大小，Byte');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
}
