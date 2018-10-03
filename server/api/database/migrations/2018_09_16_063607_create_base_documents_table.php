<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBaseDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     * Table:
     * 附件表
     * @return void
     */
    public function up()
    {
        Schema::create('base_documents', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('source')->default(1)->comment('文件来源: 故障附件 1, 处理措施结果附件 2，故障原因附件 3, 产品图片 4, 二维码图片 5，其他 6');
            $table->string('name', 100)->default('')->comment('文件名称');
            $table->string('path')->default('')->comment('文件路径');
            $table->tinyInteger('type')->default(1)->comment('文件类型，1图片，2');
            $table->string('ext', 20)->default('jpg')->comment('文件扩展名');
            $table->bigInteger('size')->comment('档案大小，Byte');
            $table->string('created_by',20)->nullable()->comment('建立人员');
            $table->string('updated_by',20)->nullable()->comment('修改人员');
            $table->softDeletes();
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
        Schema::dropIfExists('base_documents');
    }
}
