<?php

namespace App\Http\Requests\Backend;

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
        switch ($this->method()){
            case 'POST':
            {
                return[
                    'name_ar'           => 'required|max:255',
                    'name_en'           => 'required|max:255',
                    'name_ur'           => 'required|max:255',
                    'description_ar'    => 'required|max:255',
                    'description_en'    => 'required|max:255',
                    'description_ur'    => 'required|max:255',
                    'stock'             => 'required',
                    'quantity'          => 'required',
                    'currency'          => 'required',
                    'price'             => 'required',
                    'unit_id'           => 'required',
                    'category_id'       => 'required',
                    'featured'          => 'required',
                    'status'            => 'required',
                    'images'            => 'required',
                    'images.*'          => 'mimes:png,jpg,jpeg,gif',
                ];
            }

            case 'PUT':

            case 'PATCH':
            {
                return[

                    'name_ar'           => 'required|max:255',
                    'name_en'           => 'required|max:255',
                    'name_ur'           => 'required|max:255',
                    'description_ar'    => 'required|max:255',
                    'description_en'    => 'required|max:255',
                    'description_ur'    => 'required|max:255',
                    'stock'             => 'required',
                    'quantity'          => 'required',
                    'currency'          => 'required',
                    'price'             => 'required',
                    'unit_id'           => 'required',
                    'category_id'       => 'required',
                    'featured'          => 'required',
                    'status'            => 'required',
                    'images'            => 'required',
                    'images.*'          => 'mimes:png,jpg,jpeg,gif|max:4048',

                ];
            }

            default: break;
        }

    }
}
