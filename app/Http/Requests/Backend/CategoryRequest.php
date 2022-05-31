<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
                    'name_ar'           => 'required|max:255|unique:categories,name_ar',
                    'name_en'           => 'required|max:255|unique:categories,name_en',
                    'name_ur'           => 'required|max:255|unique:categories,name_ur',
                    'status'            => 'required',
                    'description_ar'    => 'required|max:255|unique:categories,description_ar',
                    'description_en'    => 'required|max:255|unique:categories,description_en',
                    'description_ur'    => 'required|max:255|unique:categories,description_ur',
                    'parent_id'         => 'nullable',
                    'cover'             => 'required|mimes:png,jpg,jpeg'
                ];
            }

            case 'PUT':

            case 'PATCH':
            {
                return[
                    'name_ar'           => 'required|max:255',
                    'name_en'           => 'required|max:255',
                    'name_ur'           => 'required|max:255',
                    'status'            => 'nullable',
                    'description_ar'    => 'required|max:255|unique:categories,description_ar',
                    'description_en'    => 'required|max:255|unique:categories,description_en',
                    'description_ur'    => 'required|max:255|unique:categories,description_ur',
                    'status'            => 'nullable',
                    'parent_id'         => 'nullable',
                    'cover'             => 'nullable|mimes:png,jpg,jpeg'
                ];
            }

            default: break;
        }

    }
}
