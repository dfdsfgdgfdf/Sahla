<?php

namespace App\Http\Controllers\Api\Merchant;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartProductResource;
use App\Http\Resources\ProductInfoResource;
use App\Http\Resources\ProductResource;
use App\Models\CartProduct;
use App\Models\Product;
use App\Models\ProductUnit;
use Freshbitsweb\LaravelCartManager\Traits\CartItemsManager;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    use GeneralTrait;

    public function myCartProducts(Request $request)
    {
        $this->validate($request, [
            'lang' => 'required|in:ar,en,ur',
        ]);
        $products = \auth()->user()->cartProducts;
        $total = 0;
        foreach ($products as $product) {
            $total += $product->price * $product->quantity;
        }
        return $this->successTotalMessage(CartProductResource::collection($products), 'Your Cart Products', $total);
    }


    public function addToCart(Request $request)
    {
        $this->validate($request, [
            'lang' => 'required|in:ar,en,ur',
            'product_id' => 'required|exists:products,id',
            'unit_id' => 'nullable',
        ]);
        $product = Product::whereStatus(1)->whereId($request->product_id)->first();
        if ($product){
            $in_cart = CartProduct::whereUserId(\auth()->id())->whereProductId($product->id)->first();
            if(empty($in_cart)){
                $input['user_id']   = \auth()->id() ;
                $input['product_id']= $product->id ;
                $input['unit_id']   = $product->unit_id ;
                $input['price']     = $product->price ;
                $input['currency']  = env('APP_CURRENCY') ;
                $input['quantity']  = $request->quantity != "" ? $request->quantity : '1' ;
                $input['name']      = $product->name_ar != '' ? $product->name_ar : ($product->name_en != '' ? $product->name_en : $product->name_ur );
                $input['image']     = $product->firstMedia->file_name;
                if($request->unit_id != ''){
                    $unitProduct = ProductUnit::whereStatus(1)->whereProductId($product->id)->whereUnitId($request->unit_id)->first();
                    if($unitProduct){
                        $input['unit_id']   = $request->unit_id ;
                        $input['price']     = $unitProduct->price;
                        $input['currency']  = env('APP_CURRENCY') ;
                    }else {
                        return $this->returnErrorMessage('Sorry! Please Try Again, Or Choose Another Unit Id', '422');
                    }
                }
                CartProduct::create($input);
                return $this->returnSuccessMessage('Product Is Added To Cart Successfully !');
            }else{
                return $this->returnSuccessMessage('This Product Is Already In Your Cart List!');
            }
        }else {
            return $this->returnErrorMessage('Sorry! Please Try Again, Or Choose Another Product', '422');
        }
    }


    public function UpdateCartProduct(Request $request)
    {
        $this->validate($request, [
            'cart_product_id' => 'required|exists:cart_products,id',
            'lang' => 'required|in:ar,en,ur',
        ]);
        $in_cart = CartProduct::whereUserId(\auth()->id())->whereId($request->cart_product_id)->first();
        if($in_cart){
            $input['quantity']  = $request->quantity != '' ? $request->quantity : $in_cart->quantity;
            $input['price']     = $request->price != '' ? $request->price : $in_cart->price;
            $input['currency']  = env('APP_CURRENCY') ;
            if($request->unit_id != ''){
                $unitProduct = ProductUnit::whereStatus(1)->whereProductId($in_cart->product_id)->whereUnitId($request->unit_id)->first();
                if($unitProduct){
                    $input['unit_id']   = $request->unit_id ;
                    $input['price']     = $unitProduct->price;
                    $input['currency']  = env('APP_CURRENCY') ;
                }else {
                    return $this->returnErrorMessage('Sorry! Please Try Again, Or Choose Another Unit Id', '422');
                }
            }
            $in_cart->update($input);
            $products = \auth()->user()->cartProducts;

            /* Total Price*/
            $total = 0;
            foreach ($products as $product) {
                $total += $product->price * $product->quantity;
            }

            return $this->successTotalMessage(CartProductResource::collection($products), 'Cart Product Is Updated Successfully !', $total);
        }else {
            return $this->returnErrorMessage('Sorry! Please Try Again, Or Choose Another Product', '422');
        }
    }


    public function removeFromCart(Request $request)
    {
        $this->validate($request, [
            'cart_product_id' => 'required|exists:cart_products,id',
            'lang' => 'required|in:ar,en,ur',
        ]);
        $in_cart = CartProduct::whereUserId(\auth()->id())->whereId($request->cart_product_id)->first();
        if ($in_cart){
            $in_cart->delete();
            return $this->returnSuccessMessage('Item Cart Remove Successfully !');
        }else {
            return $this->returnErrorMessage('Sorry! Please Try Again, Or Choose Another Cart Item', '422');
        }
    }


}
