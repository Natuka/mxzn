<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    //物料基础资料
    protected $table = 'quotation';


    /**
     * 获取编号
     * @param string $prefix
     * @return bool|int|string
     */
    public static function createNumber($prefix = '')
    {
        $suffix = 1;
        $number = self::where('billno', 'like', like_right($prefix))->orderBy('id', 'desc')->value('billno');
        if ($number) {
            $suffix = substr($number, strpos($number, '-') + 1) + 1;
        }

        return sprintf('%s-%04d', $prefix, $suffix);
    }
    /**
     * 客户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
//        关联查询出部分字段
//        return $this->belongsTo(Customer::class, 'cust_id')->select(['id','name']);
    }

    /**
     * 客户联系人
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contact()
    {
        return $this->belongsTo(CustomerContact::class, 'customer_contact_id');
    }

    /**
     * 订单
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(ServiceOrder::class, 'service_order_id');
    }


    /**
     * 料号
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entrys()
    {
        return $this->hasMany(QuotationEntry::class, 'quotation_id');
    }
}
