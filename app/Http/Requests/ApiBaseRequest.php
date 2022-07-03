<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use App\Enums\ResponseType;
use Illuminate\Http\Exceptions\HttpResponseException;

abstract class ApiBaseRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        $data = [
            'status' => ResponseType::PARAM_ERROR,
            'message' => ResponseType::getErrorMessage(ResponseType::PARAM_ERROR),
            'data' => $validator->errors()->toArray()
        ];
        throw new HttpResponseException(response()->json($data, ResponseType::BADREQUEST));
    }
}
