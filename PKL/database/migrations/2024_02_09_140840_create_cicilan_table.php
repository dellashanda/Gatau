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
        Schema::create('cicilan', function (Blueprint $table) {
            $table->id();
            $table->string('id_anggota');
            $table->unsignedBigInteger('id_pengajuan_kredit');
            $table->decimal('suku_bunga', 8, 2)->nullable();
            $table->integer('lama_angsuran');
            $table->integer('angsuran_ke')->default(0);
            $table->timestamps();

            $table->foreign('id_anggota')->references('nik')->on('anggota');
            $table->foreign('id_pengajuan_kredit')->references('id')->on('pengajuan_kredit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cicilan');
    }
};
