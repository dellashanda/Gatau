<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Anggota;
use App\Models\Pengajuan_kredit;
use App\Models\Cicilan;

class KepalaTokoController extends Controller
{
    // Controller barang
    public function showBarang()
    {
        // Logika untuk halaman Barang 
        $barangs = $this->showDataBarang();
        return view('kepala_toko.barang', ['barangs' => $barangs]);
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
        return view('kepala_toko.barang', ['barangs' => $barangs]);
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
            return redirect()->route('kepala_toko.showDataBarang')->with('success', 'Data Barang berhasil diperbarui');
        } else {
            // Handle kasus dimana barang dengan kode_barang tertentu tidak ditemukan
            return back()->withErrors(['kode_barang' => 'Barang dengan kode tertentu tidak ditemukan.']);
        }
    }

    public function searchBarang(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->search;
            $data = Barang::where('kode_barang', 'like', '%' . $query . '%')
                ->orWhere('nama_barang', 'like', '%' . $query . '%')
                ->orWhere('stok', 'like', '%' . $query . '%')
                ->orWhere('harga_beli', 'like', '%' . $query . '%')
                ->orWhere('harga_eceran', 'like', '%' . $query . '%')
                ->orWhere('harga_grosir', 'like', '%' . $query . '%')
                ->get();   
            $output = '';
            if (count($data) > 0) {
                foreach ($data as $key => $row) {
                    $output .= '
                        <tr>
                            <td>' . ($key + 1) . '</td>
                            <td>' . $row->kode_barang . '</td>
                            <td>' . $row->nama_barang . '</td>
                            <td>' . $row->stok . '</td>
                            <td>' . number_format($row->harga_beli, 0, ',', '.') . '</td>
                            <td>' . number_format($row->harga_eceran, 0, ',', '.') . '</td>
                            <td>' . number_format($row->harga_grosir, 0, ',', '.') . '</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary btn-sm rounded-2 btn-edit" data-toggle="modal" data-target="#modalEditBarang" data-kode_barang="' . $row->kode_barang . '" data-nama_barang="' . $row->nama_barang . '" data-stok="' . $row->stok . '" data-harga_beli="' . $row->harga_beli . '" data-harga_eceran="' . $row->harga_eceran . '" data-harga_grosir="' . $row->harga_grosir . '">Edit</button>
                                    <button type="button" class="btn btn-danger btn-sm rounded-2 delete-btn" data-kode_barang="' . $row->kode_barang . '">Delete</button>
                                </div>
                            </td>
                        </tr>
                    ';
                }
            } else {
                $output .= '
                    <tr>
                        <td colspan="8" class="text-center">No results found</td>
                    </tr>
                ';
            }
            return response()->json(['html' => $output]);
        }
    }


    // Controller Pengajuan Kredit
    public function showPengajuan()
    {
        // Logika untuk halaman Pembelian 
        $anggotaKoperasi = Anggota::all();
        return view('kepala_toko.pengajuan_kredit', ['anggotaKoperasi' => $anggotaKoperasi]);
    }

    public function showDataPengajuan()
    {
        // Filter pengajuan kredit untuk mendapatkan hanya jenis 'barang' dan yang belum disetujui atau ditolak
        $pengajuan_kredits = Pengajuan_kredit::with('anggota')
                            ->where('jenis_pengajuan', 'barang')
                            ->whereNotIn('status_kepala_toko', ['Disetujui', 'Ditolak']) // Tambahkan kondisi ini
                            ->simplePaginate(10);

        $anggotaKoperasi = Anggota::all();

        return view('kepala_toko.pengajuan_kredit', [
            'pengajuan_kredits' => $pengajuan_kredits,
            'anggotaKoperasi' => $anggotaKoperasi
        ]);
    }

    public function getPengajuan($id)
    {
        $pengajuan_kredit = Pengajuan_kredit::find($id);

        return response()->json($pengajuan_kredit);
    }

    public function setujuiPengajuan(Request $request, $id)
    {
        $pengajuan = Pengajuan_kredit::findOrFail($id);
        $pengajuan->status_kepala_toko = 'Disetujui';
        $pengajuan->save();

        // Perbarui suku bunga di tabel Cicilan
        $cicilan = Cicilan::where('id_pengajuan_kredit', $id)->first();
        if ($cicilan) {
            $cicilan->suku_bunga = $request->suku_bunga; // Perbarui dengan suku bunga yang dipilih
            $cicilan->save();
        }

        // Redirect kembali dengan pesan sukses
        return back()->with('success', 'Pengajuan berhasil disetujui.');
    }

    public function tolakPengajuan($id)
    {
        $pengajuan = Pengajuan_kredit::findOrFail($id);
        $pengajuan->status_kepala_toko = 'Ditolak';
        $pengajuan->status = 'Ditolak';
        $pengajuan->save();

        // Redirect back with a success message
        return back()->with('success', 'Pengajuan berhasil ditolak.');
    }
}
