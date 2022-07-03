<?php

namespace App\Http\Resources;

use App\Models\OrderProduct;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

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
        if(isset(request()->lang) && request()->lang == 'ar'):
            $paid = 'تم السداد';
            $unpaid = 'لم يتم السداد';
        elseif (isset(request()->lang) && request()->lang == 'en'):
            $paid = 'Paid';
            $unpaid = 'Unpaid';
        elseif (isset(request()->lang) && request()->lang == 'ur'):
            $paid = 'ادا کیا';
            $unpaid = 'بلا معاوضہ';
        endif;

        $orderProducts = OrderProduct::whereOrderId($this->id)->get();
        $total = 0;
        foreach ($orderProducts as $product) {
            $total += $product->price * $product->quantity;
        }

        return [
            "id" => $this->id,
            "order_number" => $this->order_number,
            "status" => isset($this->status) ? $this->status : '',
            "total" => isset($total) ? $total.' '.env('APP_CURRENCY') : '0'.' '.env('APP_CURRENCY') ,
            "paid" => isset($this->paid) && $this->paid != 0 ? $paid : $unpaid,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
