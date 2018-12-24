<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Http\Requests\Admin\CustomerQuotation\CreateRequest;
use App\Http\Requests\Admin\CustomerQuotation\UpdateRequest;
use App\Models\Quotation;
use App\Models\QuotationEntry;
use App\Models\ServiceOrder;
use App\Models\ServiceOrderPart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Quotation $quotation)
    {
        $quotation = $this->search($request, $quotation);
        return success_json($quotation->with(['customer' => function( $query ){
                $query->select(['id','name_short']);
            },
            'contact' => function( $query ){
                $query->select(['id','name','mobile']);
            },
            'order' => function( $query ){
                $query->select(['id','number']);
            }])->paginate( config('pageinfo.per_page') ));
    }

    public function search(Request $request, Quotation $quotation)
    {
        $sch_field = $request->get('schField', ''); //查询字段或模糊查询
        $sch_value = $request->get('schValue', ''); //查询字段或模糊查询
        //$sch_field = 'fuzzy_query';
        if ($sch_value && $sch_field) {
            if ($sch_field == 'fuzzy_query') {
                $quotation = $quotation->where(function($query) use($sch_field, $sch_value)
                {
                    $query->where('name', 'like', '%'.$sch_value.'%')
                        ->orWhere('mobile', 'like', '%'.$sch_value.'%')
                        ->orWhere('job', 'like', '%'.$sch_value.'%');
                });
            }else{
                if ($sch_field == 'cust_id') {
                    $quotation = $quotation->whereHas('customer', function ($query) use ($sch_value) {
                        $query->where('name', 'like', '%'.$sch_value.'%');
                    });
                }else{
                    $quotation = $quotation->where($sch_field, 'like', '%'.$sch_value.'%');
                }
            }
        }

        //排序
        $quotation = $quotation->orderBy('id', 'desc');

        return $quotation;
    }

    /**
     * 报价编号,Q1809-0001,Q+年份2码+月份2码+流水码4码
     * @return string
     */
    public function createNumber()
    {
        $prefix = sprintf('%s%s', 'Q', date('ym'));
        return Quotation::createNumber($prefix);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateRequest $request, Quotation $quotation)
    {
        $user = $request->user();
        $data = $request->only([
            'service_order_id',
            'customer_id',
            'customer_contact_id',
            'pay',
            'carriage',
            'effective_date',
            'expiration_date',
            'delivery_date',
            'remark',
        ]);
        $data['service_order_id'] = (int)$data['service_order_id'];
        $data['customer_id'] = (int)$data['customer_id'];
        $data['customer_contact_id'] = (int)$data['customer_contact_id'];
        $data['pay'] = (int)$data['pay'];
        $data['carriage'] = (int)$data['carriage'];
        $data['effective_date'] = mydb_format_date($data['effective_date'], 'Y-m-d', '1991-01-01');
        $data['expiration_date'] = mydb_format_date($data['expiration_date'], 'Y-m-d', '1991-01-01');
        $data['delivery_date'] = mydb_format_date($data['delivery_date'], 'Y-m-d', '1991-01-01');
        $data['created_by'] = $user->userable_name;
        $data['updated_by'] = $user->userable_name;
        $data['billno'] = $this->createNumber();
        
        $ret = $quotation->forceFill($data)->save();

        if ($ret) {
            return success_json($quotation, '');
        }

        return error_json('新增失败，请检查');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function show(Quotation $quotation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function edit(Quotation $quotation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Quotation $quotation)
    {
        $user = $request->user();
        $data = $request->only([
            'service_order_id',
            'customer_id',
            'customer_contact_id',
            'pay',
            'carriage',
            'effective_date',
            'expiration_date',
            'delivery_date',
            'remark',
        ]);
        $data['service_order_id'] = (int)$data['service_order_id'];
        $data['customer_id'] = (int)$data['customer_id'];
        $data['customer_contact_id'] = (int)$data['customer_contact_id'];
        $data['pay'] = (int)$data['pay'];
        $data['carriage'] = (int)$data['carriage'];
        $data['effective_date'] = mydb_format_date($data['effective_date'], 'Y-m-d', '1991-01-01');
        $data['expiration_date'] = mydb_format_date($data['expiration_date'], 'Y-m-d', '1991-01-01');
        $data['delivery_date'] = mydb_format_date($data['delivery_date'], 'Y-m-d', '1991-01-01');
        $data['updated_by'] = $user->userable_name;
        $ret = $quotation->forceFill($data)->save();

        if ($ret) {
            return success_json($quotation, '');
        }

        return error_json('修改失败，请检查');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function auditing(Request $request)
    {
        $user = $request->user();
        foreach ($request->get('post', []) as $infoId) {
            /*            \Log::info([
                            'next next' => $infoId
                        ]);*/
            $quotation = Quotation::find($infoId);
            if ($quotation) {
                if ($quotation->status == 0) {
                    $data['status'] = 1;
                    $data['checked_by'] = $user->userable_name;
                    $data['checked_date'] = date('Y-m-d H:i:s');
                    $quotation->forceFill($data)->save();
                }

            }
            unset($infoId);
        }

        return success_json('操作成功');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function copy(Request $request)
    {
        $user = $request->user();
        foreach ($request->get('post', []) as $infoId) {
            /*            \Log::info([
                            'next next' => $infoId
                        ]);*/
            $quotation = Quotation::find($infoId);
            if ($quotation) {
                $new_quotation = $quotation->toArray();
                $quotation_id = (int)$new_quotation['id'];
                \Log::info([
                    'new_quotation3534' => $new_quotation
                ]);
                unset($new_quotation['id'], $new_quotation['created_at'], $new_quotation['updated_at']);
                $new_quotation['billno'] = $this->createNumber();
                $new_quotation['status'] = 0;
                $new_quotation['checked_by'] = '';
                $new_quotation['checked_date'] = NULL;
                $data['created_by'] = $user->userable_name;
                $data['updated_by'] = $user->userable_name;
                $ins_quotation = new Quotation();
                $ret = $ins_quotation->forceFill($new_quotation)->save();
                if ($ret) {
                    if ($ins_quotation->id > 0) {
                        //复制配件
                        $materiels = QuotationEntry::where('quotation_id', $quotation_id)->get();
                        $materielsArray = $materiels->toArray();
                        if ($materielsArray) {
                            foreach ($materielsArray as $materielData) {
                                unset($materielData['id'], $materielData['created_at'], $materielData['updated_at']);
                                $materielData['quotation_id'] = $ins_quotation->id;
                                $ins_quotationentry = new QuotationEntry();
                                $ins_quotationentry->forceFill($materielData)->save();
                            }
                        }
                    }
                }
            }
            unset($infoId);
        }

        return success_json('操作成功');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toorder(Request $request)
    {
        $user = $request->user();
        foreach ($request->get('post', []) as $infoId) {
            /*            \Log::info([
                            'next next' => $infoId
                        ]);*/
            $quotation = Quotation::find($infoId);
            if ($quotation) {
                //状态为已审核， 有关联工单
                if ($quotation->service_order_id > 0 && $quotation->status == 1) {
                    $service_order = ServiceOrder::find($quotation->service_order_id);
                    if ($service_order) {
                        //复制配件
                        $materiels = QuotationEntry::where('quotation_id', $quotation->id)->get();
                        $materielsArray = $materiels->toArray();
                        if ($materielsArray) {
                            foreach ($materielsArray as $materielData) {
                                unset($materielData['id'], $materielData['quotation_id'], $materielData['created_at'], $materielData['updated_at'], $materielData['deleted_at']);
                                $materielData['service_order_id'] = $service_order->id;
                                $materielData['base_part_id'] = (int)$materielData['item_id'];
                                $materielData['base_code_id'] = 0;
                                $materielData['quantity'] = doubleval($materielData['quantity']);
                                $materielData['price'] = doubleval($materielData['price']);
                                $materielData['amount'] = doubleval($materielData['amount']);
                                $materielData['discount'] = doubleval($materielData['discount']);
                                $materielData['tax_rate'] = doubleval($materielData['tax_rate']);
                                $materielData['amount_dis'] = doubleval($materielData['discount_amount']);
                                unset($materielData['item_id'], $materielData['discount_amount'], $materielData['delivery_date']);
                                $materielData['created_by'] = $user->userable_name;
                                $materielData['updated_by'] = $user->userable_name;
                                $ins_serviceorderpart = new ServiceOrderPart();
                                $ins_serviceorderpart->forceFill($materielData)->save();
                            }
                        }
                    }
                }

                $new_quotation = $quotation->toArray();
                $quotation_id = (int)$new_quotation['id'];
                \Log::info([
                    'new_quotation3534' => $new_quotation
                ]);
                unset($new_quotation['id'], $new_quotation['created_at'], $new_quotation['updated_at']);
                $new_quotation['billno'] = $this->createNumber();
                $new_quotation['status'] = 0;
                $new_quotation['checked_by'] = '';
                $new_quotation['checked_date'] = NULL;
                $data['created_by'] = $user->userable_name;
                $data['updated_by'] = $user->userable_name;
                $ins_quotation = new Quotation();
                $ret = $ins_quotation->forceFill($new_quotation)->save();
                if ($ret) {
                    if ($ins_quotation->id > 0) {
                        //复制配件
                        $materiels = QuotationEntry::where('quotation_id', $quotation_id)->get();
                        $materielsArray = $materiels->toArray();
                        if ($materielsArray) {
                            foreach ($materielsArray as $materielData) {
                                unset($materielData['id'], $materielData['created_at'], $materielData['updated_at']);
                                $materielData['quotation_id'] = $ins_quotation->id;
                                $ins_quotationentry = new QuotationEntry();
                                $ins_quotationentry->forceFill($materielData)->save();
                            }
                        }
                    }
                }
            }
            unset($infoId);
        }

        return success_json('操作成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quotation $quotation)
    {
        $quotation->delete();
        return success_json($quotation, '删除成功');
    }
}
