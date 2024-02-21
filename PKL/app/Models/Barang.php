<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';
    protected $primaryKey = 'kode_barang';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'stok',
        'harga_beli',
        'harga_anggota',
        'harga_nonanggota',
    ];

    public function detailTransaksis()
    {
        return $this->hasMany(DetailTransaksi::class, 'kode_barang');
    }
}
