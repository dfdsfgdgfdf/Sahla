<?php

use App\Http\Controllers\Api\Auth\CategoryController;
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
    Route::get('/get-all-category-products', [CategoryController::class, 'getAllCategoryProducts']);
    Route::get('/get-product-details', [CategoryController::class, 'getProductDetails']);
});


