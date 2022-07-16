<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\LogoRequest;
use App\Models\Invoice;
use App\Models\Logo;
use App\Models\Order;
use App\Models\OrderProduct;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;

class CustomerOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_settings,show_logos')) {
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
    public function showInvoice(Request $request, Order $order)
    {
        //        Carbon::setLocale('ar');

        $orderProducts = OrderProduct::whereOrderId($order->id)->get();

        $total = 0;
        foreach ($orderProducts as $product) {
            $total += $product->price * $product->quantity;
        }
        return view('backend.orders.invoice', compact('orderProducts', 'total', 'order'));
    }
    /***********/
    public function ordersChangeStatus(Request $request)
    {
        $order = Order::find($request->cat_id);
        $order->status = $request->status;
        $order->save();
        return response()->json(['success'=>'Status Change Successfully.']);
    }
    /*
    ********************************************************************************************
    */
    public function pending()
    {
        Carbon::setLocale('ar');

        if (!\auth()->user()->ability('superAdmin', 'manage_settings,show_logos')) {
            return redirect('admin/index');
        }
        $orders = Order::whereHas('user', function($query){
                $query->whereHas('roles', function($q){
                    $q->where('name', 'customer');
                });
            })
            ->whereStatus('pending')->whereCustomerStatus('waiting')
            ->orderBy('id' ,'desc')
            ->paginate(10);

        return view('backend.orders.pending', compact('orders'));
    }
    /*
    ********************************************************************************************
    */
    public function accepted()
    {
        Carbon::setLocale('ar');

        if (!\auth()->user()->ability('superAdmin', 'manage_settings,show_logos')) {
            return redirect('admin/index');
        }
        $orders = Order::whereHas('user', function($query){
                $query->whereHas('roles', function($q){
                    $q->where('name', 'customer');
                });
            })
            ->whereStatus('accepted')->whereCustomerStatus('waiting')
            ->orderBy('id' ,'desc')
            ->paginate(10);

        return view('backend.orders.accepted', compact('orders'));
    }
    public function completed()
    {
        Carbon::setLocale('ar');

        if (!\auth()->user()->ability('superAdmin', 'manage_settings,show_logos')) {
            return redirect('admin/index');
        }
        $orders = Order::whereHas('user', function($query){
                $query->whereHas('roles', function($q){
                    $q->where('name', 'customer');
                });
            })
            ->whereStatus('completed')->whereCustomerStatus('waiting')
            ->orderBy('id' ,'desc')
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
        $pendingInvoices = Invoice::whereHas('user', function($query){
                $query->whereHas('roles', function($q){
                    $q->where('name', 'customer');
                });
            })
            ->whereStatus('pending')->wherePaid(0)
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
        $pendingInvoices = Invoice::whereHas('user', function($query){
                $query->whereHas('roles', function($q){
                    $q->where('name', 'customer');
                });
            })
            ->whereStatus('completed')->wherePaid(1)
            ->orderBy('id' ,'desc')
            ->paginate(10);

        return view('backend.orders.completedInvoices', compact('pendingInvoices'));
    }
    /***********/

}

