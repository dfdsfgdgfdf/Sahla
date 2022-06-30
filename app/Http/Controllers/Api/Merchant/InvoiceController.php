<?php

namespace App\Http\Controllers\Api\Merchant;

use App\Http\Controllers\Controller;
use App\Http\Resources\InvoiceResource;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;

class InvoiceController extends Controller
{
    use GeneralTrait;


    public function completeInvoices(Request $request)
    {
        $this->validate($request, [
            'lang' => 'required|in:ar,en,ur',
        ]);
        $orders = \auth()->user()->completedOrders;
        return $this->successMessage(InvoiceResource::collection($orders), 'Your Completed Invoices List');
    }


}
