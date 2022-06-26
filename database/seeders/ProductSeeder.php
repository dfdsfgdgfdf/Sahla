<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductUnit;
use App\Models\Unit;
use Illuminate\Database\Seeder;

use Faker\Factory;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $categories = Category::whereNotNull('parent_id')->pluck('id');
        $units = Unit::pluck('id');

        for ($i = 1; $i <1000; $i++) {
            $products[] =[
                'name_ar'              => $faker->sentence(2, true),
                'name_en'              => $faker->sentence(2, true),
                'name_ur'              => $faker->sentence(2, true),
                'slug'              => $faker->unique()->slug(2, true),
                'description_ar'        => $faker->paragraph(),
                'description_en'        => $faker->paragraph(),
                'description_ur'        => $faker->paragraph(),
                'stock'             => $faker->numberBetween(1000, 100000000),
                'price'             => $faker->numberBetween(5, 1000),
                'unit_id'       => $units->random(),
                'category_id'       => $categories->random(),
                'featured'          => rand(0, 1),
                'status'            => true,
                'created_at'        => now(),
                'updated_at'        => now(),

            ];

        }

        $chunks = array_chunk($products, 100);  //حتي لا يحصل تحميل علي الداتا بيز بقوله دخل كل مية مع بعض دفعه واحدة
        foreach ($chunks as $chunk){
            $product = Product::insert($chunk);
        }

        foreach (Product::get(['id', 'unit_id', 'price', 'status']) as $product){
            $productUnit = new ProductUnit;
            $productUnit->product_id    = $product->id;
            $productUnit->unit_id       = $product->unit_id;
            $productUnit->price         = $product->price;
            $productUnit->status        = $product->status;
            $productUnit->save();
        }

    }
}
