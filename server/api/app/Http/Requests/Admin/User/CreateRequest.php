<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Traits\RequestTrait;
class CreateRequest extends FormRequest
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
            'email' => [
                'required',
                 Rule::unique('users'),
            ],
            'mobile' => [
                'required',
                 Rule::unique('users'),
            ],
            'name' => [
                'required',
                 Rule::unique('users'),
            ],
            // 'password' => 'required',
            'password' => 'required',
            //'confirm_password' => 'required|same:password',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => '邮箱必填',
            'email.unique' => '邮箱已存在',
            'mobile.required' => '手机必填',
            'mobile.unique' => '手机已存在',
            'name.required' => '姓名必填',
            'name.unique' => '姓名已存在',
            'password.required' => '密码必填',
            'password.required' => '密码必填',
            'confirm_password.required' => '确认密码必填',
            'confirm_password.same' => '两次密码不一致',
        ];
    }
}
