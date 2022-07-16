<?php

use App\Http\Controllers\Api\Merchant\CartController;
use App\Http\Controllers\Api\Merchant\CategoryController;
use App\Http\Controllers\Api\Merchant\GeneralController;
use App\Http\Controllers\Api\Merchant\InvoiceController;
use App\Http\Controllers\Api\Merchant\OrderController;
use App\Http\Controllers\Api\Merchant\ProductController;
use App\Http\Controllers\Api\Merchant\ProductReviewController;
use App\Http\Controllers\Api\Merchant\ProductUnitController;
use App\Http\Controllers\Api\Customer\CustomerController;
use App\Http\Controllers\Api\Merchant\WishListController;
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

Route::post('auth-token', [CustomerController::class, 'store']);
Route::post('create-customer-account', [CustomerController::class, 'createCustomerAccount']);





Route::group(['middleware' => 'auth:sanctum'], function () {

    /* customer login */
    Route::post('update-image', [TokenController::class, 'updateImage']);


});


