<?php

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\BackendController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\CityController;
use App\Http\Controllers\Backend\CountryController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Backend\EmailController;
use App\Http\Controllers\Backend\PhoneController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ProductCouponController;
use App\Http\Controllers\Backend\ProductReviewController;
use App\Http\Controllers\Backend\SocialMediaController;
use App\Http\Controllers\Backend\StateController;
use App\Http\Controllers\Backend\TagController;
use App\Http\Controllers\Backend\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//دا علشان يبغت ايميل تاكيد عند التسجيل
Auth::routes(['verify'=>true]);

Auth::routes();

Route::group(['prefix' => 'admin', 'as'=>'admin.' ], function(){

    Route::group(['middleware' => 'guest' ], function(){


        Route::get('/login',               [BackendController::class, 'login'    ])->name('login');
        Route::get('/forget_password',     [BackendController::class, 'forget_password'])->name('forget_password');
    });


        //==========================================================================================================
        Route::group(['middleware' => ['roles', 'role:superAdmin|admin|user'] ], function(){

            Route::get('/',               [BackendController::class, 'index'    ])->name('index_route');
            Route::get('/index',          [BackendController::class, 'index'    ])->name('index');


            /*  Category   */
            Route::resource('categories',CategoryController::class);
            Route::post('/categories/removeImage', [CategoryController::class, 'removeImage'])->name('categories.removeImage');
            Route::post('categories/destroyAll', [CategoryController::class,'massDestroy'])->name('categories.massDestroy');
            Route::get('changeStatus', [CategoryController::class,'changeStatus'])->name('categories.changeStatus');

            /*  Tags   */
            Route::resource('tags',TagController::class);
            Route::post('tags-destroyAll', [TagController::class,'massDestroy'])->name('tags.massDestroy');
            Route::get('tags-changeStatus', [TagController::class,'changeStatus'])->name('tags.changeStatus');

            /*  Products   */
            Route::resource('products',ProductController::class);
            Route::post('products-removeImage', [ProductController::class, 'removeImage'])->name('products.removeImage');
            Route::post('products-destroyAll', [ProductController::class,'massDestroy'])->name('products.massDestroy');
            Route::get('products-changeStatus', [ProductController::class,'changeStatus'])->name('products.changeStatus');
            /*  productCoupons   */
            Route::resource('productCoupons',ProductCouponController::class);
            Route::get('productCoupons-changeStatus', [ProductCouponController::class,'changeStatus'])->name('productCoupons.changeStatus');
            Route::post('productCoupons-destroyAll', [ProductCouponController::class,'massDestroy'])->name('productCoupons.massDestroy');
            /*  productReviews   */
            Route::resource('productReviews',ProductReviewController::class);
            Route::get('productReviews-changeStatus', [ProductReviewController::class,'changeStatus'])->name('productReviews.changeStatus');
            Route::post('productReviews-destroyAll', [ProductReviewController::class,'massDestroy'])->name('productReviews.massDestroy');


            /*  Admins   */
            Route::resource('admins'    ,AdminController::class);
            Route::post('admins-removeImage', [AdminController::class,'removeImage'])->name('admins.removeImage');
            Route::get('admins-changeStatus', [AdminController::class,'changeStatus'])->name('admins.changeStatus');
            Route::post('admins-destroyAll', [AdminController::class,'massDestroy'])->name('admins.massDestroy');
            /*  Users   */
            Route::resource('users'    ,UserController::class);
            Route::post('users-removeImage', [UserController::class,'removeImage'])->name('users.removeImage');
            Route::get('users-changeStatus', [UserController::class,'changeStatus'])->name('users.changeStatus');
            Route::post('users-destroyAll', [UserController::class,'massDestroy'])->name('users.massDestroy');
            /*  Customers   */
            Route::resource('customers'    ,CustomerController::class);
            Route::post('customers-removeImage', [CustomerController::class,'removeImage'])->name('customers.removeImage');
            Route::get('customers-changeStatus', [CustomerController::class,'changeStatus'])->name('customers.changeStatus');
            Route::post('customers-destroyAll', [CustomerController::class,'massDestroy'])->name('customers.massDestroy');


            // Route::get('/get_customer_customerSearch',   [CustomerSearchController::class, 'index'    ])->name('customers.get_customer');
            // Route::get('/get_state_customerSearch',      [CustomerSearchController::class, 'get_state_customerSearch'    ])->name('customers.get_state_customerSearch');
            // Route::get('/get_city_customerSearch',      [CustomerSearchController::class, 'get_city_customerSearch'    ])->name('customers.get_city_customerSearch');


            // Route::resource('customer_addresses' ,CustomerAddressController::class);


            /*  countries   */
            Route::resource('countries'    ,CountryController::class);
            Route::get('countries-changeStatus', [CountryController::class,'changeStatus'])->name('countries.changeStatus');
            Route::post('countries-destroyAll', [CountryController::class,'massDestroy'])->name('countries.massDestroy');
            /*  countries   */
            Route::resource('states'    ,StateController::class);
            Route::get('states-changeStatus', [StateController::class,'changeStatus'])->name('states.changeStatus');
            Route::post('states-destroyAll', [StateController::class,'massDestroy'])->name('states.massDestroy');
            /*  countries   */
            Route::resource('cities'    ,CityController::class);
            Route::get('cities-changeStatus', [CityController::class,'changeStatus'])->name('cities.changeStatus');
            Route::post('cities-destroyAll', [CityController::class,'massDestroy'])->name('cities.massDestroy');


            /*  socials   */
            Route::resource('socials'    ,SocialMediaController::class);
            Route::get('socials-changeStatus', [SocialMediaController::class,'changeStatus'])->name('socials.changeStatus');
            Route::post('socials-destroyAll', [SocialMediaController::class,'massDestroy'])->name('socials.massDestroy');
            /*  phones   */
            Route::resource('phones'    ,PhoneController::class);
            Route::get('phones-changeStatus', [PhoneController::class,'changeStatus'])->name('phones.changeStatus');
            Route::post('phones-destroyAll', [PhoneController::class,'massDestroy'])->name('phones.massDestroy');
            /*  emails   */
            Route::resource('emails'    ,EmailController::class);
            Route::get('emails-changeStatus', [EmailController::class,'changeStatus'])->name('emails.changeStatus');
            Route::post('emails-destroyAll', [EmailController::class,'massDestroy'])->name('emails.massDestroy');


        });

});
