<?php

namespace App\Http\Requests\Admin\ServiceOrder;

use Illuminate\Foundation\Http\FormRequest;

class SwitchDispatchRequest extends FormRequest
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
            'dispatch_type' => 'required',
            'dispatch_engineer' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'dispatch_type.required' => '派工方式必填',
            'dispatch_engineer.required' => '工程师必填',
        ];
    }
}
