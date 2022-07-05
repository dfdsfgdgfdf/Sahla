<?php

use App\Http\Controllers\Backend\AboutController;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\BackendController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\CityController;
use App\Http\Controllers\Backend\ContactMessageController;
use App\Http\Controllers\Backend\CountryController;
use App\Http\Controllers\Backend\CustomerOrderController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Backend\EmailController;
use App\Http\Controllers\Backend\InformationController;
use App\Http\Controllers\Backend\LocationController;
use App\Http\Controllers\Backend\LogoController;
use App\Http\Controllers\Backend\MerchantController;
use App\Http\Controllers\Backend\MerchantInvoiceController;
use App\Http\Controllers\Backend\MerchantOrderController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\PageTitleController;
use App\Http\Controllers\Backend\PhoneController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ProductReviewController;
use App\Http\Controllers\Backend\ProductUnitController;
use App\Http\Controllers\Backend\SocialMediaController;
use App\Http\Controllers\Backend\StateController;
use App\Http\Controllers\Backend\TagController;
use App\Http\Controllers\Backend\UnitController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\WorkingTimeController;
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
            /*  Country - State - City */
            Route::get('/getState',     [BackendController::class, 'get_state'    ])->name('backend.get_state');
            Route::get('/getCity',      [BackendController::class, 'get_city'    ])->name('backend.get_city');


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
            Route::post('products-removeImage', [ProductController::class, 'removeImage'])->name('products.removeImage');
            Route::post('products-destroyAll', [ProductController::class,'massDestroy'])->name('products.massDestroy');
            Route::get('products-changeStatus', [ProductController::class,'changeStatus'])->name('products.changeStatus');
            Route::get('products-reviews/{product}', [ProductController::class,'reviewsIndex'])->name('products.reviewsIndex');
            Route::get('products-units/{product}', [ProductController::class,'unitsIndex'])->name('products.unitsIndex');
            Route::resource('products',ProductController::class);
            /*  productCoupons   */
            Route::resource('productCoupons',ProductCouponController::class);
            Route::get('productCoupons-changeStatus', [ProductCouponController::class,'changeStatus'])->name('productCoupons.changeStatus');
            Route::post('productCoupons-destroyAll', [ProductCouponController::class,'massDestroy'])->name('productCoupons.massDestroy');
            /*  productReviews   */
            Route::resource('productReviews',ProductReviewController::class);
            Route::get('productReviews-changeStatus', [ProductReviewController::class,'changeStatus'])->name('productReviews.changeStatus');
            Route::post('productReviews-destroyAll', [ProductReviewController::class,'massDestroy'])->name('productReviews.massDestroy');
            /*  productUnits   */
            Route::get('productUnits-changeStatus', [ProductUnitController::class,'changeStatus'])->name('productUnits.changeStatus');
            Route::post('productUnits-destroyAll', [ProductUnitController::class,'massDestroy'])->name('productUnits.massDestroy');
            Route::resource('productUnits',ProductUnitController::class);

            /*  socials   */
            Route::get('units-changeStatus', [SocialMediaController::class,'changeStatus'])->name('units.changeStatus');
            Route::post('units-destroyAll', [SocialMediaController::class,'massDestroy'])->name('units.massDestroy');
            Route::resource('units'    ,UnitController::class);


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
            /*-------------------------------- */

            /*  Merchants   */
            Route::resource('merchants'    ,  MerchantController::class);
            Route::get('/getMerchantSearch',            [MerchantController::class, 'getMerchantSearch'])->name('merchants.getMerchantSearch');
            Route::post('merchant-removeImage',         [MerchantController::class,'removeImage'])->name('merchants.removeImage');
            Route::get('merchant-changeStatus',         [MerchantController::class,'changeStatus'])->name('merchants.changeStatus');
            Route::post('merchantsDestroyAll',           [MerchantController::class,'massDestroy'])->name('merchants.merchantsDestroyAll');
            //Merchants orders
            Route::resource('merchant_orders',MerchantOrderController::class);
            Route::get('merchants_pending-orders',      [MerchantOrderController::class,'pending'])->name('merchant_orders.pending');
            Route::get('merchants_accepted-orders',     [MerchantOrderController::class,'accepted'])->name('merchant_orders.accepted');
            Route::get('merchants_refused-orders',      [MerchantOrderController::class,'rejected'])->name('merchant_orders.refused');
            Route::get('merchants_completed-orders',    [MerchantOrderController::class,'completed'])->name('merchant_orders.completed');
            Route::get('merchants_cancelled-orders',    [MerchantOrderController::class,'cancelled'])->name('merchant_orders.cancelled');
            //Merchant Invoices
            Route::get('merchant_invoices/invoices', [MerchantInvoiceController::class,'showById'])->name('merchant_invoices.invoices');
            Route::get('merchant_invoices/orders', [MerchantInvoiceController::class,'showOrders'])->name('merchant_invoices.orders');
            Route::resource('merchant_invoices'    ,  MerchantInvoiceController::class);

            /*-------------------------------- */
            /*  Customers   */
            Route::resource('customers',      CustomerController::class);
            Route::get('/getCustomerSearch',            [CustomerController::class, 'getCustomerSearch'])->name('customers.getCustomerSearch');
            Route::post('customers-removeImage',        [CustomerController::class,'removeImage'])->name('customers.removeImage');
            Route::get('customers-changeStatus',        [CustomerController::class,'changeStatus'])->name('customers.changeStatus');
            Route::post('customersDestroyAll',          [CustomerController::class,'massDestroy'])->name('customers.customersDestroyAll');
            //Customers orders
            Route::resource('customer_orders',CustomerOrderController::class);
            Route::get('customers_pending-orders',      [CustomerOrderController::class,'pending'])->name('customer_orders.pending');
            Route::get('customers_accepted-orders',     [CustomerOrderController::class,'accepted'])->name('customer_orders.accepted');
            Route::get('customers_refused-orders',      [CustomerOrderController::class,'rejected'])->name('customer_orders.refused');
            Route::get('customers_completed-orders',    [CustomerOrderController::class,'completed'])->name('customer_orders.completed');
            Route::get('customers_cancelled-orders',    [CustomerOrderController::class,'cancelled'])->name('customer_orders.cancelled');


            // Route::get('/get_customer_customerSearch',   [CustomerSearchController::class, 'index'    ])->name('customers.get_customer');
            // Route::get('/get_state_customerSearch',      [CustomerSearchController::class, 'get_state_customerSearch'    ])->name('customers.get_state_customerSearch');
            // Route::get('/get_city_customerSearch',      [CustomerSearchController::class, 'get_city_customerSearch'    ])->name('customers.get_city_customerSearch');


            // Route::resource('customer_addresses' ,CustomerAddressController::class);


            /*  countries   */
            Route::resource('countries'    ,CountryController::class);
            Route::get('countries-changeStatus', [CountryController::class,'changeStatus'])->name('countries.changeStatus');
            Route::post('countries-destroyAll', [CountryController::class,'massDestroy'])->name('countries.massDestroy');
            /*  states   */
            Route::resource('states'    ,StateController::class);
            Route::get('states-changeStatus', [StateController::class,'changeStatus'])->name('states.changeStatus');
            Route::post('states-destroyAll', [StateController::class,'massDestroy'])->name('states.massDestroy');
            /*  cities   */
            Route::resource('cities'    ,CityController::class);
            Route::get('cities-changeStatus', [CityController::class,'changeStatus'])->name('cities.changeStatus');
            Route::post('cities-destroyAll', [CityController::class,'massDestroy'])->name('cities.massDestroy');


            /*  socials   */
            Route::get('socials-changeStatus', [SocialMediaController::class,'changeStatus'])->name('socials.changeStatus');
            Route::post('socials-destroyAll', [SocialMediaController::class,'massDestroy'])->name('socials.massDestroy');
            Route::resource('socials'    ,SocialMediaController::class);
            /*  phones   */
            Route::resource('phones'    ,PhoneController::class);
            Route::get('phones-changeStatus', [PhoneController::class,'changeStatus'])->name('phones.changeStatus');
            Route::post('phones-destroyAll', [PhoneController::class,'massDestroy'])->name('phones.massDestroy');
            /*  emails   */
            Route::resource('emails'    ,EmailController::class);
            Route::get('emails-changeStatus', [EmailController::class,'changeStatus'])->name('emails.changeStatus');
            Route::post('emails-destroyAll', [EmailController::class,'massDestroy'])->name('emails.massDestroy');


            /*  about   */
            Route::resource('abouts'    ,AboutController::class);
            Route::post('ckeditor/upload', [AboutController::class, 'upload'])->name('ckeditor.upload');


            //socials
            Route::resource('contact-messages',ContactMessageController::class);
            Route::get('contact-messages-changeStatus', [ContactMessageController::class,'changeStatus'])->name('contact-messages.changeStatus');
            Route::post('contact-messages-destroyAll', [ContactMessageController::class,'massDestroy'])->name('contact-messages.massDestroy');


            //Settings
            Route::resource('logos',LogoController::class);
            Route::get('logos-changeStatus', [LogoController::class,'changeStatus'])->name('logos.changeStatus');

            Route::resource('page-titles',PageTitleController::class);
            Route::get('page-titles-changeStatus', [PageTitleController::class,'changeStatus'])->name('page-titles.changeStatus');

            Route::resource('locations',LocationController::class);
            Route::get('locations-changeStatus', [LocationController::class,'changeStatus'])->name('locations.changeStatus');

            Route::resource('working_times',WorkingTimeController::class);
            Route::get('working_times-changeStatus', [WorkingTimeController::class,'changeStatus'])->name('working_times.changeStatus');

            Route::resource('informations',InformationController::class);


            //orders
            Route::resource('orders',OrderController::class);
            Route::get('orders-show-invoice/{order}', [OrderController::class,'showInvoice'])->name('orders.showInvoice');
            Route::get('orders-changeStatus', [OrderController::class,'ordersChangeStatus'])->name('orders.changeStatus');
            Route::post('orders-destroyAll', [OrderController::class,'ordersMassDestroy'])->name('orders.massDestroy');
            Route::get('pending-orders', [OrderController::class,'pending'])->name('orders.pending');
            Route::get('accepted-orders', [OrderController::class,'accepted'])->name('orders.accepted');
            Route::get('refused-orders', [OrderController::class,'rejected'])->name('orders.refused');
            Route::get('completed-orders', [OrderController::class,'completed'])->name('orders.completed');
            Route::get('cancelled-orders', [OrderController::class,'cancelled'])->name('orders.cancelled');


        });

});
