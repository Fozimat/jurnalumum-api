<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=UsersSeeder
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Ozi',
            'email' => 'ozi@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
    }
}
