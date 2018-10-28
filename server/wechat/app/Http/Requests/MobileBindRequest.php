<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\RequestTrait;

class MobileBindRequest extends FormRequest
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
            'mobile' => 'required|phone',
            'smsCode' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'mobile.required' => '手机号必填',
            'mobile.phone' => '手机号格式错误',
            'smsCode.required' => '短信验证码必填',
        ];
    }
}
