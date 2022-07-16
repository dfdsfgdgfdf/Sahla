<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class AppStartPageRequest extends FormRequest
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
                    'text_ar'           => 'required|string',
                    'text_en'           => 'required|string',
                    'text_ur'           => 'required|string',
                    'number'            => 'required|numeric|unique:app_start_pages,number',
                    'status'            => 'required|boolean',
                    'image'             => 'required|mimes:png,jpg,jpeg,gif'
                ];
            }

            case 'PUT':

            case 'PATCH':
            {
                return[
                    'text_ar'           => 'nullable|string',
                    'text_en'           => 'nullable|string',
                    'text_ur'           => 'nullable|string',
                    'number'            => 'nullable|numeric|unique:app_start_pages,number,'.$this->route()->appStartPage->id,
                    'status'            => 'nullable|boolean',
                    'image'             => 'nullable|mimes:png,jpg,jpeg,gif'
                ];
            }

            default: break;
        }

    }
}
