<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ContactRequest extends Request
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
            'company' => 'required',
            'bussiness' => 'required',
            'fullname' => 'required',
            'nickname' => 'required',
            'phone' => 'required|digits_between:8,15',
            'email' => 'required|email',
            'reason' => 'required',
        ];
    }
}
