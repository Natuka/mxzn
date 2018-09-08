<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('areas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->index()->default(0)->comment('');
            $table->string('areaname', 32)->index()->comment('地区名称');
            $table->string('shortname', 32)->index()->comment('简称');
            $table->string('areacode', 32)->index()->comment('代号');
            $table->string('zipcode', 32)->index()->comment('邮政编号');
            $table->string('pinyin', 32)->index()->comment('拼音');
            $table->string('lng', 20)->index()->comment('拼音');
            $table->string('lat', 20)->index()->comment('拼音');
            $table->integer('level')->comment('拼音');
            $table->string('position', 100)->comment('位置');
            $table->tinyInteger('sort')->comment('排序');
           
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
        Schema::dropIfExists('areas');
    }
}
