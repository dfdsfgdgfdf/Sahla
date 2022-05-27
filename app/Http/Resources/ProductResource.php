<?php

namespace App\Http\Resources;

use App\Models\Product;
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
            $description = 'description_'.request()->lang;
        endif;

        $wishProducts = Auth::user()->wishes() ;
        foreach ($wishProducts as $wishProduct){
            if ($wishProduct->id == $this->id ){
                $wish = '1';
            }else{
                $wish = '0';
            }
        }

        return [
            "id" => $this->id,
            $name => isset($this->name) ? $this->name : '',
            $description => isset($this->description) ? $this->description : '',
            "price" => isset($this->price) ? $this->price : '',
            "image" => isset($this->firstMedia->file_name) ? env('APP_URL').$this->firstMedia->file_name : '',
            "wish" => $wish,
            "rate" => '2',
            "created_at" => strval($this->created_at),
            "updated_at" => strval($this->updated_at),
        ];
    }
}
