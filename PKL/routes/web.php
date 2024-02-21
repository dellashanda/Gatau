<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\KetuaKoperasiController;
use App\Http\Controllers\KepalaTokoController;
use App\Http\Controllers\KeuanganController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('login');
});

// Rute Login
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rute Register
Route::get('/register', [LoginController::class, 'showRegister'])->name('registration');
Route::post('/register', [LoginController::class, 'register'])->name('register');

// Rute Dashboard
Route::get('/dashboard', [DashboardController::class, 'showDashboard'])->middleware('auth')->name('dashboard');

// Rute Halaman Kasir
// Data Barang
Route::get('/kasir/barang', [KasirController::class, 'showBarang'])->name('kasir.barang');
Route::post('/kasir/barang', [KasirController::class, 'entryBarang'])->name('kasir.entryBarang');
Route::get('/kasir/barang', [KasirController::class, 'showDataBarang'])->name('kasir.showDataBarang');
Route::get('/delete-barang/{kode_barang}', [KasirController::class, 'deleteBarang'])->name('deleteBarang');
Route::put('/kasir/update-barang/{kode_barang}', [KasirController::class, 'updateBarang'])->name('kasir.updateBarang');
Route::get('/kasir/search-barang',[KasirController::class,'searchBarang'])->name('kasir.searchBarang');;

// Data Pembelian
Route::get('/kasir/pembelian', [KasirController::class, 'showPembelian'])->name('kasir.pembelian');
Route::post('/kasir/pembelian', [KasirController::class, 'entryPembelian'])->name('kasir.entryPembelian');
Route::get('/kasir/pembelian', [KasirController::class, 'showDataPembelian'])->name('kasir.showDataPembelian');
Route::get('/delete-pembelian/{id}', [KasirController::class, 'deletePembelian'])->name('deletePembelian');
Route::put('/kasir/update-pembelian/{id}', [KasirController::class, 'updatePembelian'])->name('kasir.updatePembelian');
Route::get('/search-pembelian', [KasirController::class, 'searchPembelian'])->name('searchPembelian');

// Data Anggota
Route::get('/kasir/anggota', [KasirController::class, 'showAnggota'])->name('kasir.anggota');
Route::post('/kasir/anggota', [KasirController::class, 'entryAnggota'])->name('kasir.entryAnggota');
Route::get('/kasir/anggota', [KasirController::class, 'showDataAnggota'])->name('kasir.showDataAnggota');
Route::get('/delete-anggota/{nik}', [KasirController::class, 'deleteAnggota'])->name('deleteAnggota');
Route::put('/kasir/update-anggota/{nik}', [KasirController::class, 'updateAnggota'])->name('kasir.updateAnggota');
Route::get('search-anggota', [KasirController::class, 'searchAnggota']);

// Data Pengajuan Kredit
Route::get('/kasir/pengajuan_kredit', [KasirController::class, 'showPengajuan'])->name('kasir.pengajuanKredit');
Route::post('/kasir/pengajuan_kredit', [KasirController::class, 'entryPengajuan'])->name('kasir.entryPengajuan');
Route::get('/kasir/pengajuan_kredit', [KasirController::class, 'showDataPengajuan'])->name('kasir.showDataPengajuan');
Route::get('/delete-pengajuan/{id}', [KasirController::class, 'deletePengajuan'])->name('deletePengajuan');
Route::put('/kasir/update-pengajuan/{id}', [KasirController::class, 'updatePengajuan'])->name('kasir.updatePengajuan');
Route::get('/kasir/get-pengajuan/{id}', [KasirController::class, 'getPengajuan'])->name('kasir.getPengajuan');

// Data Transaksi
Route::get('/kasir/transaksi', [KasirController::class, 'showTransaksi'])->name('kasir.transaksi');
Route::get('/kasir/transaksi', [KasirController::class, 'showDataBarangTransaksi'])->name('kasir.showDataBarangTransaksi');
Route::get('search-barang-transaksi', [KasirController::class, 'searchBarangTransaksi'])->name('kasir.searchBarangTransaksi');
Route::post('/kasir/checkout', [KasirController::class, 'checkout'])->name('kasir.checkout');

// Data Laporan
Route::get('/kasir/laporan', [KasirController::class, 'showLaporan'])->name('kasir.laporan');
Route::get('/kasir/laporan', [KasirController::class, 'showDataTransaksi'])->name('kasir.laporan');
Route::get('/kasir/detail_transaksi', [KasirController::class, 'showDetailTransaksi'])->name('kasir.detailTransaksi');


