<?php

namespace Database\Seeders;

use App\Models\Akun;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AkunTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=AkunTableSeeder
     */
    public function run(): void
    {
        $listAkun = [
            ['sub_kategori_id' => 1, 'nama_akun' => 'Bank BNI', 'kode_akun' => '1101', 'saldo_awal' => 1000000, 'tanggal_saldo_awal' => '2024-01-28', 'saldo' => 1000000],
            ['sub_kategori_id' => 1, 'nama_akun' => 'Bank BCA', 'kode_akun' => '1102', 'saldo_awal' => 1000000, 'tanggal_saldo_awal' => '2024-01-28', 'saldo' => 1000000],

            ['sub_kategori_id' => 2, 'nama_akun' => 'Piutang Usaha Pihak Ketiga', 'kode_akun' => '1201', 'saldo_awal' => 1000000, 'tanggal_saldo_awal' => '2024-01-28', 'saldo' => 1000000],
            ['sub_kategori_id' => 2, 'nama_akun' => 'Piutang Lainnya', 'kode_akun' => '1202', 'saldo_awal' => 1000000, 'tanggal_saldo_awal' => '2024-01-28', 'saldo' => 1000000],

            ['sub_kategori_id' => 3, 'nama_akun' => 'Hutang Usaha Pihak Ketiga', 'kode_akun' => '2101', 'saldo_awal' => 1000000, 'tanggal_saldo_awal' => '2024-01-28', 'saldo' => 1000000],
            ['sub_kategori_id' => 3, 'nama_akun' => 'Hutang Usaha Lainnya', 'kode_akun' => '2102', 'saldo_awal' => 1000000, 'tanggal_saldo_awal' => '2024-01-28', 'saldo' => 1000000],

            ['sub_kategori_id' => 4, 'nama_akun' => 'Hutang Pajak Pihak Ketiga', 'kode_akun' => '2201', 'saldo_awal' => 1000000, 'tanggal_saldo_awal' => '2024-01-28', 'saldo' => 1000000],
            ['sub_kategori_id' => 4, 'nama_akun' => 'Hutang Pajak Lainnya', 'kode_akun' => '2202', 'saldo_awal' => 1000000, 'tanggal_saldo_awal' => '2024-01-28', 'saldo' => 1000000],

            ['sub_kategori_id' => 5, 'nama_akun' => 'Modal Pemilik', 'kode_akun' => '3101', 'saldo_awal' => 1000000, 'tanggal_saldo_awal' => '2024-01-28', 'saldo' => 1000000],
            ['sub_kategori_id' => 5, 'nama_akun' => 'Modal Investor', 'kode_akun' => '3102', 'saldo_awal' => 1000000, 'tanggal_saldo_awal' => '2024-01-28', 'saldo' => 1000000],

            ['sub_kategori_id' => 6, 'nama_akun' => 'Penambahan Modal Pemilik', 'kode_akun' => '3201', 'saldo_awal' => 1000000, 'tanggal_saldo_awal' => '2024-01-28', 'saldo' => 1000000],
            ['sub_kategori_id' => 6, 'nama_akun' => 'Penambahan Modal Investor', 'kode_akun' => '3202', 'saldo_awal' => 1000000, 'tanggal_saldo_awal' => '2024-01-28', 'saldo' => 1000000],

            ['sub_kategori_id' => 7, 'nama_akun' => 'Penjualan Barang', 'kode_akun' => '4101', 'saldo_awal' => 1000000, 'tanggal_saldo_awal' => '2024-01-28', 'saldo' => 1000000],

            ['sub_kategori_id' => 8, 'nama_akun' => 'Pendapatan Jasa', 'kode_akun' => '4201', 'saldo_awal' => 1000000, 'tanggal_saldo_awal' => '2024-01-28', 'saldo' => 1000000],
            ['sub_kategori_id' => 8, 'nama_akun' => 'Pendapatan Lainnya', 'kode_akun' => '4202', 'saldo_awal' => 1000000, 'tanggal_saldo_awal' => '2024-01-28', 'saldo' => 1000000],

            ['sub_kategori_id' => 9, 'nama_akun' => 'Beban Rapat', 'kode_akun' => '5101', 'saldo_awal' => 1000000, 'tanggal_saldo_awal' => '2024-01-28', 'saldo' => 1000000],
            ['sub_kategori_id' => 9, 'nama_akun' => 'Beban Seminar', 'kode_akun' => '5102', 'saldo_awal' => 1000000, 'tanggal_saldo_awal' => '2024-01-28', 'saldo' => 1000000],

            ['sub_kategori_id' => 10, 'nama_akun' => 'Beban Gaji', 'kode_akun' => '5201', 'saldo_awal' => 1000000, 'tanggal_saldo_awal' => '2024-01-28', 'saldo' => 1000000],
            ['sub_kategori_id' => 10, 'nama_akun' => 'Beban Lembur', 'kode_akun' => '5202', 'saldo_awal' => 1000000, 'tanggal_saldo_awal' => '2024-01-28', 'saldo' => 1000000],
        ];

        foreach ($listAkun as $item) {
            Akun::create($item);
        }
    }
}
