<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\UserMaxLimit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory;

class EntrustSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();


        $superAdminRole     = Role::create(['name' => 'superAdmin',  'display_name' => 'Administrator',  'description' => 'System Administrator', 'allowed_route' => 'admin']);
        $adminRole          = Role::create(['name' => 'admin',       'display_name' => 'admin',          'description' => 'System Admin',         'allowed_route' => 'admin']);
        $userRole           = Role::create(['name' => 'user',        'display_name' => 'User',           'description' => 'System User',          'allowed_route' => 'admin']);
        $customerRole       = Role::create(['name' => 'customer',    'display_name' => 'Customer',       'description' => 'Website Customer',     'allowed_route' => null   ]);
        $merchantRole       = Role::create(['name' => 'merchant',    'display_name' => 'Merchant',       'description' => 'Website Merchant',     'allowed_route' => null   ]);

        $superAdmin = User::create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'username' => 'System Administrator',
            'email' => 'superAdmin@superAdmin.com',
            'mobile' => '01234567890',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('password'),
            'user_image'=>'images/user/avatar.png',
            'remember_token' => Str::random(10),
        ]);
        $superAdmin->attachRole($superAdminRole);

        $superAdmin = User::create([
            'first_name' => 'Sahla',
            'last_name' => 'Admin',
            'username' => 'Sahla System Administrator',
            'email' => 'sahlaAdmin@sahlaAdmin.com',
            'mobile' => '01236667890',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('password'),
            'user_image'=>'images/user/avatar.png',
            'remember_token' => Str::random(10),
        ]);
        $superAdmin->attachRole($superAdminRole);


        $admin = User::create([
            'first_name' => 'Admin',
            'last_name' => 'System',
            'username' => 'System Admin',
            'email' => 'admin@admin.com',
            'mobile' => '01234567880',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('password'),
            'user_image'=>'images/user/avatar.png',
            'remember_token' => Str::random(10),
        ]);
        $admin->attachRole($adminRole);


        $user = User::create([
            'first_name' => 'User',
            'last_name' => 'System',
            'username' => 'System User',
            'email' => 'user@user.com',
            'mobile' => '01234567800',
            'password' => bcrypt('password'),
            'email_verified_at' => Carbon::now(),
            'user_image'=>'images/user/avatar.png',
            'remember_token' => Str::random(10),
        ]);
        $user->attachRole($userRole);

        $user1 = User::create(['first_name' => 'Mohamed',   'last_name' => 'Farh',      'username' => 'Mohamed Farh',       'email' => 'mohamed@yahoo.com',         'mobile' => '01234567799','status'=> 1, 'password' => bcrypt('password'),'email_verified_at' => Carbon::now(), 'user_image'=>'images/customer/avatar.png', 'remember_token' => Str::random(10), ]);
        $user1->attachRole($merchantRole);
        UserMaxLimit::create(['user_id' => $user1->id, 'max_limit'   => $faker->numberBetween(10000, 20000), 'status'  => 1 ]);

        $user2 = User::create([ 'first_name' => 'Customer', 'last_name' => 'Customer',  'username' => 'Customer Customer',  'email' => 'customer@customer.com',     'mobile' => '01234567999','status'=> 1, 'password' => bcrypt('password'),'email_verified_at' => Carbon::now(), 'user_image'=>'images/customer/avatar.png', 'remember_token' => Str::random(10), ]);
        $user2->attachRole($customerRole);
        UserMaxLimit::create(['user_id' => $user2->id, 'max_limit'   => $faker->numberBetween(10000, 20000), 'status'  => 1 ]);

        $user3 = User::create(['first_name' => 'Merchant',  'last_name' => 'Merchant',  'username' => 'Merchant Merchant',  'email' => 'merchant@merchant.com',     'mobile' => '01234567699','status'=> 1, 'password' => bcrypt('password'),'email_verified_at' => Carbon::now(), 'user_image'=>'images/customer/avatar.png', 'remember_token' => Str::random(10), ]);
        $user3->attachRole($merchantRole);
        UserMaxLimit::create(['user_id' => $user3->id, 'max_limit'   => $faker->numberBetween(10000, 20000), 'status'  => 1 ]);

        for ($i = 0; $i <10; $i++) {
            $user_merchant = User::create([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'username' => $faker->userName,
                'email' => $faker->email,
                'mobile' => '9665' . random_int(10000000, 99999999),
                'email_verified_at' => Carbon::now(),
                'password' => bcrypt('password'),
                'user_image'=>'images/merchant/avatar.png',
                'status'=> 1,
                'remember_token' => Str::random(10),
            ]);
            $user_merchant->attachRole($merchantRole);
            UserMaxLimit::create([
                'user_id' => $user_merchant->id,
                'max_limit'   => $faker->numberBetween(10000, 20000),
                'status'  => 1,
            ]);
        }

        for ($i = 0; $i <10; $i++) {
            $user_customer = User::create([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'username' => $faker->userName,
                'email' => $faker->email,
                'mobile' => '9665' . random_int(10000000, 99999999),
                'email_verified_at' => Carbon::now(),
                'password' => bcrypt('password'),
                'user_image'=>'images/customer/avatar.png',
                'status'=> 1,
                'remember_token' => Str::random(10),
            ]);
            $user_customer->attachRole($customerRole);
            UserMaxLimit::create([
                'user_id'   => $user_customer->id,
                'max_limit' => $faker->numberBetween(10000, 20000),
                'status'    => 1,
            ]);
        }





        // MAIN
        $manageMain = Permission::create([
            'name' => 'main',
            'display_name' => 'الرئيسية',
            'description' => 'Administrator Dashboard',
            'route' => 'index',
            'module' => 'index',
            'as' => 'index',
            'icon' => 'fa fa-home text-blue',
            'parent' => '0',
            'parent_original' => '0',
            'sidebar_link' => '1',
            'appear' => '1',
            'ordering' => '1',
        ]);
        $manageMain->parent_show = $manageMain->id;
        $manageMain->save();


        // Admins
        $manageAdmins = Permission::create([ 'name' => 'manage_admins', 'display_name' => 'الأدمن', 'route' => 'admins.index', 'module' => 'admins', 'as' => 'admins.index', 'icon' => 'fas fa-user-shield text-blue', 'parent' => '0', 'parent_original' => '0','sidebar_link' => '0', 'appear' => '1', 'ordering' => '200', ]);
        $manageAdmins->parent_show = $manageAdmins->id;
        $manageAdmins->save();
        $showAdmins    = Permission::create([ 'name' => 'show_admins',          'display_name' => 'الأدمن',              'route' => 'admins.index',          'module' => 'admins', 'as' => 'admins.index',       'icon' => 'fas fa-user-shield text-blue',  'parent' => $manageAdmins->id, 'parent_show' => $manageAdmins->id, 'parent_original' => $manageAdmins->id,'sidebar_link' => '0', 'appear' => '1', ]);
        $createAdmins  = Permission::create([ 'name' => 'create_admins',        'display_name' => 'انشاء ادمن',       'route' => 'admins.create',         'module' => 'admins', 'as' => 'admins.create',      'icon' => null,                  'parent' => $manageAdmins->id, 'parent_show' => $manageAdmins->id, 'parent_original' => $manageAdmins->id,'sidebar_link' => '0', 'appear' => '0', ]);
        $updateAdmins  = Permission::create([ 'name' => 'update_admins',        'display_name' => 'تعديل ادمن',       'route' => 'admins.edit',           'module' => 'admins', 'as' => 'admins.edit',        'icon' => null,                  'parent' => $manageAdmins->id, 'parent_show' => $manageAdmins->id, 'parent_original' => $manageAdmins->id,'sidebar_link' => '0', 'appear' => '0', ]);
        $destroyAdmins = Permission::create([ 'name' => 'delete_admins',        'display_name' => 'حذف ادمن',       'route' => 'admins.destroy',        'module' => 'admins', 'as' => 'admins.destroy',     'icon' => null,                  'parent' => $manageAdmins->id, 'parent_show' => $manageAdmins->id, 'parent_original' => $manageAdmins->id,'sidebar_link' => '0', 'appear' => '0', ]);

        // Users
        $manageUsers = Permission::create([ 'name' => 'manage_users', 'display_name' => 'المستخدمين', 'route' => 'users.index', 'module' => 'users', 'as' => 'users.index', 'icon' => 'fas fa-users text-blue', 'parent' => '0', 'parent_original' => '0','sidebar_link' => '0', 'appear' => '1', 'ordering' => '210', ]);
        $manageUsers->parent_show = $manageUsers->id;
        $manageUsers->save();
        $showUsers    = Permission::create([ 'name' => 'show_users',          'display_name' => 'المستخدمين',              'route' => 'users.index',          'module' => 'users', 'as' => 'users.index',       'icon' => 'fas fa-users text-blue',        'parent' => $manageUsers->id, 'parent_show' => $manageUsers->id, 'parent_original' => $manageUsers->id,'sidebar_link' => '0', 'appear' => '1', ]);
        $createUsers  = Permission::create([ 'name' => 'create_users',        'display_name' => 'انشاء مستخدم',       'route' => 'users.create',         'module' => 'users', 'as' => 'users.create',      'icon' => null,                  'parent' => $manageUsers->id, 'parent_show' => $manageUsers->id, 'parent_original' => $manageUsers->id,'sidebar_link' => '0', 'appear' => '0', ]);
        $updateUsers  = Permission::create([ 'name' => 'update_users',        'display_name' => 'تعديل مستخدم',       'route' => 'users.edit',           'module' => 'users', 'as' => 'users.edit',        'icon' => null,                  'parent' => $manageUsers->id, 'parent_show' => $manageUsers->id, 'parent_original' => $manageUsers->id,'sidebar_link' => '0', 'appear' => '0', ]);
        $destroyUsers = Permission::create([ 'name' => 'delete_users',        'display_name' => 'حذف مستخدم',       'route' => 'users.destroy',        'module' => 'users', 'as' => 'users.destroy',     'icon' => null,                  'parent' => $manageUsers->id, 'parent_show' => $manageUsers->id, 'parent_original' => $manageUsers->id,'sidebar_link' => '0', 'appear' => '0', ]);

        //Categories
        $manageCategories = Permission::create([ 'name' => 'manage_categories', 'display_name' => 'أنواع الخدمات (الأقسام)', 'route' => 'categories.index', 'module' => 'categories', 'as' => 'categories.index', 'icon' => 'fas fa-th-large text-blue', 'parent' => '0', 'parent_original' => '0','sidebar_link' => '1', 'appear' => '1', 'ordering' => '5', ]);
        $manageCategories->parent_show = $manageCategories->id;
        $manageCategories->save();
        $showCategories    = Permission::create([ 'name' => 'show_categories',          'display_name' => 'الأقسام',       'route' => 'categories.index',          'module' => 'categories', 'as' => 'categories.index',       'icon' => 'fas fa-th',          'parent' => $manageCategories->id, 'parent_show' => $manageCategories->id, 'parent_original' => $manageCategories->id,'sidebar_link' => '1', 'appear' => '1', ]);


        //Products
        $manageProducts = Permission::create([ 'name' => 'manage_products', 'display_name' => 'المنتجات', 'route' => 'products.index', 'module' => 'products', 'as' => 'products.index', 'icon' => 'fas fa-tshirt text-blue', 'parent' => '0', 'parent_original' => '0','sidebar_link' => '1', 'appear' => '1', 'ordering' => '15', ]);
        $manageProducts->parent_show = $manageProducts->id;
        $manageProducts->save();
        $showProducts    = Permission::create([ 'name' => 'show_products',          'display_name' => 'المنتجات',             'route' => 'products.index',          'module' => 'products', 'as' => 'products.index',       'icon' => 'fas fa-tshirt',       'parent' => $manageProducts->id, 'parent_show' => $manageProducts->id, 'parent_original' => $manageProducts->id,'sidebar_link' => '1', 'appear' => '1', ]);
        $createProducts  = Permission::create([ 'name' => 'create_products',        'display_name' => 'انشاء منتج',      'route' => 'products.create',         'module' => 'products', 'as' => 'products.create',      'icon' => null,                  'parent' => $manageProducts->id, 'parent_show' => $manageProducts->id, 'parent_original' => $manageProducts->id,'sidebar_link' => '1', 'appear' => '0', ]);
        $updateProducts  = Permission::create([ 'name' => 'update_products',        'display_name' => 'تعديل منتج',      'route' => 'products.edit',           'module' => 'products', 'as' => 'products.edit',        'icon' => null,                  'parent' => $manageProducts->id, 'parent_show' => $manageProducts->id, 'parent_original' => $manageProducts->id,'sidebar_link' => '1', 'appear' => '0', ]);
        $destroyProducts = Permission::create([ 'name' => 'delete_products',        'display_name' => 'حذف منتج',      'route' => 'products.destroy',        'module' => 'products', 'as' => 'products.destroy',     'icon' => null,                  'parent' => $manageProducts->id, 'parent_show' => $manageProducts->id, 'parent_original' => $manageProducts->id,'sidebar_link' => '1', 'appear' => '0', ]);
            ## Product Reviews ##
            $showProductReviews     = Permission::create([ 'name' => 'show_productReviews',     'display_name' => 'تقييمات المنتجات',   'route' => 'productReviews.index',  'module' => 'products', 'as' => 'productReviews.index',     'icon' => 'fas fa-comments',              'parent' => $manageProducts->id, 'parent_show' => $manageProducts->id, 'parent_original' => $manageProducts->id,'sidebar_link' => '1', 'appear' => '1', ]);
            ## Product Units ##
            $showunits       = Permission::create([ 'name' => 'show_units',       'display_name' => 'أوزان المنتجات',     'route' => 'units.index',    'module' => 'products', 'as' => 'units.index',       'icon' => 'fas fa-balance-scale-left',    'parent' => $manageProducts->id, 'parent_show' => $manageProducts->id, 'parent_original' => $manageProducts->id,'sidebar_link' => '1', 'appear' => '1', ]);


        //Order
        $manageOrders = Permission::create([ 'name' => 'manage_orders', 'display_name' => 'الطلبات', 'route' => 'orders.index', 'module' => 'orders', 'as' => 'orders.index', 'icon' => 'fas fa-shopping-bag text-blue', 'parent' => '0', 'parent_original' => '0','sidebar_link' => '1', 'appear' => '1', 'ordering' => '20', ]);
        $manageOrders->parent_show = $manageOrders->id;
        $manageOrders->save();
        #####
        $pendingOrders      = Permission::create([ 'name' => 'show_pending_orders',     'display_name' => 'الطلبات المعلقة',        'route' => 'orders.pending',            'module' => 'orders',     'as' => 'orders.pending',     'icon' => 'fas fa-bullhorn',                    'parent' => $manageOrders->id, 'parent_show' => $manageOrders->id, 'parent_original' => $manageOrders->id,'sidebar_link' => '1', 'appear' => '1', ]);
        #####
        $AcceptedOrders     = Permission::create([ 'name' => 'show_accepted_orders',    'display_name' => 'الطلبات الموافق عليها',  'route' => 'orders.accepted',           'module' => 'orders',     'as' => 'orders.accepted',    'icon' => 'fas fa-shopping-basket',             'parent' => $manageOrders->id, 'parent_show' => $manageOrders->id, 'parent_original' => $manageOrders->id,'sidebar_link' => '1', 'appear' => '1', ]);
        #####
        $CompletedOrders    = Permission::create([ 'name' => 'show_completed_orders',   'display_name' => 'الطلبات المكتملة',       'route' => 'orders.completed',          'module' => 'orders',     'as' => 'orders.completed',   'icon' => 'fas fa-shopping-bag',                'parent' => $manageOrders->id, 'parent_show' => $manageOrders->id, 'parent_original' => $manageOrders->id,'sidebar_link' => '1', 'appear' => '1', ]);
        #####
        $pendingInvoices    = Permission::create([ 'name' => 'show_pending_invoices',   'display_name' => 'الفواتير المعلقة',        'route' => 'orders.pendingInvoices',   'module' => 'orders',     'as' => 'orders.pendingInvoices',     'icon' => 'fas fa-clipboard',           'parent' => $manageOrders->id, 'parent_show' => $manageOrders->id, 'parent_original' => $manageOrders->id,'sidebar_link' => '1', 'appear' => '1', ]);
        #####
        $CompletedInvoices  = Permission::create([ 'name' => 'show_completed_invoices', 'display_name' => 'الفواتير المكتملة',       'route' => 'orders.completedInvoices', 'module' => 'orders',     'as' => 'orders.completedInvoices',   'icon' => 'fas fa-file-invoice-dollar', 'parent' => $manageOrders->id, 'parent_show' => $manageOrders->id, 'parent_original' => $manageOrders->id,'sidebar_link' => '1', 'appear' => '1', ]);
