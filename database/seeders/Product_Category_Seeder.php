<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Makanan', 'Minuman', 'Snack', 'Kebutuhan Rumah Tangga', 'Perawatan Tubuh', 'Obat-obatan', 'Alat Tulis'];

        foreach ($categories as $cat) {
            DB::table('product_categories')->insert([
                'category_name' => $cat,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
