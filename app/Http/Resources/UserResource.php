<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class UserResource extends JsonResource
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
            "first_name" => isset($this->first_name) ? $this->first_name : '',
            "last_name" => isset($this->last_name) ? $this->last_name : '',
            "username" => isset($this->username) ? $this->username : '',
            "full_name" => isset($this->full_name) ? $this->full_name : '',
            "email" => isset($this->email) ? $this->email : '',
            "mobile" => isset($this->mobile) ? $this->mobile : '',
            "user_image" => isset($this->user_image) ? env('APP_URL').$this->user_image : '',
            "status" => isset($this->status) ? $this->status : '',
            "account_status" => isset($this->account_status) ? $this->account_status : '',
            "order_status" => isset($this->order_status) ? $this->order_status : '',
            "created_at" => strval($this->created_at),
            "updated_at" => strval($this->updated_at),
        ];
    }
}
