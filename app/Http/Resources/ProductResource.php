<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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

        return [
            "id" => $this->id,
            $name => isset($this->name) ? $this->name : '',
            $description => isset($this->description) ? $this->description : '',
            "price" => isset($this->price) ? $this->price : '',
            "cover" => isset($this->cover) ? env('APP_URL').$this->cover : '',
            "created_at" => strval($this->created_at),
            "updated_at" => strval($this->updated_at),
        ];
    }
}
