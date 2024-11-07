<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=CategorySeeder
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Aktiva', 'code' => '1'],
            ['name' => 'Hutang', 'code' => '2'],
            ['name' => 'Modal', 'code' => '3'],
            ['name' => 'Pendapatan', 'code' => '4'],
            ['name' => 'Beban', 'code' => '5'],
        ];

        foreach ($categories as $item) {
            Category::create($item);
        }
    }
}
