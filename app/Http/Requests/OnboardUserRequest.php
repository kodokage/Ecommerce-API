<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OnboardUserRequest extends FormRequest
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
            'first_name'=> ['required'],
            'last_name'=> ['required'],
            'gender'=> ['required'],
            'phone'=> ['required', 'max:11', 'min:11'],
            'phone_2'=> ['required', 'max:11', 'min:11'],
            'address'=> ['required'], 
            'nearest_bustop'=> ['required'],
            'delivery_bus_park'=> ['required', 'max:30'],
            'business_name'=> ['required', 'max:30'],
            'image' => ['image', 'max:4000'],
        ]; 
    }
}
