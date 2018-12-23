<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Http\Requests\Admin\CustomerQuotation\Materiel\CreateRequest;
use App\Http\Requests\Admin\CustomerQuotation\Materiel\UpdateRequest;
use App\Models\Quotation;
use App\Models\QuotationEntry;
use Illuminate\Http\Request;

class PartsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Quotation $quotation, QuotationEntry $quotationentry)
    {
        $quotationentry = $this->search($request, $quotation, $quotationentry);
        return success_json($quotationentry->paginate(config('pageinfo.per_page')));
    }

    public function search(Request $request, Quotation $quotation, QuotationEntry $quotationentry)
    {
        if ($quotation) {
            $quotationentry = $quotationentry->where('quotation_id', (int)$quotation['id']);
        }

        /*$industry = $request->get('industry', 0); //所属行业
        $type = $request->get('type', 0); //客户类别
        $level = $request->get('level', 0); //客户级别
        $source = $request->get('source', 0); //客户来源
        $follow_up_status = $request->get('follow_up_status', 0); //跟进状态
        $quotationentry_number = $request->get('number', ''); // 客户编号
        $quotationentry_name = $request->get('name', ''); // 客户名称
        $short_name = $request->get('name_short', ''); // 客户简称
        $quotationField = $request->get('quotationField', 0); // 排序栏位
        $quotationBy = $request->get('quotationBy', 1); // 排序顺序

        if ($industry) {
            $quotationentry = $quotationentry->where('industry', (int)$industry);
        }
        if ($type) {
            $quotationentry = $quotationentry->where('type', (int)$type);
        }
        if ($level) {
            $quotationentry = $quotationentry->where('level', (int)$level);
        }
        if ($source) {
            $quotationentry = $quotationentry->where('source', (int)$source);
        }
        if ($follow_up_status) {
            $quotationentry = $quotationentry->where('follow_up_status', (int)$follow_up_status);
        }
        // 公司编号
        if ($quotationentry_number) {
            $quotationentry = $quotationentry->where('number', 'like', $quotationentry_number . '%');
        }
        // 客户名称
        if ($quotationentry_name) {
            $quotationentry = $quotationentry->where('name', 'like', '%' . $quotationentry_name . '%');
        }
        // 公司简称
        if ($short_name) {
            $quotationentry = $quotationentry->where('name_short', 'like', '%' . $short_name . '%');
        }

        $quotationFieldArray = array('0' => 'number', '1' => 'name', '2' => 'industry', '3' => 'type', '4' => 'level', '5' => 'follow_up_status', '6' => 'source');
        $quotationByArray = array('0' => 'ASC', '1' => 'DESC',);
        if (!empty($quotationFieldArray[$quotationField]) && !empty($quotationByArray[$quotationBy])) {

            $quotationentry = $quotationentry->quotationBy($quotationFieldArray[$quotationField], $quotationByArray[$quotationBy]);
        }*/
        $quotationentry->with('part');
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
        $data = $request->only([
            'base_quotationentry_id',
            'base_code_id',
            'number',
            'name',
            'model',
            'unit',
            'quantity',
            'price',
            'amount',
            'discount',
            'amount_dis',
            'warranty_months',
            'warranty_date',
        ]);
        //$request['source'] = $request->get('source', 3);

        $data['base_quotationentry_id'] = (int)$data['base_quotationentry_id'];
        $data['base_code_id'] = (int)$data['base_code_id'];
        $data['warranty_months'] = (int)$data['warranty_months'];
        $data['quantity'] = doubleval($data['quantity']);
        $data['price'] = doubleval($data['price']);
        $data['amount'] = doubleval($data['amount']);
        $data['discount'] = doubleval($data['discount']);
        $data['warranty_date'] = format_date($data['warranty_date']);

        $data['quotation_id'] = (int)$quotation['id'];
        $data['created_by'] = '新增';
        $data['updated_by'] = '新增';

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
        $data = $request->only([
            'base_quotationentry_id',
            'base_code_id',
            'number',
            'name',
            'model',
            'unit',
            'quantity',
            'price',
            'amount',
            'discount',
            'amount_dis',
            'warranty_months',
            'warranty_date',
        ]);

        $data['base_quotationentry_id'] = (int)$data['base_quotationentry_id'];
        $data['base_code_id'] = (int)$data['base_code_id'];
        $data['warranty_months'] = (int)$data['warranty_months'];
        $data['quantity'] = doubleval($data['quantity']);
        $data['price'] = doubleval($data['price']);
        $data['amount'] = doubleval($data['amount']);
        $data['discount'] = doubleval($data['discount']);
        $data['warranty_date'] = format_date($data['warranty_date']);

        $data['updated_by'] = '修改';

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
