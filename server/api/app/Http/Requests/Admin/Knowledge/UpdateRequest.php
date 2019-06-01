<?php

namespace App\Http\Requests\Admin\Knowledge;

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
            'subject_name' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'subject_name.required' => '主题必填',
        ];
    }
}
