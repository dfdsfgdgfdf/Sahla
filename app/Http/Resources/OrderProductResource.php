<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class OrderProductResource extends JsonResource
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
            "name" => isset($this->name) ? $this->name : '',
            "price" => isset($this->price) ? strval($this->price.' '.env('APP_CURRENCY') ) : '',
            "unit" => isset($this->unit->$name) ? $this->unit->$name : '',
            "unit_id" => isset($this->unit_id) ? $this->unit_id : '',
            "quantity" => isset($this->quantity) ? $this->quantity : '',
            "image" => isset($this->image) ? env('APP_URL').$this->image : '',
            "wish" => $wish,
            "created_at" => strval($this->created_at),
            "updated_at" => strval($this->updated_at),
        ];
    }
}
