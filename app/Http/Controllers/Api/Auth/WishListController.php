<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Auth;

class WishListController extends Controller
{
    use GeneralTrait;


    public function wishList(Request $request)
    {
        $this->validate($request, [
            'lang' => 'required|in:ar,en,ur',
        ]);

        $products = Auth::user()->wishes(2);

        return $this->successMessage(ProductResource::collection($products)->response()->getData(true), 'My Wish List Products');
    }
    public function addToWishList(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required|exists:products,id',
            'lang' => 'required|in:ar,en,ur',
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
            'lang' => 'required|in:ar,en,ur',
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
