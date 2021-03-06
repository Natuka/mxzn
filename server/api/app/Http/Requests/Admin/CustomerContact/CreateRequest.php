<?php

namespace App\Http\Requests\Admin\CustomerContact;

use App\Traits\RequestTrait;
use Illuminate\Foundation\Http\FormRequest;

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
//            'name' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '名称必填',
        ];
    }
}
