<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name'=> 'required|min:6',
            'category'=> 'required',
            'unit_price'=> 'required', 
            'description'=> 'required|min:15',
            'max_unit'=> 'required',
            'min_unit'=> 'required',
            'ref'=>'required',
            'quantity'=> 'required',
            'img1'=> 'required|image',
            'img2'=> 'required|image',
            'img3'=> 'required|image',
            
        ];
    }
}
