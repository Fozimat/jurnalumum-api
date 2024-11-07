<?php

namespace Database\Seeders;

use App\Models\Subcategory;
use Illuminate\Database\Seeder;

class SubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=SubcategorySeeder
     */
    public function run(): void
    {
        $subcategories = [
            ['category_id' => 1, 'name' => 'Kas', 'code' => '1100'],
            ['category_id' => 1, 'name' => 'Piutang Usaha', 'code' => '1200'],

            ['category_id' => 2, 'name' => 'Hutang Usaha', 'code' => '2100'],
            ['category_id' => 2, 'name' => 'Hutang Pajak', 'code' => '2200'],

            ['category_id' => 3, 'name' => 'Modal Awal', 'code' => '3100'],
            ['category_id' => 3, 'name' => 'Penambahan Modal', 'code' => '3200'],

            ['category_id' => 4, 'name' => 'Penjualan', 'code' => '4100'],
            ['category_id' => 4, 'name' => 'Pendapatan Lain-lain', 'code' => '4200'],

            ['category_id' => 5, 'name' => 'Beban Kegiatan', 'code' => '5100'],
            ['category_id' => 5, 'name' => 'Beban Lain-lain', 'code' => '5200'],

        ];

        foreach ($subcategories as $item) {
            Subcategory::create($item);
        }
    }
}
