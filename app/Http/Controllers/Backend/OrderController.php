<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\LogoRequest;
use App\Models\Invoice;
use App\Models\Logo;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\UserAddress;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_orders,show_completed_invoices')) {
            return redirect('admin/index');
        }
        //
    }
    /***********/
    public function show(Request $request, Order $order)
    {
        Carbon::setLocale('ar');

        $orderProducts = OrderProduct::whereOrderId($order->id)->get();

        $total = 0;
        foreach ($orderProducts as $product) {
            $total += $product->price * $product->quantity;
        }
        return view('backend.orders.show', compact('orderProducts', 'total'));
    }
    /***********/
    public function showOrderProductsPdf(Request $request, Order $order)
    {
        Carbon::setLocale('ar');
        $orderProducts = OrderProduct::whereOrderId($order->id)->get();
        $total = 0;
        foreach ($orderProducts as $product) {
            $total += $product->price * $product->quantity;
        }
        return view('backend.orders.order_products_pdf', compact('orderProducts', 'total', 'order'));
    }
    /***********/
    public function ordersChangeStatus(Request $request)
    {
        $order = Order::find($request->cat_id);
        if($request->status == 'completed'){
            $order->paid = 1;
            $order->status = $request->status;
        }else{
            $order->status = $request->status;
            $order->paid = 0;
        }
        $order->save();

        $invoice = Invoice::whereId($order->invoice_id)->first();
        $is_pending_orders = Order::whereInvoiceId($order->invoice_id)->wherePaid(0)->first();
        if(empty($is_pending_orders)){
            $invoice->status = 'completed';
            $invoice->paid = 1;
            $invoice->save();
        }else{
            $invoice->status = 'pending';
            $invoice->paid = 0;
            $invoice->save();
        }

        return response()->json(['success'=>'Status Change Successfully.']);
    }
    /***********/
    public function pending()
    {
        Carbon::setLocale('ar');

        if (!\auth()->user()->ability('superAdmin', 'manage_orders,show_completed_invoices')) {
            return redirect('admin/index');
        }
        $orders = Order::whereStatus('pending')->whereCustomerStatus('waiting')
            ->orderBy('id' ,  'desc')
            ->paginate(10);

        return view('backend.orders.pending', compact('orders'));
    }
    /***********/
    public function accepted()
    {
        Carbon::setLocale('ar');

        if (!\auth()->user()->ability('superAdmin', 'manage_orders,show_completed_invoices')) {
            return redirect('admin/index');
        }
        $orders = Order::whereStatus('accepted')->whereCustomerStatus('waiting')
            ->orderBy('id' ,  'desc')
            ->paginate(10);

        return view('backend.orders.accepted', compact('orders'));
    }
    /***********/
    public function completed()
    {
        Carbon::setLocale('ar');

        if (!\auth()->user()->ability('superAdmin', 'manage_orders,show_completed_invoices')) {
            return redirect('admin/index');
        }
        $orders = Order::whereStatus('completed')->whereCustomerStatus('waiting')
            ->orderBy('id' ,  'desc')
            ->paginate(10);

        return view('backend.orders.completed', compact('orders'));
    }
    /***********/
    public function pendingInvoices()
    {
        Carbon::setLocale('ar');

        if (!\auth()->user()->ability('superAdmin', 'manage_orders,show_completed_invoices')) {
            return redirect('admin/index');
        }
        $pendingInvoices = Invoice::whereStatus('pending')->wherePaid(0)
            ->orderBy('id' ,'desc')
            ->paginate(10);

        return view('backend.orders.pendingInvoices', compact('pendingInvoices'));
    }
    /***********/
    public function completedInvoices()
    {
        Carbon::setLocale('ar');

        if (!\auth()->user()->ability('superAdmin', 'manage_orders,show_completed_invoices')) {
            return redirect('admin/index');
        }
        $pendingInvoices = Invoice::whereStatus('completed')->wherePaid(1)
            ->orderBy('id' ,'desc')
            ->paginate(10);

        return view('backend.orders.completedInvoices', compact('pendingInvoices'));
    }
    /***********/
    public function showInvoiceOrdersTable(Request $request, $id)
    {
        Carbon::setLocale('ar');
        $invoice = Invoice::whereId($id)->first();
        $orders = Order::whereInvoiceId($invoice->id)->latest()->paginate(10);;
        $addrress  = UserAddress::whereUserId($invoice->user_id)->whereDefaultAddress(1)->first();
        return view('backend.orders.invoice_orders_table', compact('invoice', 'orders', 'addrress'));
    }
    /***********/
    public function showInvoiceOrdersPdf(Request $request, $id)
    {
        Carbon::setLocale('ar');
        $invoice = Invoice::whereId($id)->first();
        $orders = Order::whereInvoiceId($id)->latest()->get();;
        return view('backend.orders.invoice_ordes_pdf', compact('orders','invoice'));
    }


}

