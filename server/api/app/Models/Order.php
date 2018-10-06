<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $table = 'service_orders';


    protected $appends = [];
    /**
     * 客户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function documents()
    {
        return $this->belongsToMany(Document::class, 'service_order_documents', 'order_id', 'document_id');
    }

    /**
     * 工程师表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function engineers()
    {
        return $this->hasMany(Engineer::class, 'service_order_id')->with('staff');
//        return $this->belongsToMany(Engineer::class, 'order_service_engineer', 'order_service_id', 'engineer_id');
    }

    /**
     * 反馈人人员
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function feedbackStaff()
    {
        return $this->belongsTo(Staff::class, 'feedback_staff_id');
    }

    /**
     * 接收人员
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function receiveStaff()
    {
        return $this->belongsTo(Staff::class, 'receive_staff_id');
    }

    /**
     * 确认
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function confirmStaff()
    {
        return $this->belongsTo(Staff::class, 'confirm_staff_id');
    }
}
