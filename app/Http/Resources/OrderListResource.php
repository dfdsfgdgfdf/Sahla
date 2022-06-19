<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderListResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [
            "id" => $this->id,
            "order_number" => $this->order_number,
            "status" => isset($this->status) ? $this->status : '',
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
