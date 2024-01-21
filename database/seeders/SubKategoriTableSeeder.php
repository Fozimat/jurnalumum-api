<?php

namespace Database\Seeders;

use App\Models\SubKategori;
use Illuminate\Database\Seeder;

class SubKategoriTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=SubKategoriTableSeeder
     */
    public function run(): void
    {
        $subKategori = [
            ['kategori_id' => 1, 'nama_sub_kategori' => 'Kas', 'kode_sub_kategori' => '1100'],
            ['kategori_id' => 1, 'nama_sub_kategori' => 'Piutang Usaha', 'kode_sub_kategori' => '1200'],

            ['kategori_id' => 2, 'nama_sub_kategori' => 'Hutang Usaha', 'kode_sub_kategori' => '2100'],
            ['kategori_id' => 2, 'nama_sub_kategori' => 'Hutang Pajak', 'kode_sub_kategori' => '2200'],

            ['kategori_id' => 3, 'nama_sub_kategori' => 'Modal Awal', 'kode_sub_kategori' => '3100'],
            ['kategori_id' => 3, 'nama_sub_kategori' => 'Penambahan Modal', 'kode_sub_kategori' => '3200'],

            ['kategori_id' => 4, 'nama_sub_kategori' => 'Penjualan', 'kode_sub_kategori' => '4100'],
            ['kategori_id' => 4, 'nama_sub_kategori' => 'Pendapatan Lain-lain', 'kode_sub_kategori' => '4200'],

            ['kategori_id' => 5, 'nama_sub_kategori' => 'Beban Kegiatan', 'kode_sub_kategori' => '5100'],
            ['kategori_id' => 5, 'nama_sub_kategori' => 'Beban Lain-lain', 'kode_sub_kategori' => '5200'],

        ];

        foreach ($subKategori as $item) {
            SubKategori::create($item);
        }
    }
}
