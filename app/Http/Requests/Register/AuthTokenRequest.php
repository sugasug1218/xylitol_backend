<?php

namespace App\Http\Requests\Register;

use App\Http\Requests\ApiBaseRequest;

class AuthTokenRequest extends ApiBaseRequest
{
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
            'preId' => 'required | integer | exists:pre_users,id',
            'token' => 'required | string'
        ];
    }
}