//        #####
//        $RefusedOrders      = Permission::create([ 'name' => 'show_refused_orders',     'display_name' => 'الطلبات المرفوضة',       'route' => 'orders.refused',        'module' => 'orders',     'as' => 'orders.refused',     'icon' => 'fas fa-cart-arrow-down',     'parent' => $manageOrders->id, 'parent_show' => $manageOrders->id, 'parent_original' => $manageOrders->id,'sidebar_link' => '1', 'appear' => '1', ]);
//        #####
//        $CanclledOrders     = Permission::create([ 'name' => 'show_cancelled_orders',    'display_name' => 'الطلبات الملغاة',        'route' => 'orders.cancelled',      'module' => 'orders',     'as' => 'orders.cancelled',   'icon' => 'fas fa-window-close',        'parent' => $manageOrders->id, 'parent_show' => $manageOrders->id, 'parent_original' => $manageOrders->id,'sidebar_link' => '1', 'appear' => '1', ]);


        //Merchants
        $manageMerchants = Permission::create([ 'name' => 'manage_merchants', 'display_name' => 'التجار', 'route' => 'merchants.index', 'module' => 'merchants', 'as' => 'merchants.index', 'icon' => 'fas fa-people-arrows text-blue', 'parent' => '0', 'parent_original' => '0','sidebar_link' => '1', 'appear' => '1', 'ordering' => '35', ]);
        $manageMerchants->parent_show = $manageMerchants->id;
        $manageMerchants->save();
        $showMerchants    = Permission::create([ 'name' => 'show_merchants',          'display_name' => 'التجار',       'route' => 'merchants.index',          'module' => 'merchants', 'as' => 'merchants.index',       'icon' => 'fas fa-people-arrows',         'parent' => $manageMerchants->id, 'parent_show' => $manageMerchants->id, 'parent_original' => $manageMerchants->id,'sidebar_link' => '1', 'appear' => '1', ]);
        $createMerchants  = Permission::create([ 'name' => 'create_merchants',        'display_name' => 'انشاء تاجر',   'route' => 'merchants.create',         'module' => 'merchants', 'as' => 'merchants.create',      'icon' => null,                  'parent' => $manageMerchants->id, 'parent_show' => $manageMerchants->id, 'parent_original' => $manageMerchants->id,'sidebar_link' => '1', 'appear' => '0', ]);
        $updateMerchants  = Permission::create([ 'name' => 'update_merchants',        'display_name' => 'تعديل تاجر',   'route' => 'merchants.edit',           'module' => 'merchants', 'as' => 'merchants.edit',        'icon' => null,                  'parent' => $manageMerchants->id, 'parent_show' => $manageMerchants->id, 'parent_original' => $manageMerchants->id,'sidebar_link' => '1', 'appear' => '0', ]);
        $destroyMerchants = Permission::create([ 'name' => 'delete_merchants',        'display_name' => 'حذف تاجر',     'route' => 'merchants.destroy',        'module' => 'merchants', 'as' => 'merchants.destroy',     'icon' => null,                  'parent' => $manageMerchants->id, 'parent_show' => $manageMerchants->id, 'parent_original' => $manageMerchants->id,'sidebar_link' => '1', 'appear' => '0', ]);
        #####
        $pendingOrders      = Permission::create([ 'name' => 'show_merchants_pending_orders',     'display_name' => 'الطلبات المعلقة',        'route' => 'merchant_orders.pending',        'module' => 'merchants',     'as' => 'merchant_orders.pending',     'icon' => 'fas fa-bullhorn',            'parent' => $manageMerchants->id, 'parent_show' => $manageMerchants->id, 'parent_original' => $manageMerchants->id,'sidebar_link' => '1', 'appear' => '1', ]);
        #####
        $AcceptedOrders     = Permission::create([ 'name' => 'show_merchants_accepted_orders',    'display_name' => 'الطلبات الموافق عليها',  'route' => 'merchant_orders.accepted',       'module' => 'merchants',     'as' => 'merchant_orders.accepted',    'icon' => 'fas fa-shopping-basket',     'parent' => $manageMerchants->id, 'parent_show' => $manageMerchants->id, 'parent_original' => $manageMerchants->id,'sidebar_link' => '1', 'appear' => '1', ]);
        #####
        $CompletedOrders    = Permission::create([ 'name' => 'show_merchants_completed_orders',   'display_name' => 'الطلبات المكتملة',       'route' => 'merchant_orders.completed',      'module' => 'merchants',     'as' => 'merchant_orders.completed',   'icon' => 'fas fa-shopping-bag',        'parent' => $manageMerchants->id, 'parent_show' => $manageMerchants->id, 'parent_original' => $manageMerchants->id,'sidebar_link' => '1', 'appear' => '1', ]);
        #####
        $pendingInvoices    = Permission::create([ 'name' => 'show_merchants_pending_invoices',   'display_name' => 'الفواتير المعلقة',        'route' => 'merchant_orders.pendingInvoices',   'module' => 'merchants',     'as' => 'merchant_orders.pendingInvoices',     'icon' => 'fas fa-clipboard',           'parent' => $manageMerchants->id, 'parent_show' => $manageMerchants->id, 'parent_original' => $manageMerchants->id,'sidebar_link' => '1', 'appear' => '1', ]);
        #####
        $CompletedInvoices  = Permission::create([ 'name' => 'show_merchants_completed_invoices', 'display_name' => 'الفواتير المكتملة',       'route' => 'merchant_orders.completedInvoices', 'module' => 'merchants',     'as' => 'merchant_orders.completedInvoices',   'icon' => 'fas fa-file-invoice-dollar', 'parent' => $manageMerchants->id, 'parent_show' => $manageMerchants->id, 'parent_original' => $manageMerchants->id,'sidebar_link' => '1', 'appear' => '1', ]);
