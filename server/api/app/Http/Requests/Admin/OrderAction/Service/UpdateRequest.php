<?php

namespace App\Http\Requests\Admin\OrderAction\Service;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\RequestTrait;

class UpdateRequest extends FormRequest
{
    use RequestTrait;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
//            'service_order_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'service_order_id.required' => '订单ID必须有值!',
        ];
    }
}
