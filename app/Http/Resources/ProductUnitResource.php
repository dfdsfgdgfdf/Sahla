<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ProductUnitResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        // return parent::toArray($request);
        if(isset(request()->lang)):
            $name = 'name_'.request()->lang;
        endif;


        return [
            "id" => $this->id,
            "unit_id" => $this->unit_id,
            "price" => isset($this->price) ? strval($this->price.' '.env('APP_CURRENCY') ) : '',
            "unit" => isset($this->unit->$name) ? $this->unit->$name : '',
        ];
    }
}
