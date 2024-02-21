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
        Schema::create('anggota', function (Blueprint $table) {
            $table->string('nik')->primary();
            $table->string('nama');
            $table->string('departemen');
            $table->string('bagian');
            $table->string('jabatan');
            $table->string('sgroup');
            $table->string('no_telp');
            $table->string('norek');
            $table->string('potongan_wajib')->nullable()->default(20000);
            $table->integer('cicilan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggota');
    }
};
