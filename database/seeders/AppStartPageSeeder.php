<?php

namespace Database\Seeders;

use App\Models\AppStartPage;
use Illuminate\Database\Seeder;

class AppStartPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AppStartPage::create(['text_ar' => 'هذا النص الاول هو مثال لنص يمكن أن يستبدل في نفس المساحة .',    'text_en' => 'First Lorem ipsum dolor sit amet, consectetur adipiscing elit.',  'text_ur' => 'یہ پہلا متن ایک متن کی ایک مثال ہے جسے ایک ہی جگہ میں تبدیل کیا جا سکتا ہے۔',     'image' => 'images/category/clothes.jpg',           'status' => true, 'number' => '1' ]);
        AppStartPage::create(['text_ar' => 'هذا النص الثاني هو مثال لنص يمكن أن يستبدل في نفس المساحة .',  'text_en' => 'Second Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'text_ur' => 'یہ پہلا متن ایک متن کی ایک مثال ہے جسے ایک ہی جگہ میں تبدیل کیا جا سکتا ہے۔',    'image' => 'images/category/womenclothes.jpg',      'status' => true, 'number' => '2' ]);
        AppStartPage::create(['text_ar' => 'هذا النص الثالث هو مثال لنص يمكن أن يستبدل في نفس المساحة .',  'text_en' => 'Third Lorem ipsum dolor sit amet, consectetur adipiscing elit.',  'text_ur' => 'یہ پہلا متن ایک متن کی ایک مثال ہے جسے ایک ہی جگہ میں تبدیل کیا جا سکتا ہے۔',     'image' => 'images/category/womenclothes2.jpg',     'status' => true, 'number' => '3' ]);

    }
}
