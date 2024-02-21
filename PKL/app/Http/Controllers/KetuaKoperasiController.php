<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Anggota;
use App\Models\Pengajuan_kredit;

class KetuaKoperasiController extends Controller
{
    // Controller barang
    public function showBarang()
    {
        // Logika untuk halaman Barang 
        $barangs = $this->showDataBarang();
        return view('ketua_koperasi.barang', ['barangs' => $barangs]);
    }

    public function entryBarang(Request $request)
    {
        // Validasi input, Anda dapat menyesuaikan sesuai kebutuhan
        $request->validate([
            'kode_barang' => 'required',
            'nama_barang' => 'required',
            'jumlah' => 'required|numeric',
            'harga_beli' => 'required|numeric',
            'harga_eceran' => 'required|numeric',
            'harga_grosir' => 'required|numeric',
        ]);

        // Simpan data ke dalam tabel barang
        Barang::create([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'stok' => $request->jumlah,
            'harga_beli' => $request->harga_beli,
            'harga_eceran' => $request->harga_eceran,
            'harga_grosir' => $request->harga_grosir,
        ]);

        // Redirect atau kembali ke halaman sebelumnya
        return redirect()->back()->with('success', 'Data Barang berhasil disimpan');
    }

    public function showDataBarang()
    {
        $barangs = DB::table('barang')->simplePaginate(10);
        return view('ketua_koperasi.barang', ['barangs' => $barangs]);
    }

    public function deleteBarang($kode_barang)
    {
        $barang = Barang::find($kode_barang);

        if (!$barang) {
            return redirect()->back()->with('error', 'Data Barang tidak ditemukan');
        }

        $barang->delete();

        // Session::flash('success', 'Data Barang berhasil dihapus');
        return redirect()->back();
    }

    public function updateBarang(Request $request)
    {
        // Validasi input
        $request->validate([
            'kode_barang' => 'required',
            'nama_barang' => 'required',
            'jumlah' => 'required|numeric',
            'harga_beli' => 'required|numeric',
            'harga_eceran' => 'required|numeric',
            'harga_grosir' => 'required|numeric'
        ]);

        // Ambil kode_barang dari form
        $kode_barang = $request->input('kode_barang');

        // Temukan data barang yang akan diperbarui
        $barang = Barang::find($kode_barang);

        if ($barang) {
            // Perbarui data pada instance $barang
            $barang->update([
                'kode_barang' => $request->kode_barang,
                'nama_barang' => $request->nama_barang,
                'stok' => $request->jumlah,
                'harga_beli' => $request->harga_beli,
                'harga_eceran' => $request->harga_eceran,
                'harga_grosir' => $request->harga_grosir,
            ]);

            // Redirect atau kembali ke halaman sebelumnya dengan pesan sukses
            return redirect()->route('ketua_koperasi.showDataBarang')->with('success', 'Data Barang berhasil diperbarui');
        } else {
            // Handle kasus dimana barang dengan kode_barang tertentu tidak ditemukan
            return back()->withErrors(['kode_barang' => 'Barang dengan kode tertentu tidak ditemukan.']);
        }
    }

    // Controller Pengajuan Kredit
    public function showPengajuan()
    {
        // Logika untuk halaman Pembelian 
        $anggotaKoperasi = Anggota::all();
        return view('ketua_koperasi.pengajuan_kredit', ['anggotaKoperasi' => $anggotaKoperasi]);
    }

    public function showDataPengajuan()
    {
        // Mengambil pengajuan kredit yang disetujui oleh kepala toko atau keuangan
        $pengajuan_kredits = Pengajuan_kredit::with('anggota')
                            ->where('status_kepala_toko', 'Disetujui')
                            ->orWhere('status_keuangan', 'Disetujui')
                            ->simplePaginate(10);

        $anggotaKoperasi = Anggota::all();

        return view('ketua_koperasi.pengajuan_kredit', [
            'pengajuan_kredits' => $pengajuan_kredits,
            'anggotaKoperasi' => $anggotaKoperasi
        ]);
    }

    public function getPengajuan($id)
    {
        $pengajuan_kredit = Pengajuan_kredit::find($id);

        return response()->json($pengajuan_kredit);
    }

    public function setujuiPengajuan($id)
    {
        $pengajuan = Pengajuan_kredit::findOrFail($id);
        $pengajuan->status = 'Disetujui';
        $pengajuan->save();

        // Redirect back with a success message
        return back()->with('success', 'Pengajuan berhasil disetujui.');
    }

    public function tolakPengajuan($id)
    {
        $pengajuan = Pengajuan_kredit::findOrFail($id);
        $pengajuan->status = 'Ditolak';
        $pengajuan->save();

        // Redirect back with a success message
        return back()->with('success', 'Pengajuan berhasil ditolak.');
    }
}
