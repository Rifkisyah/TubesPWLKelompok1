<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['product_name' => 'Indomie Goreng', 'category_id' => 1, 'price' => 3500, 'stock' => 100],
            ['product_name' => 'Beras 5kg', 'category_id' => 1, 'price' => 65000, 'stock' => 50],
            ['product_name' => 'Minyak Goreng 1L', 'category_id' => 1, 'price' => 18000, 'stock' => 40],
            ['product_name' => 'Gula Pasir 1kg', 'category_id' => 1, 'price' => 15000, 'stock' => 60],
            ['product_name' => 'Aqua 600ml', 'category_id' => 2, 'price' => 4000, 'stock' => 200],
            ['product_name' => 'Teh Botol Sosro', 'category_id' => 2, 'price' => 5000, 'stock' => 80],
            ['product_name' => 'Coca Cola 390ml', 'category_id' => 2, 'price' => 7000, 'stock' => 60],
            ['product_name' => 'Susu Ultra 250ml', 'category_id' => 2, 'price' => 6500, 'stock' => 45],
            ['product_name' => 'Chitato 68g', 'category_id' => 3, 'price' => 12000, 'stock' => 30],
            ['product_name' => 'Oreo 137g', 'category_id' => 3, 'price' => 10000, 'stock' => 25],
            ['product_name' => 'Sabun Cuci Piring', 'category_id' => 4, 'price' => 8000, 'stock' => 35],
            ['product_name' => 'Deterjen 900g', 'category_id' => 4, 'price' => 22000, 'stock' => 20],
            ['product_name' => 'Shampo Sachet', 'category_id' => 5, 'price' => 1000, 'stock' => 150],
            ['product_name' => 'Sabun Mandi', 'category_id' => 5, 'price' => 5000, 'stock' => 70],
            ['product_name' => 'Paracetamol', 'category_id' => 6, 'price' => 3000, 'stock' => 8],
            ['product_name' => 'Pulpen', 'category_id' => 7, 'price' => 3000, 'stock' => 50],
        ];

        foreach ([1, 2, 3, 4, 5] as $storeId) {
            foreach ($products as $product) {
                DB::table('products')->insert([
                    'product_name' => $product['product_name'],
                    'category_id' => $product['category_id'],
                    'price' => $product['price'],
                    'stock' => $product['stock'] + rand(-10, 20),
                    'store_id' => $storeId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
