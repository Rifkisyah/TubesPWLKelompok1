<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoreSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('stores')->insert([
            [
                'store_name' => 'JayMart Bandung',
                'city' => 'Bandung',
                'address' => 'Jl. Asia Afrika No. 12, Bandung',
                'phone' => '022-1234567',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'store_name' => 'JayMart Jakarta',
                'city' => 'Jakarta',
                'address' => 'Jl. Sudirman No. 45, Jakarta Selatan',
                'phone' => '021-9876543',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'store_name' => 'JayMart Surabaya',
                'city' => 'Surabaya',
                'address' => 'Jl. Tunjungan No. 78, Surabaya',
                'phone' => '031-5551234',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'store_name' => 'JayMart Yogyakarta',
                'city' => 'Yogyakarta',
                'address' => 'Jl. Malioboro No. 33, Yogyakarta',
                'phone' => '0274-445566',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'store_name' => 'JayMart Semarang',
                'city' => 'Semarang',
                'address' => 'Jl. Pandanaran No. 21, Semarang',
                'phone' => '024-7788990',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
