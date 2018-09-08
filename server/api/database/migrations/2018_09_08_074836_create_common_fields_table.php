<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommonFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('common_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parentid')->default(0)->index();
            $table->string('name', 30)->default('')->index()->comment('名称');
            $table->string('field', 30)->default('')->index()->comment('字段名称');
            $table->string('value', 255)->default('')->comment('值');
            $table->integer('sort')->default(10)->comment('排序');
            $table->tinyInteger('disabled')->length(1)->default(0)->comment('是否禁用');
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
        Schema::dropIfExists('common_fields');
    }
}
