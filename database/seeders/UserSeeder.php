<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Pemilik
        DB::table('users')->insert([
            'name' => 'Pak Jayusman',
            'email' => 'jayusman@jaymart.com',
            'password' => Hash::make('password'),
            'role' => 'pemilik',
            'store_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Manajer untuk setiap cabang
        $managers = [
            ['name' => 'Ahmad Fauzi', 'email' => 'ahmad@jaymart.com', 'store_id' => 1],
            ['name' => 'Budi Santoso', 'email' => 'budi@jaymart.com', 'store_id' => 2],
            ['name' => 'Citra Dewi', 'email' => 'citra@jaymart.com', 'store_id' => 3],
            ['name' => 'Dian Pratama', 'email' => 'dian@jaymart.com', 'store_id' => 4],
            ['name' => 'Eka Putri', 'email' => 'eka@jaymart.com', 'store_id' => 5],
        ];

        foreach ($managers as $m) {
            DB::table('users')->insert([
                'name' => $m['name'],
                'email' => $m['email'],
                'password' => Hash::make('password'),
                'role' => 'manajer',
                'store_id' => $m['store_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Supervisor, Kasir, Gudang untuk cabang 1 dan 2
        $staff = [
            ['name' => 'Fajar Hidayat', 'email' => 'fajar@jaymart.com', 'role' => 'supervisor', 'store_id' => 1],
            ['name' => 'Gita Rahayu', 'email' => 'gita@jaymart.com', 'role' => 'kasir', 'store_id' => 1],
            ['name' => 'Hendra Wijaya', 'email' => 'hendra@jaymart.com', 'role' => 'gudang', 'store_id' => 1],
            ['name' => 'Indra Kusuma', 'email' => 'indra@jaymart.com', 'role' => 'supervisor', 'store_id' => 2],
            ['name' => 'Joko Susilo', 'email' => 'joko@jaymart.com', 'role' => 'kasir', 'store_id' => 2],
            ['name' => 'Kartika Sari', 'email' => 'kartika@jaymart.com', 'role' => 'gudang', 'store_id' => 2],
            ['name' => 'Lina Marlina', 'email' => 'lina@jaymart.com', 'role' => 'kasir', 'store_id' => 3],
            ['name' => 'Mulyadi', 'email' => 'mulyadi@jaymart.com', 'role' => 'gudang', 'store_id' => 3],
        ];

        foreach ($staff as $s) {
            DB::table('users')->insert([
                'name' => $s['name'],
                'email' => $s['email'],
                'password' => Hash::make('password'),
                'role' => $s['role'],
                'store_id' => $s['store_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
