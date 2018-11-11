<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableServiceOrderDocumentsAddColumnType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_order_documents', function (Blueprint $table) {
            //
            $table->tinyInteger('type')->length(1)->default(0)->comment('0报价, 1处理措施,2故障原因,3')->after('document_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_order_documents', function (Blueprint $table) {
            //
            $table->dropColumn('type');
        });
    }
}
