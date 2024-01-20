<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=KategoriTableSeeder
     */
    public function run(): void
    {
        $kategori = [
            ['nama_kategori' => 'Aktiva', 'kode_kategori' => '1'],
            ['nama_kategori' => 'Hutang', 'kode_kategori' => '2'],
            ['nama_kategori' => 'Modal', 'kode_kategori' => '3'],
            ['nama_kategori' => 'Pendapatan', 'kode_kategori' => '4'],
            ['nama_kategori' => 'Beban', 'kode_kategori' => '5'],
        ];

        foreach ($kategori as $item) {
            Kategori::create($item);
        }
    }
}
