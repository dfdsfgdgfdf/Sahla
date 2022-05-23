<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use App\Traits\GeneralTrait;

class CategoryController extends Controller
{
    use GeneralTrait;


    public function getAllCategories(Request $request)
    {
        $categories = Category::whereStatus(1)->get();
        return $this->successMessage($categories, 'All Categories');
    }

    public function getAllCategoryProducts(Request $request)
    {
        $this->validate($request, [
            'category_id' => 'required|exists:categories,id',
        ]);
        $products = Product::whereCategoryId($request->category_id)->whereStatus(1)->get();
        return $this->successMessage($products, 'All Category Products');
    }

    public function getProductDetails(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required|exists:products,id',
        ]);
        $products = Product::whereId($request->product_id)->whereStatus(1)->get();
        return $this->successMessage($products, 'Product Details');
    }


}
