<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cicilan extends Model
{
    use HasFactory;

    protected $table = 'cicilan';
    protected $fillable = [
        'id',
        'id_anggota',
        'id_pengajuan_kredit',
        'suku_bunga',
        'lama_angsuran',
        'angsuran_ke',

    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota', 'nik');
    }

    public function pengajuanKredit()
    {
        return $this->belongsTo(Pengajuan_kredit::class, 'id_pengajuan_kredit');
    }
}