//        #####
//        $RefusedOrders      = Permission::create([ 'name' => 'show_merchants_refused_orders',     'display_name' => 'الطلبات المرفوضة',       'route' => 'merchant_orders.refused',        'module' => 'merchants',     'as' => 'merchant_orders.refused',     'icon' => 'fas fa-cart-arrow-down',     'parent' => $manageMerchants->id, 'parent_show' => $manageMerchants->id, 'parent_original' => $manageMerchants->id,'sidebar_link' => '1', 'appear' => '1', ]);
//        #####
//        $CanclledOrders     = Permission::create([ 'name' => 'show_merchants_cancelled_orders',    'display_name' => 'الطلبات الملغاة',        'route' => 'merchant_orders.cancelled',      'module' => 'merchants',     'as' => 'merchant_orders.cancelled',   'icon' => 'fas fa-window-close',        'parent' => $manageMerchants->id, 'parent_show' => $manageMerchants->id, 'parent_original' => $manageMerchants->id,'sidebar_link' => '1', 'appear' => '1', ]);


        //Customers
        $manageCustomers = Permission::create([ 'name' => 'manage_customers', 'display_name' => 'العملاء', 'route' => 'customers.index', 'module' => 'customers', 'as' => 'customers.index', 'icon' => 'fas fa-user text-blue', 'parent' => '0', 'parent_original' => '0','sidebar_link' => '1', 'appear' => '1', 'ordering' => '35', ]);
        $manageCustomers->parent_show = $manageCustomers->id;
        $manageCustomers->save();
        $showCustomers    = Permission::create([ 'name' => 'show_customers',          'display_name' => 'العملاء',       'route' => 'customers.index',          'module' => 'customers', 'as' => 'customers.index',       'icon' => 'fas fa-user',         'parent' => $manageCustomers->id, 'parent_show' => $manageCustomers->id, 'parent_original' => $manageCustomers->id,'sidebar_link' => '1', 'appear' => '1', ]);
        $createCustomers  = Permission::create([ 'name' => 'create_customers',        'display_name' => 'انشاء عميل',   'route' => 'customers.create',         'module' => 'customers', 'as' => 'customers.create',      'icon' => null,                  'parent' => $manageCustomers->id, 'parent_show' => $manageCustomers->id, 'parent_original' => $manageCustomers->id,'sidebar_link' => '1', 'appear' => '0', ]);
        $updateCustomers  = Permission::create([ 'name' => 'update_customers',        'display_name' => 'تعديل عميل',   'route' => 'customers.edit',           'module' => 'customers', 'as' => 'customers.edit',        'icon' => null,                  'parent' => $manageCustomers->id, 'parent_show' => $manageCustomers->id, 'parent_original' => $manageCustomers->id,'sidebar_link' => '1', 'appear' => '0', ]);
        $destroyCustomers = Permission::create([ 'name' => 'delete_customers',        'display_name' => 'حذف عميل',     'route' => 'customers.destroy',        'module' => 'customers', 'as' => 'customers.destroy',     'icon' => null,                  'parent' => $manageCustomers->id, 'parent_show' => $manageCustomers->id, 'parent_original' => $manageCustomers->id,'sidebar_link' => '1', 'appear' => '0', ]);
        #####
        $pendingOrders      = Permission::create([ 'name' => 'show_customers_pending_orders',     'display_name' => 'الطلبات المعلقة',        'route' => 'customer_orders.pending',        'module' => 'customers',     'as' => 'customer_orders.pending',     'icon' => 'fas fa-bullhorn',            'parent' => $manageCustomers->id, 'parent_show' => $manageCustomers->id, 'parent_original' => $manageCustomers->id,'sidebar_link' => '1', 'appear' => '1', ]);
        #####
        $AcceptedOrders     = Permission::create([ 'name' => 'show_customers_accepted_orders',    'display_name' => 'الطلبات الموافق عليها',  'route' => 'customer_orders.accepted',       'module' => 'customers',     'as' => 'customer_orders.accepted',    'icon' => 'fas fa-shopping-basket',     'parent' => $manageCustomers->id, 'parent_show' => $manageCustomers->id, 'parent_original' => $manageCustomers->id,'sidebar_link' => '1', 'appear' => '1', ]);
        #####
        $CompletedOrders    = Permission::create([ 'name' => 'show_customers_completed_orders',   'display_name' => 'الطلبات المكتملة',       'route' => 'customer_orders.completed',      'module' => 'customers',     'as' => 'customer_orders.completed',   'icon' => 'fas fa-shopping-bag',        'parent' => $manageCustomers->id, 'parent_show' => $manageCustomers->id, 'parent_original' => $manageCustomers->id,'sidebar_link' => '1', 'appear' => '1', ]);
        #####
        $pendingInvoices    = Permission::create([ 'name' => 'show_customers_pending_invoices',   'display_name' => 'الفواتير المعلقة',        'route' => 'customer_orders.pendingInvoices',   'module' => 'customers',     'as' => 'customer_orders.pendingInvoices',     'icon' => 'fas fa-clipboard',           'parent' => $manageCustomers->id, 'parent_show' => $manageCustomers->id, 'parent_original' => $manageCustomers->id,'sidebar_link' => '1', 'appear' => '1', ]);
        #####
        $CompletedInvoices  = Permission::create([ 'name' => 'show_customers_completed_invoices', 'display_name' => 'الفواتير المكتملة',       'route' => 'customer_orders.completedInvoices', 'module' => 'customers',     'as' => 'customer_orders.completedInvoices',   'icon' => 'fas fa-file-invoice-dollar', 'parent' => $manageCustomers->id, 'parent_show' => $manageCustomers->id, 'parent_original' => $manageCustomers->id,'sidebar_link' => '1', 'appear' => '1', ]);
