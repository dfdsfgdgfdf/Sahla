<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductInfoResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductUnitResource;
use App\Http\Resources\UnitResource;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\ProductUnit;
use App\Models\Unit;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;

class ProductUnitController extends Controller
{
    use GeneralTrait;


    public function getProductUnits(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required|exists:products,id',
            'lang' => 'required|in:ar,en,ur',
        ]);
        $productUnits = ProductUnit::whereProductId($request->product_id)->whereStatus(1)->get();
        if ($productUnits){
            return $this->successMessage(ProductUnitResource::collection($productUnits), 'Product Units');
        }else{
            return $this->returnErrorMessage('Sorry! Please Try Again, Or Choose Another Product OR Unit', '422');
        }
    }

    public function getProductUnitValue(Request $request)
    {
        $this->validate($request, [
            'product_unit_id' => 'required|exists:product_units,id',
            'lang' => 'required|in:ar,en,ur',
        ]);
        $productUnit = ProductUnit::whereId($request->product_unit_id)->whereStatus(1)->first();
        if ($productUnit){
            return $this->successMessage(new ProductUnitResource($productUnit), 'Product Units Value');
        }else{
            return $this->returnErrorMessage('Sorry! Please Try Again, Or Choose Another Product OR Unit', '422');
        }
    }


}
