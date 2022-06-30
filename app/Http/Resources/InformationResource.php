<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InformationResource extends JsonResource
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
            $text = 'text_'.request()->lang;
        endif;

        return [
            "id" => $this->id,
            "text" => isset($this->$text) ? $this->$text : '',
        ];
    }
}