//        #####
//        $RefusedOrders      = Permission::create([ 'name' => 'show_customers_refused_orders',     'display_name' => 'الطلبات المرفوضة',       'route' => 'customer_orders.refused',        'module' => 'customers',     'as' => 'customer_orders.refused',     'icon' => 'fas fa-cart-arrow-down',     'parent' => $manageCustomers->id, 'parent_show' => $manageCustomers->id, 'parent_original' => $manageCustomers->id,'sidebar_link' => '1', 'appear' => '1', ]);
//        #####
//        $CanclledOrders     = Permission::create([ 'name' => 'show_customers_cancelled_orders',    'display_name' => 'الطلبات الملغاة',        'route' => 'customer_orders.cancelled',      'module' => 'customers',     'as' => 'customer_orders.cancelled',   'icon' => 'fas fa-window-close',        'parent' => $manageCustomers->id, 'parent_show' => $manageCustomers->id, 'parent_original' => $manageCustomers->id,'sidebar_link' => '1', 'appear' => '1', ]);


        //Countries
        $manageCountries = Permission::create([ 'name' => 'manage_countries', 'display_name' => 'الدول', 'route' => 'countries.index', 'module' => 'countries', 'as' => 'countries.index', 'icon' => 'fas fa-globe text-blue', 'parent' => '0', 'parent_original' => '0','sidebar_link' => '1', 'appear' => '1', 'ordering' => '100', ]);
        $manageCountries->parent_show = $manageCountries->id;
        $manageCountries->save();
        $showCountries    = Permission::create([ 'name' => 'show_countries',          'display_name' => 'الدول',              'route' => 'countries.index',          'module' => 'countries', 'as' => 'countries.index',       'icon' => 'fas fa-globe',        'parent' => $manageCountries->id, 'parent_show' => $manageCountries->id, 'parent_original' => $manageCountries->id,'sidebar_link' => '1', 'appear' => '1', ]);
        //States
        $showStates    = Permission::create([ 'name' => 'show_states',          'display_name' => 'المحافظات',              'route' => 'states.index',          'module' => 'countries', 'as' => 'states.index',       'icon' => 'fas fa-map-marker-alt', 'parent' => $manageCountries->id, 'parent_show' => $manageCountries->id, 'parent_original' => $manageCountries->id,'sidebar_link' => '1', 'appear' => '1', ]);
        //Cities
        $showCities    = Permission::create([ 'name' => 'show_cities',          'display_name' => 'المدن',              'route' => 'cities.index',          'module' => 'countries', 'as' => 'cities.index',       'icon' => 'fas fa-university',   'parent' => $manageCountries->id, 'parent_show' => $manageCountries->id, 'parent_original' => $manageCountries->id,'sidebar_link' => '1', 'appear' => '1', ]);


        //Contact
        $manageContacts = Permission::create([ 'name' => 'manage_contacts', 'display_name' => 'الاتصال', 'route' => 'socials.index', 'module' => 'socials', 'as' => 'socials.index', 'icon' => 'fas fa-mobile-alt text-blue', 'parent' => '0', 'parent_original' => '0','sidebar_link' => '1', 'appear' => '1', 'ordering' => '115', ]);
        $manageContacts->parent_show = $manageContacts->id;
        $manageContacts->save();
            ##Social Media
            $showSocials    = Permission::create([ 'name' => 'show_social', 'display_name' => 'وسائل التواصل الاجتماعي',   'route' => 'socials.index',     'module' => 'socials',     'as' => 'socials.index',    'icon' => 'fas fa-thumbs-up',           'parent' => $manageContacts->id, 'parent_show' => $manageContacts->id, 'parent_original' => $manageContacts->id,'sidebar_link' => '1', 'appear' => '1', ]);
            ##Phone Number
            $showPhones     = Permission::create([ 'name' => 'show_phone',  'display_name' => 'الموبيل',         'route' => 'phones.index',      'module' => 'socials',     'as' => 'phones.index',     'icon' => 'fas fa-phone-square-alt',    'parent' => $manageContacts->id, 'parent_show' => $manageContacts->id, 'parent_original' => $manageContacts->id,'sidebar_link' => '1', 'appear' => '1', ]);
            ##E_Mail
            $showEmails     = Permission::create([ 'name' => 'show_email',  'display_name' => 'البريد الالكتروني',        'route' => 'emails.index',      'module' => 'socials',     'as' => 'emails.index',     'icon' => 'fas fa-envelope-open-text',  'parent' => $manageContacts->id, 'parent_show' => $manageContacts->id, 'parent_original' => $manageContacts->id,'sidebar_link' => '1', 'appear' => '1', ]);

        //
        $manageContactUs = Permission::create([ 'name' => 'manage_contactUs_messages', 'display_name' => 'رسائل (تواصل معنا)', 'route' => 'contact-messages.index', 'module' => 'contact-messages', 'as' => 'contact-messages.index', 'icon' => 'fas fa-sms text-blue', 'parent' => '0', 'parent_original' => '0','sidebar_link' => '1', 'appear' => '1', 'ordering' => '120', ]);
        $manageContactUs->parent_show = $manageContactUs->id;
        $manageContactUs->save();
            $showMessages    = Permission::create([ 'name' => 'show__contactUs_messages', 'display_name' => 'الرسائل',   'route' => 'contact-messages.index',     'module' => 'contact-messages',     'as' => 'contact-messages.index',    'icon' => 'fas fa-sms',           'parent' => $manageContactUs->id, 'parent_show' => $manageContactUs->id, 'parent_original' => $manageContactUs->id,'sidebar_link' => '1', 'appear' => '1', ]);


        //Settings
        $manageSettings = Permission::create([ 'name' => 'manage_settings', 'display_name' => 'الإعدادات', 'route' => 'logos.index', 'module' => 'settings', 'as' => 'logos.index', 'icon' => 'fas fa-cogs text-blue', 'parent' => '0', 'parent_original' => '0','sidebar_link' => '1', 'appear' => '1', 'ordering' => '125', ]);
        $manageSettings->parent_show = $manageSettings->id;
        $manageSettings->save();
