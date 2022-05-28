<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Unit::create(['name_ar' => 'كيلوجرام',  'name_en' => 'Kg',      'name_ur' => 'کلو',    'status' => true ]);
        Unit::create(['name_ar' => 'لتر',       'name_en' => 'Liter',   'name_ur' => 'لیٹر',   'status' => true ]);
        Unit::create(['name_ar' => 'قطعة',      'name_en' => 'Piece',   'name_ur' => 'ٹکڑا',   'status' => true ]);
        Unit::create(['name_ar' => 'كرتونة',    'name_en' => 'Carton',  'name_ur' => 'کارٹن',  'status' => true ]);

    }
}
