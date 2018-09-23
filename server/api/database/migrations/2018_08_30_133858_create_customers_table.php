<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('erp_cust_id')->nullable()->comment('ERP客户ID');
            $table->string('number',20)->nullable()->comment('公司编号');
            $table->string('name',50)->comment('公司名称');
            $table->string('name_short',20)->nullable()->comment('公司简称');
            $table->tinyInteger('industry')->default(0)->index()->comment('所属行业：汽车配件 1, 机械加工 2, 油漆喷涂 3, 其他 0');
            $table->tinyInteger('type')->default(2)->index()->comment('客户类别: 代理商 1,终端客户 2');
            $table->tinyInteger('level')->default(2)->index()->comment('客户级别: A重要客户 1,B普通客户 2,C低价值客户 3');
            $table->tinyInteger('follow_up_status')->default(0)->index()->comment('跟进状态: 初访 0,意向 1,报价 2, 成交 3, 暂时搁置 4');
            $table->tinyInteger('source')->default(0)->index()->comment('客户来源: 广告 1,社交推广 2,研讨会 3, 搜索引擎 4, 客户介绍 5, 独立开发 6, 代理商 7, 其他 0');
            $table->tinyInteger('staff_scale')->default(0)->comment('人员规模: <10人 1,10-20人 2,20-50人 3, 50-100人 4, 100-500人 5, 500人以上 6, 未知 0 ');
            $table->tinyInteger('purchasing_power')->default(0)->index()->comment('购买力: 强 1，中 2，弱 3，未知 0');
            $table->datetime('follow_up_nexttime')->nullable()->comment('下次跟进时间');
            $table->datetime('contact_lasttime')->nullable()->comment('最近联系时间');
            $table->integer('province_id')->nullable()->comment('所在省');
            $table->integer('city_id')->nullable()->comment('市');
            $table->integer('district_county_id')->nullable()->comment('区县');
            $table->string('address',255)->nullable()->comment('详细地址');
            $table->string('tel',30)->nullable()->comment('电话');
            $table->string('fax',30)->nullable()->comment('传真');
            $table->string('zip_code',10)->nullable()->comment('邮编');
            $table->integer('salesman_id')->nullable()->comment('业务员');
            $table->string('ent_code',20)->nullable()->comment('企业统一信用码');
            $table->string('bank',30)->nullable()->comment('开户行');
            $table->string('account',20)->nullable()->comment('银行帐号');
            // $table->string()
            $table->integer('credit_line')->nullable()->comment('信用额度');
            $table->tinyInteger('settle_mode')->nullable()->comment('结算方式: 现金 1，电汇 2，信汇 3，商业汇票 4');
            $table->tinyInteger('settle_type')->nullable()->comment('结算类别: 月结1日 1，月结10日 2，信用天数15天 3，信用天数30天 4');
            $table->string('remark',255)->nullable()->comment('备注');
            $table->tinyInteger('blacklist')->default(0)->index()->comment('是否黑名单：否 0，是 1');
            $table->tinyInteger('status')->default(0)->comment('单据状态：制单中 0，已审核 1');
            $table->datetime('syn_datetime')->nullable()->comment('同步时间');
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
        Schema::dropIfExists('customers');
    }
}
