<?php

namespace App\Modules\admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Request;

class ImageRequest extends Request
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
            'img' =>'mimes:jpeg,bmp,png'
        ];
    }

    public function messages(){
        return [
            'img.mimes' => 'Please choose the image'
        ];
    }
}
