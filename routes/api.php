<?php

use App\Http\Controllers\Api\Merchant\CartController;
use App\Http\Controllers\Api\Merchant\CategoryController;
use App\Http\Controllers\Api\Merchant\GeneralController;
use App\Http\Controllers\Api\Merchant\InvoiceController;
use App\Http\Controllers\Api\Merchant\OrderController;
use App\Http\Controllers\Api\Merchant\ProductController;
use App\Http\Controllers\Api\Merchant\ProductReviewController;
use App\Http\Controllers\Api\Merchant\ProductUnitController;
use App\Http\Controllers\Api\Merchant\TokenController;
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

Route::post('auth-token', [TokenController::class, 'store']);
Route::post('create-merchant-account', [TokenController::class, 'createMerchantAccount']);
Route::post('forgot-password', [TokenController::class,'forgotPassword']);
Route::post('reset-password', [TokenController::class,'resetPassword']);


Route::get('/app-start-pages', [GeneralController::class, 'appStartPages']);
Route::get('/get-units', [GeneralController::class, 'getUnits']);

Route::get('/get-about-us', [GeneralController::class, 'getAboutUs']);
Route::get('/get-privacy', [GeneralController::class, 'getPrivacy']);
Route::get('/get-rules', [GeneralController::class, 'getRule']);



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
    Route::post('update-image', [TokenController::class, 'updateImage']);
    Route::post('update-merchant-info', [TokenController::class, 'updateMerchantInfo']);

    /* General */
    Route::get('/get-phones', [GeneralController::class, 'getPhones']);
    Route::get('/get-socialMedia', [GeneralController::class, 'getSocialMedia']);
    Route::get('/get-emails', [GeneralController::class, 'getEmails']);
    Route::post('/send-contact-message', [GeneralController::class, 'sendContactMessage']);



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
    Route::post('/remove-product-review', [ProductReviewController::class, 'removeProductReview']);

    /* cart */
    Route::get('my-cart-products', [CartController::class, 'myCartProducts']);
    Route::post('add-to-cart', [CartController::class, 'addToCart']);
    Route::post('update-cart-product', [CartController::class, 'UpdateCartProduct']);
    Route::post('remove-from-cart', [CartController::class, 'removeFromCart']);

    /* Order */
    Route::post('make-order', [OrderController::class, 'makeOrder']);
    Route::get('pending-orders', [OrderController::class, 'pendingOrders']);
    Route::get('order-products', [OrderController::class, 'orderProducts']);
    Route::get('order-details', [OrderController::class, 'orderDetails']);
    Route::get('must-be-paid', [OrderController::class, 'mustBePaid']);
    Route::get('have-been-paid', [OrderController::class, 'haveBeenPaid']);
    /* Invoices */
    Route::get('completed-orders', [InvoiceController::class, 'completeOrders']);
    Route::get('completed-invoices', [InvoiceController::class, 'completeInvoices']);

});


