<?php

namespace App\Http\Requests\Admin\ServiceOrder;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\RequestTrait;

class CancelRequest extends FormRequest
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
            'cancel_type' => 'required',
            'cancel_cause' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'cancel_type.required' => '名称必填',
            'cancel_cause.required' => '原因必填',
        ];
    }
}
