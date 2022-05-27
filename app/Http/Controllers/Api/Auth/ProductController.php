<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    use GeneralTrait;

    public function getProductDetails(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required|exists:products,id',
        ]);
        $products = Product::whereId($request->product_id)->whereStatus(1)->get();
        return $this->successMessage($products, 'Product Details');
    }
    public function productsSearch(Request $request)
    {
        $this->validate($request, [
            'keyword' => 'required|min:1',
        ]);

        $categories = Product::whereStatus(1)->where(function ($q) use ($request) {
            $q->where('name', 'like', "%{$request->keyword}%")
                ->orWhere('description', 'like', "%{$request->keyword}%");
        })->paginate(20);
        return $this->successMessage($categories, 'Products Search Resultd');
    }

    public function addToWishList(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required|exists:products,id',
        ]);

        $user = Auth::user();
        $product = Product::whereStatus(1)->whereId($request->product_id)->first();
        if ($product){
            $user->wish($product);
            return $this->returnSuccessMessage('Product Successfully Added To Your Wish List');
        }else{
            return $this->returnErrorMessage('Sorry! Please Try Again, Or Choose Another Product', '422');
        }
    }
    public function removeFromWishList(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required|exists:products,id',
        ]);

        $user = Auth::user();
        $product = Product::whereStatus(1)->whereId($request->product_id)->first();
        if ($product){
            $user->unwish($product);
            return $this->returnSuccessMessage('Product Successfully Removed From Your Wish List');
        }else{
            return $this->returnErrorMessage('Sorry! Please Try Again, Or Choose Another Product', '422');
        }
    }

}
