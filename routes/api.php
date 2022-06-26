<?php

use App\Http\Controllers\Api\Auth\CartController;
use App\Http\Controllers\Api\Auth\CategoryController;
use App\Http\Controllers\Api\Auth\OrderController;
use App\Http\Controllers\Api\Auth\ProductController;
use App\Http\Controllers\Api\Auth\ProductReviewController;
use App\Http\Controllers\Api\Auth\ProductUnitController;
use App\Http\Controllers\Api\Auth\WishListController;
use App\Http\Controllers\Api\GeneralController;
use App\Http\Controllers\Api\Auth\TokenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('auth-token', [TokenController::class, 'store']);
Route::post('forgot-password', [TokenController::class,'forgotPassword']);
Route::post('reset-password', [TokenController::class,'resetPassword']);


Route::get('/app-start-pages', [GeneralController::class, 'appStartPages']);
Route::get('/get-units', [GeneralController::class, 'getUnits']);

Route::group(['middleware' => 'auth:sanctum'], function () {

    // Route::get('/user-login-data', function (Request $request) {
    //     return $request->user();
    // });

    // Route::get('/user/posts', function (Request $request) {
    //     return $request->user()->posts;
    // });

    /* customer login */
    Route::get('/user-login-data', [TokenController::class, 'userLoginData']);
    Route::delete('user-token-logout', [TokenController::class, 'destroy']);

    /* categories */
    Route::get('/get-all-categories', [CategoryController::class, 'getAllCategories']);
    Route::get('/categories-search', [CategoryController::class, 'categoriesSearch']);
    Route::get('/get-all-category-products', [CategoryController::class, 'getAllCategoryProducts']);

    /* product */
    Route::get('/get-product-details', [ProductController::class, 'getProductDetails']);
    Route::get('/products-search', [ProductController::class, 'productsSearch']);

    /* product units */
    Route::get('/get-product-units-list', [ProductUnitController::class, 'getProductUnits']);
    Route::get('/get-product-unit-value', [ProductUnitController::class, 'getProductUnitValue']);

    /* wish-list */
    Route::get('/wish-list', [WishListController::class, 'wishList']);
    Route::post('/add-to-wish-list', [WishListController::class, 'addToWishList']);
    Route::post('/remove-from-wish-list', [WishListController::class, 'removeFromWishList']);
    Route::post('/add-remove-product-wish-list', [WishListController::class, 'addRemoveProductWishList']);


    /* wish-list */
    Route::get('/product-reviews', [ProductReviewController::class, 'getProductReviews']);
    Route::post('/add-product-review', [ProductReviewController::class, 'addProductReview']);
    Route::post('/edit-product-review', [ProductReviewController::class, 'editProductReview']);

    /* cart */
    Route::get('my-cart-products', [CartController::class, 'myCartProducts']);
    Route::post('add-to-cart', [CartController::class, 'addToCart']);
    Route::post('update-cart-product', [CartController::class, 'UpdateCartProduct']);
    Route::post('remove-from-cart', [CartController::class, 'removeFromCart']);

    /* Order */
    Route::post('make-order', [OrderController::class, 'makeOrder']);
    Route::get('pending-orders', [OrderController::class, 'pendingOrders']);
    Route::get('completed-orders', [OrderController::class, 'completedOrders']);
    Route::get('order-products', [OrderController::class, 'orderProducts']);
    Route::get('order-details', [OrderController::class, 'orderDetails']);

});


