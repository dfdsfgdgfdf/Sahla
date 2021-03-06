<?php

namespace App\Http\Controllers\Api\Merchant;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductInfoResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;

class ProductController extends Controller
{
    use GeneralTrait;

    public function getProductDetails(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required|exists:products,id',
            'lang' => 'required|in:ar,en,ur',
        ]);
        $products = Product::whereId($request->product_id)->whereStatus(1)->get();
        return $this->successMessage(ProductInfoResource::collection($products), 'Product Details');
    }
    public function productsSearch(Request $request)
    {
        $this->validate($request, [
            'keyword' => 'required|min:1',
            'lang' => 'required|in:ar,en,ur',
        ]);

        $products = Product::whereStatus(1)->where(function ($q) use ($request) {
            $q->where('name_ar', 'like', "%{$request->keyword}%")
                ->orWhere('name_en', 'like', "%{$request->keyword}%")
                ->orWhere('name_ur', 'like', "%{$request->keyword}%")

                ->orWhere('description_ar', 'like', "%{$request->keyword}%")
                ->orWhere('description_en', 'like', "%{$request->keyword}%")
                ->orWhere('description_ur', 'like', "%{$request->keyword}%");
        })->latest('id')->paginate(20);
        return $this->successMessage(ProductResource::collection($products), 'Products Search Resultd');
    }

}
