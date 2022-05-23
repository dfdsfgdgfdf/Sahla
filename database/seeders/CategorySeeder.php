<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clothes = Category::create(['name' => 'Clothes', 'cover' => 'images/category/clothes.jpg', 'status' => true, 'parent_id' => null, 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);
        Category::create(['name' => 'Women T-shirt', 'cover' => 'images/category/womenclothes.jpg', 'status' => true, 'parent_id' => $clothes->id , 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);
        Category::create(['name' => 'Women2 T-shirt', 'cover' => 'images/category/womenclothes2.jpg', 'status' => true, 'parent_id' => $clothes->id , 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);
        Category::create(['name' => 'man T-shirt', 'cover' => 'images/category/manclothes.jpg', 'status' =>true, 'parent_id' => $clothes->id , 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);
        Category::create(['name' => 'man2 T-shirt', 'cover' => 'images/category/manclothes2.jpg', 'status' => true, 'parent_id' => $clothes->id , 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);


        $shoes = Category::create(['name' => 'shoes', 'cover' => 'images/category/shoes.jpg', 'status' => true, 'parent_id' => null, 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);
        Category::create(['name' => 'Women shoes', 'cover' => 'images/category/womenshoes.jpg', 'status' => true, 'parent_id' => $shoes->id , 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);
        Category::create(['name' => 'Women2 shoes', 'cover' => 'images/category/womenshoes2.jpg', 'status' => true, 'parent_id' => $shoes->id , 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);
        Category::create(['name' => 'Man shoes', 'cover' => 'images/category/manshoes.jpg', 'status' => true, 'parent_id' => $shoes->id , 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);
        Category::create(['name' => 'Man2 shoes', 'cover' => 'images/category/manshoes2.jpg', 'status' => true, 'parent_id' => $shoes->id , 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);


        $watches = Category::create(['name' => 'Watches', 'cover' => 'images/category/watches.jpg', 'status' => true, 'parent_id' => null, 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);
        Category::create(['name' => 'Women Watch', 'cover' => 'images/category/womenwatches.jpg', 'status' => true, 'parent_id' => $watches->id , 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);
        Category::create(['name' => 'Women2 Watch', 'cover' => 'images/category/womenwatches2.jpg', 'status' => true, 'parent_id' => $watches->id , 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);
        Category::create(['name' => 'man Watch', 'cover' => 'images/category/manwatches.jpg', 'status' => true, 'parent_id' => $watches->id , 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);
        Category::create(['name' => 'man2 Watch', 'cover' => 'images/category/manwatches2.jpg', 'status' => true, 'parent_id' => $watches->id , 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);

        $electronics = Category::create(['name' => 'electronics', 'cover' => 'images/category/electronics.jpg', 'status' => true, 'parent_id' => null, 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);
        Category::create(['name' => 'Women Electronics', 'cover' => 'images/category/electronics.jpg', 'status' => true, 'parent_id' => $electronics->id , 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);
        Category::create(['name' => 'Women2 Electronics', 'cover' => 'images/category/electronics.jpg', 'status' => true, 'parent_id' => $electronics->id , 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);
        Category::create(['name' => 'man Electronics', 'cover' => 'images/category/electronics.jpg', 'status' => true, 'parent_id' => $electronics->id , 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);
        Category::create(['name' => 'man2 Electronics', 'cover' => 'images/category/electronics.jpg', 'status' => true, 'parent_id' => $electronics->id , 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);


    }
}
