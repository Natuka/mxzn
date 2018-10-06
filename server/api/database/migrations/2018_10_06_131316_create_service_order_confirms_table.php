<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceOrderConfirmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_order_confirms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('service_order_id')->nullable()->comment('order id');



            $table->string('created_by',20)->nullable()->comment('建档人员');
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
        Schema::dropIfExists('service_order_confirms');
    }
}
