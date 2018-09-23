<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Traits\RequestTrait;
class LoginRequest extends FormRequest
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
            'account' => [
                'required',
                //  Rule::exists('users'),
            ],
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'account.required' => '账号必填',
            // 'email.exists' => '账号不存在',
            'password.required' => '密码必填',
        ];
    }
}
