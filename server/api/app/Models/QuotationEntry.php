<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuotationEntry extends Model
{
    //物料基础资料
    protected $table = 'quotation_entry';

    //
    public function part()
    {
        return $this->hasOne(Part::class, 'id', 'item_id');
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

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    //
    public static function builderWithQuotation()
    {
        return static::leftJoin('quotation', 'quotation.id', '=', 'quotation_entry.quotation_id')
            ->selectRaw('quotation_entry.*,quotation.billno,quotation.customer_id,
                        quotation.customer_contact_id,quotation.pay,quotation.carriage,quotation.effective_date,
                        quotation.expiration_date,quotation.delivery_date,quotation.checked_date,quotation.status');
    }


    /**
     * 客户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hasCustomer()
    {
        return $this->belongsTo(Customer::class, 'quotation.customer_id');
//        关联查询出部分字段
//        return $this->belongsTo(Customer::class, 'cust_id')->select(['id','name']);
    }

    /**
     * 客户联系人
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hasContact()
    {
        return $this->belongsTo(CustomerContact::class, 'quotation.customer_contact_id');
    }
}
