<?php
namespace App\Traits;

use Illuminate\Contracts\Validation\Validator;
trait RequestTrait
{
    protected function failedValidation(Validator $validator)
    {
        throw new \App\Exceptions\ApiException($validator->errors()->first());
    }

}
