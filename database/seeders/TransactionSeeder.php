<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $kasirIds = DB::table('users')->where('role', 'kasir')->pluck('id', 'store_id');

        foreach ($kasirIds as $storeId => $kasirId) {
            $products = DB::table('products')->where('store_id', $storeId)->get();

            for ($i = 0; $i < 10; $i++) {
                $date = now()->subDays(rand(0, 60));
                $invoiceNum = 'INV-' . $date->format('Ymd') . '-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT);

                $totalAmount = 0;
                $items = [];
                $numItems = rand(1, 4);

                for ($j = 0; $j < $numItems; $j++) {
                    $product = $products->random();
                    $qty = rand(1, 5);
                    $subtotal = $product->price * $qty;
                    $totalAmount += $subtotal;
                    $items[] = [
                        'product_id' => $product->id,
                        'quantity' => $qty,
                        'price' => $product->price,
                        'subtotal' => $subtotal,
                    ];
                }

                $paymentAmount = ceil($totalAmount / 10000) * 10000;

                $transactionId = DB::table('transactions')->insertGetId([
                    'invoice_number' => $invoiceNum . '-' . $storeId,
                    'user_id' => $kasirId,
                    'store_id' => $storeId,
                    'total_amount' => $totalAmount,
                    'payment_amount' => $paymentAmount,
                    'change_amount' => $paymentAmount - $totalAmount,
                    'created_at' => $date,
                    'updated_at' => $date,
                ]);

                foreach ($items as $item) {
                    DB::table('transaction_items')->insert([
                        'transaction_id' => $transactionId,
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                        'subtotal' => $item['subtotal'],
                        'created_at' => $date,
                        'updated_at' => $date,
                    ]);
                }
            }
        }
    }
}
