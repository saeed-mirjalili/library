<?php

namespace App\saeed;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class apiFormRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'error' => $validator->errors()
        ],status:422));
    }

    protected function failedAuthorization()
    {
        throw new HttpResponseException(response()->json([
            'error' => 'access denied'
        ],status:403));
    }
}