<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceOrderFollowupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_order_followups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('service_order_id')->nullable()->comment('order id');
            $table->integer('followup_staff_id')->nullable()->comment('催单人员id');
            $table->string('followup_staff_name',20)->nullable()->comment('催单人员');
            $table->string('mobile',20)->nullable()->comment('手机');
            $table->integer('handle_staff_id')->nullable()->comment('受理人员id');
            $table->string('handle_staff_name',20)->nullable()->comment('受理人员');
            $table->string('handle_result',20)->nullable()->comment('处理结果');
            $table->string('remark',200)->nullable()->comment('备注');
            $table->string('created_by',20)->nullable()->comment('建档人员');
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
        Schema::dropIfExists('service_order_followups');
    }
}
