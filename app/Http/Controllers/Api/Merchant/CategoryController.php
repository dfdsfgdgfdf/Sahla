<?php

namespace App\Http\Controllers\Api\Merchant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use App\Traits\GeneralTrait;

class CategoryController extends Controller
{
    use GeneralTrait;


    public function categoriesSearch(Request $request)
    {
        $this->validate($request, [
            'lang' => 'required|in:ar,en,ur',
            'keyword' => 'required|min:1',
        ]);

        $categories = Category::whereStatus(1)->where(function ($q) use ($request) {
            $q->where('name_ar', 'like', "%{$request->keyword}%")
                ->orWhere('name_en', 'like', "%{$request->keyword}%")
                ->orWhere('name_ur', 'like', "%{$request->keyword}%")

                ->orWhere('description_ar', 'like', "%{$request->keyword}%")
                ->orWhere('description_en', 'like', "%{$request->keyword}%")
                ->orWhere('description_ur', 'like', "%{$request->keyword}%");
        })->latest('id')->get();
        return $this->successMessage(CategoryResource::collection($categories), 'Categories Search Result');
    }

    public function getAllCategories(Request $request)
    {
        $this->validate($request, [
            'lang' => 'required|in:ar,en,ur',
        ]);

        $categories = Category::whereStatus(1)->latest('id')->get();
        return $this->successMessage(CategoryResource::collection($categories), 'All Categories');
    }

    public function getAllCategoryProducts(Request $request)
    {
        $this->validate($request, [
            'category_id' => 'required|exists:categories,id',
            'lang' => 'required|in:ar,en,ur',
        ]);
        $products = Product::whereCategoryId($request->category_id)->whereStatus(1)->latest('id')->paginate(20);
        return $this->successMessage(ProductResource::collection($products), 'All Category Products');
    }


}
