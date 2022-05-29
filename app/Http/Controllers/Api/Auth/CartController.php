<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    use GeneralTrait;

    public function index(Request $request)
    {
        $this->validate($request, [
            'lang' => 'required|in:ar,en,ur',
            'product_ids' => 'required|array|exists:products,id'
        ]);

        $products = Product::whereStatus(1)->whereIn('id', $request->product_ids)->get();
        return $this->successMessage(ProductResource::collection($products), 'My Cart Products');
    }


//    public function cartProduct(Request $request)
//    {
//        $this->validate($request, [
//            'lang' => 'required|in:ar,en,ur',
//        ]);
//
//        return \Cart::session(Auth::user()->id)->getContent();
//
//    }

//    public function addToCart(Request $request)
//    {
//        $this->validate($request, [
//            'lang' => 'required|in:ar,en,ur',
//            'product_id' => 'required|exists:products,id',
//        ]);
//
//        $product = Product::whereStatus(1)->whereId($request->product_id)->first();
//        if ($product){
//            $cart = session()->get('cart');
//            if(!$cart) {
//                $cart = [
//                    'id' => $product->id,
//                    'name' => $product->name_ar != '' ? $product->name_ar : ($product->name_en != '' ? $product->name_en : $product->name_en ),
//                    "quantity" => 1,
//                    "price" => $product->price,
//                    'image' => $product->firstMedia->file_name,
//                ];
//                session()->put('cart', $cart);
//                return session()->get('cart');
//                return $this->returnSuccessMessage('Product is Added to Cart Successfully !');
//            }
//
//        }else {
//            return $this->returnErrorMessage('Sorry! Please Try Again, Or Choose Another Product', '422');
//        }
//
//    }

//    public function addToCart(Request $request)
//    {
//        $this->validate($request, [
//            'lang' => 'required|in:ar,en,ur',
//            'product_id' => 'required|exists:products,id',
//        ]);
//
//        $product = Product::whereStatus(1)->whereId($request->product_id)->first();
//        if ($product){
//            \Cart::session(Auth::user()->id)->add([
//                'id' => $product->id,
//                'name' => $product->name_ar != '' ? $product->name_ar : ($product->name_en != '' ? $product->name_en : $product->name_en ),
//                'price' => $product->price,
//                'quantity' => $product->quantity,
//                'attributes' => array(
//                    'image' => $product->firstMedia->file_name,
//                )
//            ]);
//
//
//            return $this->returnSuccessMessage('Product is Added to Cart Successfully !');
//        }else {
//            return $this->returnErrorMessage('Sorry! Please Try Again, Or Choose Another Product', '422');
//        }
//
//    }

//    public function removeFromCart(Request $request)
//    {
//        $this->validate($request, [
//            'product_id' => 'required|exists:products,id',
//            'lang' => 'required|in:ar,en,ur',
//        ]);
//
//        \Cart::remove($request->product_id);
//        return $this->returnSuccessMessage('Item Cart Remove Successfully !');
//    }

//    public function clearAllCart()
//    {
//        \Cart::clear();
//        return $this->returnSuccessMessage('All Item Cart Clear Successfully !');
//    }


}
