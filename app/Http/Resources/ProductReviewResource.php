<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ProductReviewResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user = User::whereId($this->user_id)->first();

        return [
            "id" => $this->id,
            "product_id" => isset($this->product_id) ? $this->product_id : '',
            "user_name" => isset($user->full_name) ? $user->full_name : '',
            "user_image" => isset($user->user_image) ? env('APP_URL') . $user->user_image : '',
            "content" => isset($this->content) ? $this->content : '',
            "rating" => isset($this->rating) ? $this->rating : '',
            "is_auth" => $this->user_id != \auth()->id() ? 0 : 1,
            "created_at" => strval($this->created_at),
            "updated_at" => strval($this->updated_at),
        ];

    }
}
