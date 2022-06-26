<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderListResource;
use App\Http\Resources\OrderProductResource;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
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

        DB::beginTransaction();
        try {
            $cartProducts = \auth()->user()->cartProducts;

            if($cartProducts->count() > 0 )
            {
                do{
                    $code = Str::random(10);
                    $order_number = Order::where('order_number', $code)->get();
                }
                while(!$order_number->isEmpty());
                $order = Order::create([
                    'user_id' => \auth()->id(),
                    'order_number' => $code
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
            }else{
                return $this->returnSuccessMessage('Sorry, Your Cart Is Empty !');
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


    public function completedOrders(Request $request)
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
}
