<?php

namespace App\Http\Controllers\Api\Merchant;

use App\Http\Controllers\Controller;
use App\Http\Resources\InvoiceResource;
use App\Http\Resources\OrderListResource;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;

class InvoiceController extends Controller
{
    use GeneralTrait;


    public function completeOrders(Request $request)
    {
        $this->validate($request, [
            'lang' => 'required|in:ar,en,ur',
            'invoice_id'       => 'required|exists:invoices,id',
        ]);
        $orders = Order::where('invoice_id', $request->invoice_id)
            ->where('user_id', \auth()->id() )
            ->where('status', 'completed')
            ->where('customer_status', 'waiting')
            ->where('paid', true)
            ->latest()
            ->get();
        return $this->successMessage(OrderListResource::collection($orders), 'Your Completed Orders List');
    }
    public function completeInvoices(Request $request)
    {
        $this->validate($request, [
            'lang' => 'required|in:ar,en,ur',
        ]);
        $orders = \auth()->user()->completedInvoices;
        return $this->successMessage(InvoiceResource::collection($orders), 'Your Completed Invoices List');
    }

}