//            ##Logo
//            $showLogo           = Permission::create([ 'name' => 'show_logo',           'display_name' => 'لوجو الموقع',    'route' => 'logos.index',           'module' => 'settings',     'as' => 'logos.index',          'icon' => 'fas fa-paint-brush',     'parent' => $manageSettings->id, 'parent_show' => $manageSettings->id, 'parent_original' => $manageSettings->id,'sidebar_link' => '1', 'appear' => '1', ]);

//            ##Pages Titles
//            $showPages          = Permission::create([ 'name' => 'show_page_title',     'display_name' => 'نصوص العناوين',  'route' => 'page-titles.index',     'module' => 'settings',     'as' => 'page-titles.index',    'icon' => 'fas fa-heading',         'parent' => $manageSettings->id, 'parent_show' => $manageSettings->id, 'parent_original' => $manageSettings->id,'sidebar_link' => '1', 'appear' => '1', ]);

//            ##WorkingTimes
//            $showWorkingTimes   = Permission::create([ 'name' => 'show_working_times',  'display_name' => 'ساعات العمل',    'route' => 'working_times.index',   'module' => 'settings',     'as' => 'working_times.index',  'icon' => 'fas fa-clock',           'parent' => $manageSettings->id, 'parent_show' => $manageSettings->id, 'parent_original' => $manageSettings->id,'sidebar_link' => '1', 'appear' => '1', ]);

