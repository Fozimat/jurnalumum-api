<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=AccountSeeder
     */
    public function run(): void
    {
        $accounts = [
            ['subcategory_id' => 1, 'name' => 'Bank BNI', 'code' => '1101', 'initial_balance' => 1000000, 'initial_balance_date' => '2024-01-28', 'balance' => 1000000],
            ['subcategory_id' => 1, 'name' => 'Bank BCA', 'code' => '1102', 'initial_balance' => 1000000, 'initial_balance_date' => '2024-01-28', 'balance' => 1000000],

            ['subcategory_id' => 3, 'name' => 'Hutang Usaha Pihak Ketiga', 'code' => '2101', 'initial_balance' => 0, 'initial_balance_date' => '2024-01-28', 'balance' => 0],
            ['subcategory_id' => 3, 'name' => 'Hutang Usaha Lainnya', 'code' => '2102', 'initial_balance' => 0, 'initial_balance_date' => '2024-01-28', 'balance' => 0],

            ['subcategory_id' => 4, 'name' => 'Hutang Pajak Pihak Ketiga', 'code' => '2201', 'initial_balance' => 0, 'initial_balance_date' => '2024-01-28', 'balance' => 0],
            ['subcategory_id' => 4, 'name' => 'Hutang Pajak Lainnya', 'code' => '2202', 'initial_balance' => 0, 'initial_balance_date' => '2024-01-28', 'balance' => 0],

            ['subcategory_id' => 5, 'name' => 'Modal Pemilik', 'code' => '3101', 'initial_balance' => 0, 'initial_balance_date' => '2024-01-28', 'balance' => 0],
            ['subcategory_id' => 5, 'name' => 'Modal Investor', 'code' => '3102', 'initial_balance' => 0, 'initial_balance_date' => '2024-01-28', 'balance' => 0],

            ['subcategory_id' => 6, 'name' => 'Penambahan Modal Pemilik', 'code' => '3201', 'initial_balance' => 0, 'initial_balance_date' => '2024-01-28', 'balance' => 0],
            ['subcategory_id' => 6, 'name' => 'Penambahan Modal Investor', 'code' => '3202', 'initial_balance' => 0, 'initial_balance_date' => '2024-01-28', 'balance' => 0],

            ['subcategory_id' => 7, 'name' => 'Penjualan Barang', 'code' => '4101', 'initial_balance' => 0, 'initial_balance_date' => '2024-01-28', 'balance' => 0],

            ['subcategory_id' => 8, 'name' => 'Pendapatan Jasa', 'code' => '4201', 'initial_balance' => 0, 'initial_balance_date' => '2024-01-28', 'balance' => 0],
            ['subcategory_id' => 8, 'name' => 'Pendapatan Lainnya', 'code' => '4202', 'initial_balance' => 0, 'initial_balance_date' => '2024-01-28', 'balance' => 0],

            ['subcategory_id' => 9, 'name' => 'Beban Rapat', 'code' => '5101', 'initial_balance' => 0, 'initial_balance_date' => '2024-01-28', 'balance' => 0],
            ['subcategory_id' => 9, 'name' => 'Beban Seminar', 'code' => '5102', 'initial_balance' => 0, 'initial_balance_date' => '2024-01-28', 'balance' => 0],

            ['subcategory_id' => 10, 'name' => 'Beban Gaji', 'code' => '5201', 'initial_balance' => 0, 'initial_balance_date' => '2024-01-28', 'balance' => 0],
            ['subcategory_id' => 10, 'name' => 'Beban Lembur', 'code' => '5202', 'initial_balance' => 0, 'initial_balance_date' => '2024-01-28', 'balance' => 0],
        ];

        foreach ($accounts as $item) {
            Account::create($item);
        }
    }
}
