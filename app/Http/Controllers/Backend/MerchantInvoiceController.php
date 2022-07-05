<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\LogoRequest;
use App\Models\Invoice;
use App\Models\Logo;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\User;
use App\Models\UserAddress;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;

class MerchantInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Carbon::setLocale('ar');

        if (!\auth()->user()->ability('superAdmin', 'manage_merchants')) {
            return redirect('admin/index');
        }
        $invoices = Invoice::whereuserId($request->user_id)
            ->latest()
            ->paginate(10);
        $user = User::whereId($request->user_id)->first();
        return view('backend.merchants_invoices.index', compact('invoices', 'user'));
    }


    public function showById(Request $request)
    {
        Carbon::setLocale('ar');
        $invoice = Invoice::whereId($request->id)->first();
        $orders = Order::whereInvoiceId($invoice->id)->get();
        $addrress  = UserAddress::whereUserId($invoice->user_id)->whereDefaultAddress(1)->first();
        return view('backend.merchants_invoices.pdf_invoice', compact('invoice', 'orders', 'addrress'));
    }

    public function showOrders(Request $request)
    {
        Carbon::setLocale('ar');
        $invoice = Invoice::whereId($request->id)->first();
        $orders = Order::whereInvoiceId($invoice->id)->latest()->paginate(10);;
        $addrress  = UserAddress::whereUserId($invoice->user_id)->whereDefaultAddress(1)->first();
        return view('backend.merchants_invoices.invoice_orders', compact('invoice', 'orders', 'addrress'));
    }

    public function ordersChangeStatus(Request $request)
    {
        $order = Order::find($request->cat_id);
        $order->status = $request->status;
        $order->save();
        return response()->json(['success'=>'Status Change Successfully.']);
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


    /*
    ********************************************************************************************
    */
    public function pending()
    {
        Carbon::setLocale('ar');

        if (!\auth()->user()->ability('superAdmin', 'manage_merchants')) {
            return redirect('admin/index');
        }
        $orders = Order::whereStatus('pending')->whereCustomerStatus('waiting')
            ->when(\request()->keyword !=null, function($query){
                $query->search(\request()->keyword);
            })
            ->when(\request()->status !=null, function($query){
                $query->whereStatus(\request()->status);
            })
            ->orderBy(\request()->sort_by ?? 'id' ,  \request()->order_by ?? 'desc')

            ->paginate(\request()->limit_by ?? 10);

        return view('backend.orders.pending', compact('orders'));
    }
    /*
    ********************************************************************************************
    */
    public function accepted()
    {
        Carbon::setLocale('ar');

        if (!\auth()->user()->ability('superAdmin', 'manage_merchants')) {
            return redirect('admin/index');
        }
        $orders = Order::whereStatus('accepted')->whereCustomerStatus('waiting')
            ->when(\request()->keyword !=null, function($query){
                $query->search(\request()->keyword);
            })
            ->when(\request()->status !=null, function($query){
                $query->whereStatus(\request()->status);
            })
            ->orderBy(\request()->sort_by ?? 'id' ,  \request()->order_by ?? 'desc')

            ->paginate(\request()->limit_by ?? 10);

        return view('backend.orders.accepted', compact('orders'));
    }
    public function completed()
    {
        Carbon::setLocale('ar');

        if (!\auth()->user()->ability('superAdmin', 'manage_merchants')) {
            return redirect('admin/index');
        }
        $orders = Order::whereStatus('completed')->whereCustomerStatus('waiting')
            ->when(\request()->keyword !=null, function($query){
                $query->search(\request()->keyword);
            })
            ->when(\request()->status !=null, function($query){
                $query->whereStatus(\request()->status);
            })
            ->orderBy(\request()->sort_by ?? 'id' ,  \request()->order_by ?? 'desc')

            ->paginate(\request()->limit_by ?? 10);

        return view('backend.orders.completed', compact('orders'));
    }
    public function rejected()
    {
        Carbon::setLocale('ar');

        if (!\auth()->user()->ability('superAdmin', 'manage_merchants')) {
            return redirect('admin/index');
        }
        $orders = Order::whereStatus('rejected')->whereCustomerStatus('waiting')
            ->when(\request()->keyword !=null, function($query){
                $query->search(\request()->keyword);
            })
            ->when(\request()->status !=null, function($query){
                $query->whereStatus(\request()->status);
            })
            ->orderBy(\request()->sort_by ?? 'id' ,  \request()->order_by ?? 'desc')

            ->paginate(\request()->limit_by ?? 10);

        return view('backend.orders.rejected', compact('orders'));
    }
    public function cancelled()
    {
        Carbon::setLocale('ar');

        if (!\auth()->user()->ability('superAdmin', 'manage_merchants')) {
            return redirect('admin/index');
        }
        $orders = Order::where('status', '!=', 'completed')->whereCustomerStatus('cancel')
            ->when(\request()->keyword !=null, function($query){
                $query->search(\request()->keyword);
            })
            ->when(\request()->status !=null, function($query){
                $query->whereStatus(\request()->status);
            })
            ->orderBy(\request()->sort_by ?? 'id' ,  \request()->order_by ?? 'desc')

            ->paginate(\request()->limit_by ?? 10);

        return view('backend.orders.cancelled', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_merchants')) {
            return redirect('admin/index');
        }
//        return view('backend.logos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LogoRequest $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_merchants')) {
            return redirect('admin/index');
        }
        //
    }

    public function edit(Logo $logo)
    {
        //
    }

    public function update(LogoRequest $request, Logo $logo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Logo $logo)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_merchants')) {
            return redirect('admin/index');
        }

        //

    }

    public function changeStatus(Request $request)
    {
       //
    }
}

