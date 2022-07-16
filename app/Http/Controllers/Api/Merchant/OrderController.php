<?php

namespace App\Http\Controllers\Api\Merchant;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderListResource;
use App\Http\Resources\OrderProductResource;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\UserMaxLimit;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    use GeneralTrait;

    public function makeOrder(Request $request)
    {
        $this->validate($request, [
            'lang' => 'required|in:ar,en,ur',
        ]);
        App::setLocale($request->lang);

        DB::beginTransaction();
        try {
            $cartProducts = \auth()->user()->cartProducts;
            $cartTotal = 0;
            foreach ($cartProducts as $cartProduct){
                $cartTotal += $cartProduct->price * $cartProduct->quantity;
            }

            $user_maxLimit = UserMaxLimit::whereUserId(\auth()->id())->first();

            /* نشوف هل الشخص دا ليه فاتورة معلقة ولا هنشأ ليه فاتورة جديدة */
            $is_invoice = Invoice::whereUserId(\auth()->id())->wherePaid(false)->whereStatus('pending')->first();

            if( ($is_invoice ?? 0)){
                // TODO: Edit Invoice And Add This Order To Invoice
                $remaining_amount = $user_maxLimit->max_limit - $is_invoice->total;

                if(isset($remaining_amount) && ($remaining_amount >= $cartTotal) && ($user_maxLimit->status != false)){
                    do{
                        /* Order Number*/
                        $order_code = Str::random(10);
                        $order_number = Order::where('order_number', $order_code)->get();
                    }
                    while(!$order_number->isEmpty());
                    $order = Order::create([
                        'order_number' => $order_code,
                        'invoice_id' => $is_invoice->id,
                        'user_id' => \auth()->id(),
                        'total' => $cartTotal,
                    ]);

                    foreach ($cartProducts as $cartProduct)
                    {
                        $input['order_id']  = $order->id ;
                        $input['product_id']= $cartProduct->product_id;
                        $input['unit_id']   = $cartProduct->unit_id ;
                        $input['price']     = $cartProduct->price;
                        $input['currency']  = env('APP_CURRENCY') ;
                        $input['quantity']  = $cartProduct->quantity;
                        $input['name']      = $cartProduct->name;
                        $input['image']     = $cartProduct->image;
                        OrderProduct::create($input);
                        $cartProduct->delete();
                    }
                    $is_invoice->update([ 'total' => $is_invoice->total + $cartTotal]);
                    DB::commit(); // insert data
                    return $this->returnSuccessMessage('Your Order Completed Successfully !');

                }else if(isset($remaining_amount) && ($user_maxLimit->status != true)){
                    return $this->returnSuccessMessage( __('unavailable_purchase_process') );
                }else{
                    return $this->returnSuccessMessage( __('exceed_the_allowed_limit') );
                }

            }else{
                // TODO: Create New Invoice And Order
                if( $cartProducts->count() > 0)
                {
                    // TODO: Check if the order exceed the allowed limit for this merchant?
                    if(isset($user_maxLimit) && ($user_maxLimit->max_limit >= $cartTotal) && ($user_maxLimit->status != false)){
                        do{
                            /* Invoice Number*/
                            $invoice_code = Str::random(15);
                            $invoice_number = Invoice::where('invoice_number', $invoice_code)->get();

                            /* Order Number*/
                            $order_code = Str::random(10);
                            $order_number = Order::where('order_number', $order_code)->get();
                        }
                        while(!($order_number->isEmpty() && $invoice_number->isEmpty() ));
                        $invoice = Invoice::create([
                            'invoice_number' => $invoice_code,
                            'user_id' => \auth()->id(),
                            'total' => $cartTotal,
                        ]);
                        $order = Order::create([
                            'order_number' => $order_code,
                            'invoice_id' => $invoice->id,
                            'user_id' => \auth()->id(),
                            'total' => $cartTotal,
                        ]);

                        foreach ($cartProducts as $cartProduct)
                        {
                            $input['order_id']  = $order->id ;
                            $input['product_id']= $cartProduct->product_id;
                            $input['unit_id']   = $cartProduct->unit_id ;
                            $input['price']     = $cartProduct->price;
                            $input['currency']  = env('APP_CURRENCY') ;
                            $input['quantity']  = $cartProduct->quantity;
                            $input['name']      = $cartProduct->name;
                            $input['image']     = $cartProduct->image;
                            OrderProduct::create($input);
                            $cartProduct->delete();
                        }

                        DB::commit(); // insert data
                        return $this->returnSuccessMessage('Your Order Completed Successfully !');

                    }else if(isset($user_maxLimit) && ($user_maxLimit->status != true)){
                        return $this->returnSuccessMessage(__('unavailable_purchase_process'));
                    }else{
                        return $this->returnSuccessMessage(__('exceed_the_allowed_limit'));
                    }
                }else{
                    return $this->returnSuccessMessage('Sorry, Your Cart Is Empty !');
                }
            }
        } catch (\Exception $e) {
            DB::rollback();
            return $this->returnErrorMessage('Sorry! Please Try Again, Or Choose Another Product', '422');
        }
    }


    public function pendingOrders(Request $request)
    {
        $this->validate($request, [
            'lang' => 'required|in:ar,en,ur',
        ]);
        $orders = \auth()->user()->pendingOrders;
        return $this->successMessage(OrderListResource::collection($orders), 'Your Pending Order List');
    }


    public function completeInvoices(Request $request)
    {
        $this->validate($request, [
            'lang' => 'required|in:ar,en,ur',
        ]);
        $orders = \auth()->user()->completedOrders;
        return $this->successMessage(OrderListResource::collection($orders), 'Your Completed Order List');
    }


    public function orderProducts(Request $request)
    {
        $this->validate($request, [
            'lang' => 'required|in:ar,en,ur',
            'order_id' => 'required|exists:orders,id',
        ]);
        $orderProducts = OrderProduct::whereOrderId($request->order_id)->get();
        if($orderProducts){
            $total = 0;
            foreach ($orderProducts as $product) {
                $total += $product->price * $product->quantity;
            }
            return $this->successTotalMessage(OrderProductResource::collection($orderProducts), 'Your Order Products', $total);
        }else{
            return $this->returnErrorMessage('Sorry! Please Try Again, Or Choose Another Order Id', '422');
        }
    }


    public function orderDetails(Request $request)
    {
        $this->validate($request, [
            'lang' => 'required|in:ar,en,ur',
            'order_id' => 'required|exists:orders,id',
        ]);
        $orderProducts = OrderProduct::whereOrderId($request->order_id)->get();
        if($orderProducts){
            $total = 0;
            foreach ($orderProducts as $product) {
                $total += $product->price * $product->quantity;
            }
            $order = Order::whereId($request->order_id)->first();
            $data = [
                "order_status" => new OrderListResource($order),
                "order_products" => OrderProductResource::collection($orderProducts),
            ];
            return $this->successTotalMessage($data, 'Your Order Details', $total);
        }else{
            return $this->returnErrorMessage('Sorry! Please Try Again, Or Choose Another Order Id', '422');
        }
    }


    /****************************************************************************/
    public function mustBePaid(Request $request)
    {
        $this->validate($request, [
            'lang' => 'required|in:ar,en,ur',
        ]);
        $orders = \auth()->user()->mustBePaid;
        return $this->successMessage(OrderListResource::collection($orders), 'ما عليا');
    }
    public function haveBeenPaid(Request $request)
    {
        $this->validate($request, [
            'lang' => 'required|in:ar,en,ur',
        ]);
        $user_maxLimit = UserMaxLimit::whereUserId(\auth()->id())->first();
        $is_invoice = Invoice::whereUserId(\auth()->id())->wherePaid(false)->whereStatus('pending')->first();
        if (!empty($is_invoice)){
            $remaining_amount = $user_maxLimit->max_limit - $is_invoice->total;
            $orders = \auth()->user()->pendingOrders;
            return $this->specialSuccessMessage('ما لي', $user_maxLimit->max_limit, $remaining_amount, OrderListResource::collection($orders));

        }else{
            $orders = \auth()->user()->pendingOrders;
            return $this->specialSuccessMessage('ما لي', $user_maxLimit->max_limit, $user_maxLimit->max_limit, OrderListResource::collection($orders));
        }
    }
}
