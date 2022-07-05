<?php

namespace App\Http\Resources;

use App\Models\OrderProduct;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
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

        return [
            "id" => $this->id,
            "invoice_number" => $this->invoice_number,
            "total" => $this->total,
            "paid" => isset($this->paid) && $this->paid != 0 ? $paid : $unpaid,
            "status" => $this->status,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
