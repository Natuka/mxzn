<?php

namespace App\Http\Requests\Admin\Agent;

use App\Traits\RequestTrait;
use Illuminate\Foundation\Http\FormRequest;

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
            'code' => 'required',
            'email' => 'required',
            'name' => 'required|unique:users',
            'mobile' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'code.required' => '编号必填',
            'email.required' => '邮箱必填',
            'name.required' => '帐号必填',
            'name.unique' => '帐号已存在',
            'mobile.required' => '手机必填',
        ];
    }
}
