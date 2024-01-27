<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('akun', function (Blueprint $table) {
            $table->bigInteger('saldo_awal')->after('kode_akun');
            $table->date('tanggal_saldo_awal')->after('saldo_awal')->nullable();
            $table->bigInteger('saldo')->after('tanggal_saldo_awal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('akun', function (Blueprint $table) {
            //
        });
    }
};
