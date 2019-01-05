<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Http\Requests\Admin\CustomerQuotation\Materiel\CreateRequest;
use App\Http\Requests\Admin\CustomerQuotation\Materiel\UpdateRequest;
use App\Models\Quotation;
use App\Models\QuotationEntry;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MaterielListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, QuotationEntry $quotationentry)
    {
        $quotationentry = QuotationEntry::builderWithQuotation();
        $quotationentry = $this->search($request, $quotationentry);
        return success_json($quotationentry->paginate(config('pageinfo.per_page')));
    }

    public function search(Request $request, $quotationentry)
    {
        $sch_field = $request->get('schField', ''); //查询字段或模糊查询
        $sch_value = $request->get('schValue', ''); //查询字段或模糊查询
        //$sch_field = 'fuzzy_query';
        if ($sch_value && $sch_field) {
            if ($sch_field == 'fuzzy_query') {
//                $quotationentry = $quotationentry->where(function($query) use($sch_field, $sch_value)
//                {
//                    $query->where('name', 'like', '%'.$sch_value.'%')
//                        ->orWhere('mobile', 'like', '%'.$sch_value.'%')
//                        ->orWhere('job', 'like', '%'.$sch_value.'%');
//                });
            }else{
                if ($sch_field == 'cust_id') {
                    $quotationentry = $quotationentry->whereHas('hasCustomer', function ($query) use ($sch_value) {
                        $query->where('name', 'like', '%'.$sch_value.'%')
                              ->orWhere('name_short', 'like', '%'.$sch_value.'%');
                    });
                }elseif ($sch_field == 'contacts') {
                    $quotationentry = $quotationentry->whereHas('hasContact', function ($query) use ($sch_value) {
                        $query->where('name', 'like', '%'.$sch_value.'%');
                    });
                }elseif ($sch_field == 'mobile') {
                    $quotationentry = $quotationentry->whereHas('hasContact', function ($query) use ($sch_value) {
                        $query->where('mobile', 'like', '%'.$sch_value.'%');
                    });
                }else{
                    $quotationentry = $quotationentry->where($sch_field, 'like', '%'.$sch_value.'%');
                }
            }
        }

        $quotationentry = $quotationentry->orderBy('quotation.id', 'desc')->orderBy('quotation_entry.id', 'desc');
        $quotationentry->with(['customer', 'contact']);
        return $quotationentry;
    }


    /**
     * @param CreateRequest $request
     * @param Quotation $quotation
     * @param QuotationEntry $quotationentry
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateRequest $request, Quotation $quotation, QuotationEntry $quotationentry)
    {
        $user = $request->user();
        $data = $request->only([
            'quotation_id',
            'item_id',
            'number',
            'name',
            'model',
            'unit',
            'quantity',
            'price',
            'amount',
            'discount',
            'discount_amount',
            'tax_rate',
            'delivery_date',
            'remark',
        ]);

        $data['item_id'] = (int)$data['item_id'];
        $data['tax_rate'] = (int)$data['tax_rate'];
        $data['quantity'] = doubleval($data['quantity']);
        $data['price'] = doubleval($data['price']);
        $data['amount'] = doubleval($data['amount']);
        $data['discount'] = doubleval($data['discount']);
        $data['discount_amount'] = doubleval($data['discount_amount']);
        $data['delivery_date'] = mydb_format_date($data['delivery_date'], 'Y-m-d', '1991-01-01');

        $data['quotation_id'] = (int)$quotation['id'];
//        $data['created_by'] = $user->userable_name;
//        $data['updated_by'] = $user->userable_name;

        $ret = $quotationentry->forceFill($data)->save();

        if ($ret) {
            return success_json($quotationentry, '');
        }

        return error_json('新增失败，请检查');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $quotation
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Quotation $quotation, QuotationEntry $quotationentry)
    {
        $user = $request->user();
        $data = $request->only([
            'item_id',
            'number',
            'name',
            'model',
            'unit',
            'quantity',
            'price',
            'amount',
            'discount',
            'discount_amount',
            'tax_rate',
            'delivery_date',
            'remark',
        ]);

        $data['item_id'] = (int)$data['item_id'];
        $data['tax_rate'] = (int)$data['tax_rate'];
        $data['quantity'] = doubleval($data['quantity']);
        $data['price'] = doubleval($data['price']);
        $data['amount'] = doubleval($data['amount']);
        $data['discount'] = doubleval($data['discount']);
        $data['discount_amount'] = doubleval($data['discount_amount']);
        $data['delivery_date'] = mydb_format_date($data['delivery_date'], 'Y-m-d', '1991-01-01');

//        $data['updated_by'] = $user->userable_name;

        $ret = $quotationentry->forceFill($data)->save();

        if ($ret) {
            return success_json($quotationentry, '');
        }

        return error_json('修改失败，请检查');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quotation $quotation, QuotationEntry $quotationentry)
    {
        $quotationentry->where('quotation_id', (int)$quotation['id'])->delete();
        return success_json($quotationentry, '删除成功');
    }

}
