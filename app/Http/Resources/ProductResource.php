<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ProductResource extends JsonResource
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

        $wishProducts = Auth::user()->wishes() ;
//        return $wishProducts;
        if($wishProducts->count()){
            foreach ($wishProducts as $wishProduct){
                if ($wishProduct->id == $this->id ){
                    $wish = '1';
                }else{
                    $wish = '0';
                }
            }
        }else{
            $wish = '0';
        }

        return [
            "id" => $this->id,
            "name" => isset($this->$name) ? $this->$name : '',
            "category" => isset($this->category->$name) ? $this->category->$name : '',
            "price" => isset($this->price) ? strval($this->price.' '.env('APP_CURRENCY') ) : '',
            "unit" => isset($this->unit->$name) ? $this->unit->$name : '',
            "unit_id" => isset($this->unit_id) ? $this->unit_id : '',
            "image" => isset($this->firstMedia->file_name) ? env('APP_URL').$this->firstMedia->file_name : '',
            "wish" => $wish,
            "rate" => intval($this->avgRatings()),
            // "rate" => 3,
            "created_at" => strval($this->created_at),
            "updated_at" => strval($this->updated_at),
        ];
    }
}
