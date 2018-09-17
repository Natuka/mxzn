<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBaseServicesTable extends Migration
{
    /**
     * Run the migrations.
     * Table:
     * 服务收费标准
     * @return void
     */
    public function up()
    {
        Schema::create('base_services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number',10)->nullable()->comment('编号');
            $table->string('name',10)->comment('服务名称');
            $table->string('content',10)->nullable()->comment('服务内容');
            $table->string('workday',10)->nullable()->comment('服务时间');
            $table->tinyInteger('area')->default(1)->comment('地区: 省内 1，省外 2，公司内 3，客户现场 4');
            $table->float('price',8,1)->nullable()->comment('单价');
            $table->char('unit',4)->nullable()->comment('单位');
            $table->tinyInteger('is_land_traffic')->nullable()->comment('是否含陆路交通费: 否 0,是 1');
            $table->tinyInteger('is_hotel')->nullable()->comment('是否含住宿: 否 0,是 1');
            $table->date('effective_date')->nullable()->comment('有效日期');
            $table->date('expiration_date')->nullable()->comment('失效日期');
            $table->string('created_by',20)->nullable()->comment('建立人员');
            $table->string('updated_by',20)->nullable()->comment('修改人员');
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
        Schema::dropIfExists('base_services');
    }
}