// Rute Halaman Kepala Toko
// Data Barang
Route::get('/kepala_toko/barang', [KepalaTokoController::class, 'showBarang'])->name('kepala_toko.barang');
Route::post('/kepala_toko/barang', [KepalaTokoController::class, 'entryBarang'])->name('kepala_toko.entryBarang');
Route::get('/kepala_toko/barang', [KepalaTokoController::class, 'showDataBarang'])->name('kepala_toko.showDataBarang');
Route::get('/delete-barang/{kode_barang}', [KepalaTokoController::class, 'deleteBarang'])->name('deleteBarang');
Route::put('/kepala_toko/update-barang/{kode_barang}', [KepalaTokoController::class, 'updateBarang'])->name('kepala_toko.updateBarang');
Route::get('/kepala_toko/search-barang',[KasirController::class,'searchBarang']);

// Data Pengajuan Kredit
Route::get('/kepala_toko/pengajuan_kredit', [KepalaTokoController::class, 'showPengajuan'])->name('kepala_toko.pengajuanKredit');
Route::get('/kepala_toko/pengajuan_kredit', [KepalaTokoController::class, 'showDataPengajuan'])->name('kepala_toko.showDataPengajuan');
Route::get('/kepala_toko/get-pengajuan/{id}', [KepalaTokoController::class, 'getPengajuan'])->name('kepala_toko.getPengajuan');
Route::post('/kepala_toko/setujui-pengajuan/{id}', [KepalaTokoController::class, 'setujuiPengajuan'])->name('kepala_toko.setujuiPengajuan');
Route::get('/kepala_toko/tolak-pengajuan/{id}', [KepalaTokoController::class, 'tolakPengajuan'])->name('kepala_toko.tolakPengajuan');


// Rute Halaman Ketua Koperasi
// Data Barang
Route::get('/ketua_koperasi/barang', [KetuaKoperasiController::class, 'showBarang'])->name('ketua_koperasi.barang');
Route::post('/ketua_koperasi/barang', [KetuaKoperasiController::class, 'entryBarang'])->name('ketua_koperasi.entryBarang');
Route::get('/ketua_koperasi/barang', [KetuaKoperasiController::class, 'showDataBarang'])->name('ketua_koperasi.showDataBarang');
Route::get('/delete-barang/{kode_barang}', [KetuaKoperasiController::class, 'deleteBarang'])->name('deleteBarang');
Route::put('/ketua_koperasi/update-barang/{kode_barang}', [KetuaKoperasiController::class, 'updateBarang'])->name('ketua_koperasi.updateBarang');

// Data Pengajuan Kredit
Route::get('/ketua_koperasi/pengajuan_kredit', [KetuaKoperasiController::class, 'showPengajuan'])->name('ketua_koperasi.pengajuanKredit');
Route::get('/ketua_koperasi/pengajuan_kredit', [KetuaKoperasiController::class, 'showDataPengajuan'])->name('ketua_koperasi.showDataPengajuan');
Route::get('/ketua_koperasi/get-pengajuan/{id}', [KetuaKoperasiController::class, 'getPengajuan'])->name('ketua_koperasi.getPengajuan');
Route::get('/ketua_koperasi/setujui-pengajuan/{id}', [KetuaKoperasiController::class, 'setujuiPengajuan'])->name('ketua_koperasi.setujuiPengajuan');
Route::get('/ketua_koperasi/tolak-pengajuan/{id}', [KetuaKoperasiController::class, 'tolakPengajuan'])->name('ketua_koperasi.tolakPengajuan');


// Rute Halaman Keuangan
// Data Barang
Route::get('/keuangan/barang', [KeuanganController::class, 'showBarang'])->name('keuangan.barang');
Route::post('/keuangan/barang', [KeuanganController::class, 'entryBarang'])->name('keuangan.entryBarang');
Route::get('/keuangan/barang', [KeuanganController::class, 'showDataBarang'])->name('keuangan.showDataBarang');
Route::get('/delete-barang/{kode_barang}', [KeuanganController::class, 'deleteBarang'])->name('deleteBarang');
Route::put('/keuangan/update-barang/{kode_barang}', [KeuanganController::class, 'updateBarang'])->name('keuangan.updateBarang');

// Data Pengajuan Kredit
Route::get('/keuangan/pengajuan_kredit', [KeuanganController::class, 'showPengajuan'])->name('keuangan.pengajuanKredit');
Route::get('/keuangan/pengajuan_kredit', [KeuanganController::class, 'showDataPengajuan'])->name('keuangan.showDataPengajuan');
Route::get('/keuangan/get-pengajuan/{id}', [KeuanganController::class, 'getPengajuan'])->name('keuangan.getPengajuan');
Route::get('/setujui-pengajuan/{id}', [KeuanganController::class, 'setujuiPengajuan'])->name('keuangan.setujuiPengajuan');
Route::get('/tolak-pengajuan/{id}', [KeuanganController::class, 'tolakPengajuan'])->name('keuangan.tolakPengajuan');