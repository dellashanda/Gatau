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
        Schema::create('pengajuan_kredit', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_pengajuan');
            $table->string('id_anggota');
            $table->integer('lama_angsuran');
            $table->string('jenis_pengajuan');
            $table->integer('nominal')->nullable();
            $table->string('nama_barang')->nullable();
            $table->string('merk')->nullable();
            $table->string('jenis_barang')->nullable();
            $table->string('status')->default('Menunggu');
            $table->string('status_kepala_toko')->nullable();
            $table->string('status_keuangan')->nullable();
            $table->timestamps();

            // Menambahkan foreign key constraint
            $table->foreign('id_anggota')->references('nik')->on('anggota');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_kredit');
    }
};
