<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\LogoRequest;
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

        if (!\auth()->user()->ability('superAdmin', 'manage_settings,show_logos')) {
            return redirect('admin/index');
        }
        $orders = Order::whereHas('user', function($query){
                $query->whereHas('roles', function($q){
                    $q->where('name', 'customer');
                });
            })
            ->whereStatus('accepted')->whereCustomerStatus('waiting')
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

        if (!\auth()->user()->ability('superAdmin', 'manage_settings,show_logos')) {
            return redirect('admin/index');
        }
        $orders = Order::whereHas('user', function($query){
                $query->whereHas('roles', function($q){
                    $q->where('name', 'customer');
                });
            })
            ->whereStatus('completed')->whereCustomerStatus('waiting')
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

        if (!\auth()->user()->ability('superAdmin', 'manage_settings,show_logos')) {
            return redirect('admin/index');
        }
        $orders = Order::whereHas('user', function($query){
                $query->whereHas('roles', function($q){
                    $q->where('name', 'customer');
                });
            })
            ->whereStatus('rejected')->whereCustomerStatus('waiting')
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

        if (!\auth()->user()->ability('superAdmin', 'manage_settings,show_logos')) {
            return redirect('admin/index');
        }
        $orders = Order::whereHas('user', function($query){
                $query->whereHas('roles', function($q){
                    $q->where('name', 'customer');
                });
            })
            ->where('status', '!=', 'completed')->whereCustomerStatus('cancel')
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
        if (!\auth()->user()->ability('superAdmin', 'manage_settings,show_logos')) {
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
        if (!\auth()->user()->ability('superAdmin', 'manage_settings,show_logos')) {
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
        if (!\auth()->user()->ability('superAdmin', 'manage_settings,show_logos')) {
            return redirect('admin/index');
        }

        //

    }

    public function changeStatus(Request $request)
    {
       //
    }
}

