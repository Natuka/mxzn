<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceOrderEngineersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_order_engineers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('service_order_id')->nullable()->comment('工单id');
            $table->tinyInteger('type')->default(0)->comment('派工类型: 内部派工 0, 网点派工 1');
            $table->tinyInteger('is_change')->default(0)->comment('是否被转派: 否 0, 是 1');
            $table->integer('staff_id')->nullable()->comment('工程师id');
            $table->string('staff_name',20)->nullable()->comment('工程师名字');
            $table->string('created_by',20)->nullable()->comment('派单人员');
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
        Schema::dropIfExists('service_order_engineers');
    }
}
