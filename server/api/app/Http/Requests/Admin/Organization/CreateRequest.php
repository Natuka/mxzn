<?php

namespace App\Http\Requests\Admin\Organization;

use Illuminate\Foundation\Http\FormRequest;
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
            'number' => 'required',
            'name_short' => 'required',
            'name' => 'required|unique:users',
        ];
    }

    public function messages()
    {
        return [
            'number.required' => '编号必填',
            'name.required' => '名称必填',
            'name_short.required' => '名称简称必填',
        ];
    }
}
