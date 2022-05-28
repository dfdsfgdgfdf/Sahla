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
        Unit::create(['name_ar' => 'كيلوجرام',  'name_en' => 'Kg',      'name_ur' => 'Kg',      'status' => true ]);
        Unit::create(['name_ar' => 'لتر',       'name_en' => 'Liter',   'name_ur' => 'Liter',   'status' => true ]);
        Unit::create(['name_ar' => 'قطعة',      'name_en' => 'Piece',   'name_ur' => 'Piece',   'status' => true ]);
        Unit::create(['name_ar' => 'كرتونة',    'name_en' => 'Carton',  'name_ur' => 'Carton',  'status' => true ]);

    }
}
