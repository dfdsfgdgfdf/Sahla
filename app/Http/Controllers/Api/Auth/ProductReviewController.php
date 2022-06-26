<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductInfoResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductReviewResource;
use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;

class ProductReviewController extends Controller
{
    use GeneralTrait;


    public function getProductReviews(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required|exists:products,id',
            'lang' => 'required|in:ar,en,ur',
        ]);
        $product = Product::whereId($request->product_id)->whereStatus(1)->first();
        if ($product){
            $reviews = $product->reviews;
            return $this->successMessage(ProductReviewResource::collection($reviews), 'Product Reviews !');
        }else{
            return $this->returnErrorMessage('Sorry! Please Try Again, Or Choose Another Product', '422');
        }
    }


    public function addProductReview(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required|exists:products,id',
            'lang' => 'required|in:ar,en,ur',
            'rating' => 'nullable|in:1,2,3,4,5',
            'content' => 'nullable|min:3',
        ]);
        $product = Product::whereId($request->product_id)->whereStatus(1)->first();
        if ($product){
            $productReview = new ProductReview([
                'user_id'       => auth()->user()->id,
                'product_id'    => $request['product_id'],
                'rating'        => $request['rating'] != "" ? $request['rating'] : 1,
                'content'       => $request['content'] != "" ? $request['content'] : ""
            ]);
            $productReview->save();
            return $this->returnSuccessMessage('Your Product Rating Successfully Added');
        }else{
            return $this->returnErrorMessage('Sorry! Please Try Again, Or Choose Another Product', '422');
        }
    }

    public function editProductReview(ProductReview $productReview, Request $request)
    {
        $this->validate($request, [
            'product_review_id' => 'required|exists:product_reviews,id',
            'rating' => 'nullable|in:1,2,3,4,5',
            'content' => 'nullable|min:3',
        ]);
        $productReview = ProductReview::whereId($request->product_review_id)->whereStatus(1)->first();
        if ($productReview){
            $productReview->update([
                'rating' => $request['rating'],
                'content' => $request['content']
            ]);

            return $this->returnSuccessMessage('Your Product Rating Successfully Edited');
        }else{
            return $this->returnErrorMessage('Sorry! Please Try Again, Or Choose Another Product', '422');
        }
    }

}
