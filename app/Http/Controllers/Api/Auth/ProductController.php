<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
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

}
