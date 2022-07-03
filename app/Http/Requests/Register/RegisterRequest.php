<?php

namespace App\Http\Requests\Register;

use App\Http\Requests\ApiBaseRequest;

class RegisterRequest extends ApiBaseRequest
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
            'preId' => 'required | integer',
            'name' => 'required | string | min:4',
            'email' => 'required | email',
            'password' => 'required | string | min:8 | max:20 ',
            'is_admin' => 'integer | between:0,1'
        ];
    }
}
