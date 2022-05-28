<?php

use App\Http\Controllers\Api\Auth\CategoryController;
use App\Http\Controllers\Api\Auth\ProductController;
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

    Route::get('/user-login-data', [TokenController::class, 'userLoginData']);
    Route::delete('user-token-logout', [TokenController::class, 'destroy']);


    Route::get('/get-all-categories', [CategoryController::class, 'getAllCategories']);
    Route::get('/categories-search', [CategoryController::class, 'categoriesSearch']);
    Route::get('/get-all-category-products', [CategoryController::class, 'getAllCategoryProducts']);

    Route::get('/get-product-details', [ProductController::class, 'getProductDetails']);
    Route::get('/products-search', [ProductController::class, 'productsSearch']);


    Route::get('/wish-list', [WishListController::class, 'wishList']);
    Route::post('/add-to-wish-list', [WishListController::class, 'addToWishList']);
    Route::post('/remove-from-wish-list', [WishListController::class, 'removeFromWishList']);
});


