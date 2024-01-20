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
        Schema::create('detail_jurnal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_jurnal');
            $table->unsignedBigInteger('id_akun');
            $table->unsignedBigInteger('debit');
            $table->unsignedBigInteger('kredit');
            $table->timestamps();

            $table->foreign('id_jurnal')->references('id')->on('jurnal_umum')->onDelete('cascade');
            $table->foreign('id_akun')->references('id')->on('akun')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_jurnal');
    }
};