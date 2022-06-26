<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class ProductUnitRequest extends FormRequest
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
                    'product_id'    => 'required|exists:products,id',
                    'unit_id'       => 'required|exists:units,id',
                    'price'         => 'required',
                    'status'        => 'required',
                ];
            }

            case 'PUT':

            case 'PATCH':
            {
                return[
                    'unit_id'       => 'required|exists:units,id',
                    'price'         => 'required',
                    'status'        => 'required',
                ];
            }

            default: break;
        }

    }
}
