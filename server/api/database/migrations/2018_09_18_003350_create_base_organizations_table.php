<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBaseOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     * Table:
     * 组织
     * @return void
     */
    public function up()
    {
        Schema::create('base_organizations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number',20)->nullable()->comment('编号');
            $table->string('name',50)->nullable()->comment('名称');
            $table->string('name_short',30)->nullable()->comment('简称');
            $table->tinyInteger('type')->nullable()->comment('类别');
            $table->string('created_by',20)->nullable()->comment('创建人员');
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
        Schema::dropIfExists('base_organizations');
    }
}