//            ##Locations
//            $showLocations      = Permission::create([ 'name' => 'show_locations',      'display_name' => 'موقع الشركة',    'route' => 'locations.index',       'module' => 'settings',     'as' => 'locations.index',      'icon' => 'fas fa-map-marker-alt',  'parent' => $manageSettings->id, 'parent_show' => $manageSettings->id, 'parent_original' => $manageSettings->id,'sidebar_link' => '1', 'appear' => '1', ]);

            ##AppStartPage
            $showAppStartPages   = Permission::create([ 'name' => 'show_app_start_pages',    'display_name' => 'صفحات البداية للتطبيق',        'route' => 'appStartPages.index',    'module' => 'settings',     'as' => 'appStartPages.index',   'icon' => 'fas fa-pager',        'parent' => $manageSettings->id, 'parent_show' => $manageSettings->id, 'parent_original' => $manageSettings->id,'sidebar_link' => '1', 'appear' => '1', ]);

            ##Informations
            $showInformations   = Permission::create([ 'name' => 'show_information',    'display_name' => 'معلومات التطبيق',        'route' => 'informations.index',    'module' => 'settings',     'as' => 'informations.index',   'icon' => 'fas fa-info-circle',        'parent' => $manageSettings->id, 'parent_show' => $manageSettings->id, 'parent_original' => $manageSettings->id,'sidebar_link' => '1', 'appear' => '1', ]);














    }
}
