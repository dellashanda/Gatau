<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pengajuan_kredit extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_kredit';
    protected $fillable = [
        'id',
        'tanggal_pengajuan',
        'id_anggota',
        'lama_angsuran',
        'jenis_pengajuan',
        'nominal',
        'nama_barang',
        'merk',
        'jenis_barang',
        'status',
        'status_kepala_toko',
        'status_keuangan',
        'status_ketua_koperasi',
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota', 'nik');
    }

    public function cicilan()
    {
        return $this->hasMany(Cicilan::class, 'id_pengajuan_kredit');
    }
}
