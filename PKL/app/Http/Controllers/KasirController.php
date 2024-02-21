<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Anggota;
use App\Models\Pembelian;
use App\Models\Pengajuan_kredit;
use App\Models\Detail_pembelian;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Cicilan;
use DataTables;

class KasirController extends Controller
{
    // Controller barang
    public function showBarang()
    {
        // Logika untuk halaman Barang 
        $barangs = $this->showDataBarang();
        return view('kasir.barang', ['barangs' => $barangs]);
    }

    public function entryBarang(Request $request)
    {
        // Validasi input, Anda dapat menyesuaikan sesuai kebutuhan
        $request->validate([
            'kode_barang' => 'required',
            'nama_barang' => 'required',
            'jumlah' => 'required|numeric',
            'harga_beli' => 'required|numeric',
            'harga_anggota' => 'required|numeric',
            'harga_nonanggota' => 'required|numeric',
        ]);

        // Simpan data ke dalam tabel barang
        Barang::create([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'stok' => $request->jumlah,
            'harga_beli' => $request->harga_beli,
            'harga_anggota' => $request->harga_anggota,
            'harga_nonanggota' => $request->harga_nonanggota,
        ]);

        // Redirect atau kembali ke halaman sebelumnya
        return redirect()->back()->with('success', 'Data Barang berhasil disimpan');
    }

    public function showDataBarang()
    {
        $barangs = DB::table('barang')->simplePaginate(10);
        return view('kasir.barang', ['barangs' => $barangs]);
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
            'harga_anggota' => 'required|numeric',
            'harga_nonanggota' => 'required|numeric'
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
                'harga_anggota' => $request->harga_anggota,
                'harga_nonanggota' => $request->harga_nonanggota,
            ]);

            // Redirect atau kembali ke halaman sebelumnya dengan pesan sukses
            return redirect()->route('kasir.showDataBarang')->with('success', 'Data Barang berhasil diperbarui');
        } else {
            // Handle kasus dimana barang dengan kode_barang tertentu tidak ditemukan
            return back()->withErrors(['kode_barang' => 'Barang dengan kode tertentu tidak ditemukan.']);
        }
    }

    // public function searchBarang(Request $request)
    // {
    //     $search = $request->input('search');
    //     $data = Barang::where('nama_barang', 'like', "%$search%")
    //         ->orWhere('kode_barang', 'like', "%$search%")
    //         ->get();

    //     return response()->json($data);
    // }

    public function searchBarang(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->search;

            // Tambahkan kode berikut
            $results = Barang::where('kode_barang', 'like', '%' . $request->search . '%')
                    ->orWhere('nama_barang', 'like', '%' . $request->search . '%')
                    ->get();

            $output = '';
            if (count($results) > 0) {
                foreach ($results as $key => $row) {
                    $output .= '
                        <tr>
                            <td>' . ($key + 1) . '</td>
                            <td>' . $row->kode_barang . '</td>
                            <td>' . $row->nama_barang . '</td>
                            <td>' . $row->stok . '</td>
                            <td>' . number_format($row->harga_beli, 0, ',', '.') . '</td>
                            <td>' . number_format($row->harga_anggota, 0, ',', '.') . '</td>
                            <td>' . number_format($row->harga_nonanggota, 0, ',', '.') . '</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary btn-sm rounded-2 btn-edit" data-toggle="modal" data-target="#modalEditBarang" data-kode_barang="' . $row->kode_barang . '" data-nama_barang="' . $row->nama_barang . '" data-stok="' . $row->stok . '" data-harga_beli="' . $row->harga_beli . '" data-harga_anggota="' . $row->harga_anggota . '" data-harga_nonanggota="' . $row->harga_nonanggota . '">Edit</button>
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

    // public function exportToExcel()
    // {
    //     return Excel::download(new BarangExport, 'barang.xlsx');
    // }


    // Controller Pembelian
    public function showPembelian()
    {
        // Logika untuk halaman Pembelian 
        $pembelians = $this->showDataPembelian();
        return view('kasir.pembelian', ['pembelians' => $pembelians]);
    }

    // public function entryPembelian(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'tanggal_pembelian' => 'required|date',
    //         'no_nota' => 'required|string|max:255',
    //         'mitra' => 'required|string|max:255',
    //         'harga' => 'required|numeric',
    //     ]);

    //     $pembelian = Pembelian::create($validatedData);

    //     return response()->json([
    //         'counter' => Pembelian::count(),
    //         'id' => $pembelian->id,
    //         'tanggal_pembelian' => $pembelian->tanggal_pembelian->format('Y-m-d'),
    //         'no_nota' => $pembelian->no_nota,
    //         'mitra' => $pembelian->mitra,
    //         'harga' => $pembelian->harga,
    //         'harga_formatted' => number_format($pembelian->harga, 0, ',', '.'),
    //     ]);
    // }

    public function entryPembelian(Request $request)
    {
        // Validasi input, Anda dapat menyesuaikan sesuai kebutuhan
        $validatedData = $request->validate([
            'tanggal_pembelian' => 'required|date',
            'no_nota' => 'required|string|max:255',
            'mitra' => 'required|string|max:255',
            'harga' => 'required|numeric',
        ]);

        // Simpan data ke dalam tabel anggota
        $pembelian = Pembelian::create($validatedData);

        // Redirect atau kembali ke halaman sebelumnya
        return redirect()->route('kasir.showDataPembelian')->with('success', 'Data Pembelian berhasil disimpan');
    }

    public function showDataPembelian()
    {
        $pembelians = DB::table('pembelian')->simplePaginate(10);
        return view('kasir.pembelian', ['pembelians' => $pembelians]);
    }

    public function deletePembelian($id)
    
    {
        $pembelian = Pembelian::find($id);

        if (!$pembelian) {
            return redirect()->back()->with('error', 'Data Pembelian tidak ditemukan');
        }

        $pembelian->delete();

        // Session::flash('success', 'Data Barang berhasil dihapus');
        return redirect()->back();
    }

    public function updatePembelian(Request $request)
    {
        // Validasi input
        $request->validate([
            'tanggal_pembelian' => 'required',
            'no_nota' => 'required',
            'mitra' => 'required',
            'harga' => 'required',
        ]);

        // Ambil id dari form
        $id = $request->input('id');

        // Temukan data pembelian yang akan diperbarui
        $pembelian = Pembelian::find($id);

        // Perbarui data
        $pembelian->update([
            'tanggal_pembelian' => $request->tanggal_pembelian,
            'no_nota' => $request->no_nota,
            'mitra' => $request->mitra,
            'harga' => $request->harga,
        ]);

        // Redirect atau kembali ke halaman sebelumnya
        return redirect()->route('kasir.showDataPembelian')->with('success', 'Data Pembelian berhasil diperbarui');
    }


    // Controller Anggota
    public function showAnggota()
    {
        // Logika untuk halaman Anggota 
        return view('kasir.anggota');
    }

    public function entryAnggota(Request $request)
    {
        // Validasi input, Anda dapat menyesuaikan sesuai kebutuhan
        $request->validate([
            'nik' => 'required',
            'nama' => 'required',
            'departemen' => 'required',
            'bagian' => 'required',
            'jabatan' => 'required',
            'sgroup' => 'required',
            'no_telp' => 'required',
            'norek' => 'required',
        ]);

        // Simpan data ke dalam tabel anggota
        Anggota::create([
            'nik' => $request->nik,
            'nama' => $request->nama,
            'departemen' => $request->departemen,
            'bagian' => $request->bagian,
            'jabatan' => $request->jabatan,
            'sgroup' => $request->sgroup,
            'no_telp' => $request->no_telp,
            'norek' => $request->norek,
        ]);

        // Redirect atau kembali ke halaman sebelumnya
        return redirect()->route('kasir.showDataAnggota')->with('success', 'Data Anggota berhasil disimpan');
    }

    public function showDataAnggota()
    {
        $anggotas = DB::table('anggota')->simplePaginate(10);
        return view('kasir.anggota', ['anggotas' => $anggotas]);
    }

    public function deleteAnggota($nik)
    {
        $anggota = Anggota::where('nik', $nik)->first();

        if (!$anggota) {
            return redirect()->back()->with('error', 'Data Anggota tidak ditemukan');
        }

        $anggota->delete();

        return redirect()->back()->with('success', 'Data Anggota berhasil dihapus');
    }

    public function updateAnggota(Request $request)
    {
        // Validasi input
        $request->validate([
            'nik' => 'required',
            'nama' => 'required',
            'departemen' => 'required',
            'bagian' => 'required',
            'jabatan' => 'required',
            'sgroup' => 'required',
            'no_telp' => 'required',
            'norek' => 'required',
        ]);

        // Ambil id dari form
        $nik = $request->input('nik');

        // Temukan data anggota yang akan diperbarui
        $anggota = Anggota::find($nik);

        // Perbarui data pada instansi anggota
        $anggota->update([
            'nik' => $request->nik,
            'nama' => $request->nama,
            'departemen' => $request->departemen,
            'bagian' => $request->bagian,
            'jabatan' => $request->jabatan,
            'sgroup' => $request->sgroup,
            'no_telp' => $request->no_telp,
            'norek' => $request->norek,
        ]);

        // Redirect atau kembali ke halaman sebelumnya
        return redirect()->route('kasir.showDataAnggota')->with('success', 'Data Anggota berhasil diperbarui');
    }

    public function searchAnggota(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->search;
            $data = Anggota::where('nik', 'like', '%' . $query . '%')
                ->orWhere('nama', 'like', '%' . $query . '%')
                ->orWhere('bagian', 'like', '%' . $query . '%')
                ->orWhere('sgroup', 'like', '%' . $query . '%')
                ->orWhere('norek', 'like', '%' . $query . '%')
                ->get();   
            $output = '';
            if (count($data) > 0) {
                foreach ($data as $key => $row) {
                    $output .= '
                        <tr>
                            <td>' . ($key + 1) . '</td>
                            <td>' . $row->nik . '</td>
                            <td>' . $row->nama . '</td>
                            <td>' . $row->bagian . '</td>
                            <td>' . $row->sgroup . '</td>
                            <td>' . $row->norek . '</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary btn-sm rounded-2 btn-edit" data-toggle="modal" data-target="#modalEditAnggota" data-nik="' . $row->nik . '">Edit</button>
                                    <button type="button" class="btn btn-danger btn-sm rounded-2 delete-btn" data-nik="' . $row->nik . '">Delete</button>
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
        return view('kasir.pengajuan_kredit', ['anggotaKoperasi' => $anggotaKoperasi]);
    }

    // public function entryPengajuan(Request $request)
    // {
    //     // Validasi input
    //     $request->validate([
    //         'tanggal_pengajuan' => 'required',
    //         'id_anggota' => 'required',
    //         'jenis_pengajuan' => 'required',
    //         'nominal' => 'required_if:jenis_pengajuan,uang|numeric',
    //         'nama_barang' => 'required_if:jenis_pengajuan,barang',
    //         'merk' => 'required_if:jenis_pengajuan,barang',
    //         'jenis_barang' => 'required_if:jenis_pengajuan,barang',
    //         'nominal' => 'numeric|nullable',
    //     ]);

    //     // Simpan data ke dalam tabel pengajuan_kredit
    //     Pengajuan_kredit::create([
    //         'tanggal_pengajuan' => $request->tanggal_pengajuan,
    //         'id_anggota' => $request->id_anggota,
    //         'jenis_pengajuan' => $request->jenis_pengajuan,
    //         'nominal' => $request->input('nominal', null),  
    //         'nama_barang' => $request->input('nama_barang', null),  
    //         'merk' => $request->input('merk', null), 
    //         'jenis_barang' => $request->input('jenis_barang', null), 
    //     ]);

    //     // Redirect atau kembali ke halaman sebelumnya
    //     return redirect()->back()->with('success', 'Data Pengajuan berhasil disimpan');
    // }

    public function entryPengajuan(Request $request)
    {
        // Validasi input
        $request->validate([
            'tanggal_pengajuan' => 'required',
            'id_anggota' => 'required',
            'jenis_pengajuan' => 'required',
            'nominal' => 'numeric|nullable',
            'nama_barang' => 'string|nullable',
            'merk' => 'string|nullable',
            'jenis_barang' => 'string|nullable',
            'lama_angsuran' => 'numeric|nullable',
        ]);

        // Simpan data ke dalam tabel pengajuan_kredit
        $pengajuan_kredit = Pengajuan_kredit::create([
            'tanggal_pengajuan' => $request->tanggal_pengajuan,
            'id_anggota' => $request->id_anggota,
            'jenis_pengajuan' => $request->jenis_pengajuan,
            'nominal' => $request->input('nominal', null),  
            'nama_barang' => $request->input('nama_barang', null),  
            'merk' => $request->input('merk', null), 
            'jenis_barang' => $request->input('jenis_barang', null), 
            'lama_angsuran' => $request->input('lama_angsuran', null),
            'status' => 'Menunggu', // Set status default menjadi 'Menunggu'
        ]);

        // Simpan data cicilan
        Cicilan::create([
            'id_anggota' => $request->id_anggota,
            'id_pengajuan_kredit' => $pengajuan_kredit->id,
            'suku_bunga' => 0, // Isi dengan nilai yang sesuai
            'lama_angsuran' => $request->input('lama_angsuran', null), // Anda perlu menambahkan input untuk lama angsuran di form HTML
            'angsuran_ke' => 0, // Isi dengan nilai default
        ]);

        // Redirect atau kembali ke halaman sebelumnya
        return redirect()->back()->with('success', 'Data Pengajuan berhasil disimpan');
    }

    public function showDataPengajuan()
    {
        $pengajuan_kredits = Pengajuan_kredit::with('anggota')->simplePaginate(10);
        $anggotaKoperasi = Anggota::all();

        return view('kasir.pengajuan_kredit', [
            'pengajuan_kredits' => $pengajuan_kredits,
            'anggotaKoperasi' => $anggotaKoperasi
        ]);
    }

    public function deletePengajuan($id)
    {
        $pengajuan_kredit = Pengajuan_kredit::where('id', $id)->first();

        if (!$pengajuan_kredit) {
            return redirect()->back()->with('error', 'Data Pengajuan tidak ditemukan');
        }

        $pengajuan_kredit->delete();

        return redirect()->back()->with('success', 'Data Pengajuan berhasil dihapus');
    }

    public function updatePengajuan(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'tanggal_pengajuan' => 'required',
            'id_anggota' => 'required',
            'jenis_pengajuan' => 'required',
            'nominal' => 'required_if:jenis_pengajuan,uang|numeric',
            'nama_barang' => 'required_if:jenis_pengajuan,barang',
            'merk' => 'required_if:jenis_pengajuan,barang',
            'jenis_barang' => 'required_if:jenis_pengajuan,barang',
            'nominal' => 'numeric|nullable',
        ]);

        // Ambil id dari form
        $id = $request->input('id');

        // Temukan data anggota yang akan diperbarui
        $pengajuan_kredit = Pengajuan_kredit::find($id);

        // Perbarui data pada instansi anggota
        $pengajuan_kredit->update([
            'tanggal_pengajuan' => $request->tanggal_pengajuan,
            'id_anggota' => $request->id_anggota,
            'jenis_pengajuan' => $request->jenis_pengajuan,
            'nominal' => $request->input('nominal', null),
            'nama_barang' => $request->input('nama_barang', null),
            'merk' => $request->input('merk', null),
            'jenis_barang' => $request->input('jenis_barang', null),
        ]);

        // Redirect atau kembali ke halaman sebelumnya
        return redirect()->route('kasir.showDataPengajuan')->with('success', 'Data Pengajuan berhasil diperbarui');
    }

    public function getPengajuan($id)
    {
        $pengajuan_kredit = Pengajuan_kredit::find($id);

        return response()->json($pengajuan_kredit);
    }


    // Controller Transaksi
    public function showTransaksi()
    {
        // Logika untuk halaman Transaksi 
        $anggotaKoperasi = Anggota::all();
        return view('kasir.transaksi', ['anggotaKoperasi' => $anggotaKoperasi]);
    }

    public function showDataBarangTransaksi()
    {
        $barangs = Barang::all();
        $anggotaKoperasi = Anggota::all();

        return view('kasir.transaksi', [
            'barangs' => $barangs,
            'anggotaKoperasi' => $anggotaKoperasi
        ]);
    }

    public function searchBarangTransaksi(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->search;
            $data = Barang::where('nama_barang', 'like', '%' . $query . '%')->get();   
            $output = '';
            if (count($data) > 0) {
                foreach ($data as $key => $row) {
                    $output .= '
                        <tr>
                            <td>' . ($key + 1) . '</td>
                            <td>' . $row->nama_barang . '</td>
                            <td>' . $row->harga_anggota . '</td>
                            <td>' . $row->harga_nonanggota . '</td>
                            <td> 
                                <input type="number" class="form-control" id="jumlah" name="jumlah" value="1"> 
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="#" class="btn btn-primary btn-sm rounded-2 btn-tambah">Tambah</a>
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

    // public function checkout(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         // Tambahkan validasi sesuai kebutuhan
    //     ]);

        // $transaksi = new Transaksi();
        // $transaksi->tanggal_penjualan = now();
        // $transaksi->no_nota = $this->generateNoNota();
        // $transaksi->id_anggota = $request->id_anggota;
        // $transaksi->subtotal = $request->subtotal ?? 0;
        // $transaksi->pilihan_pembayaran = $request->pilihan_pembayaran;
        // $transaksi->status = $request->pilihan_pembayaran == 'cash' ? 'lunas' : 'belum bayar';
        // $transaksi->id_kasir = auth()->id();
        // $transaksi->save();

    //     if (!empty($request->items)) {
    //         foreach ($request->items as $item) {
    //             $detail = new DetailTransaksi();
    //             $detail->id_transaksi = $transaksi->id;
    //             $detail->kode_barang = $item['kode_barang'];
    //             $detail->harga = $item['harga']; // Gunakan harga yang sudah ditentukan di front-end
    //             $detail->jumlah = $item['jumlah'];
    //             $detail->subtotal = $item['jumlah'] * $item['harga']; // Hitung subtotal berdasarkan harga
    //             $detail->save();
    //         }
    //     }

    //     return back()->with('success', 'Transaksi berhasil disimpan');
    // }

    public function checkout(Request $request)
    {
        // Validasi request
        $validatedData = $request->validate([
            //validasi
        ]);

        // Buat transaksi baru
        $transaksi = new Transaksi();
        $transaksi->tanggal_penjualan = now();
        $transaksi->no_nota = $this->generateNoNota();
        $transaksi->id_anggota = $request->id_anggota;
        $transaksi->subtotal = $request->subtotal ?? 0;
        $transaksi->pilihan_pembayaran = $request->pilihan_pembayaran;
        $transaksi->status = $request->pilihan_pembayaran == 'cash' ? 'lunas' : 'belum bayar';
        $transaksi->id_kasir = auth()->id();
        $transaksi->save();

        // Inisialisasi subtotal
        $subtotal = 0;

        // Cek dan simpan detail transaksi
        foreach ($request->items as $item) {
            $barang = Barang::find($item['kode_barang']);
            if ($barang->stok >= $item['jumlah']) {
                $harga = $barang->harga_nonanggota; // Default harga nonanggota
                if ($transaksi->id_anggota && $barang->harga_anggota) {
                    $harga = $barang->harga_anggota; // Harga anggota jika tersedia
                }

                $detailTransaksi = new DetailTransaksi();
                $detailTransaksi->id_transaksi = $transaksi->id;
                $detailTransaksi->kode_barang = $item['kode_barang'];
                $detailTransaksi->harga = $harga;
                $detailTransaksi->jumlah = $item['jumlah'];
                $detailTransaksi->subtotal = $harga * $item['jumlah'];
                $detailTransaksi->save();

                // Kurangi stok
                $barang->stok -= $item['jumlah'];
                $barang->save();

                // Tambahkan ke subtotal
                $subtotal += $detailTransaksi->subtotal;
            } else {
                // Handle error, stok tidak cukup
                return back()->withErrors(['msg' => 'Stok untuk barang ' . $barang->nama_barang . ' tidak cukup']);
            }
        }

        // Update subtotal transaksi setelah semua item ditambahkan
        $transaksi->subtotal = $subtotal;
        $transaksi->save();

        return back()->with('success', 'Transaksi berhasil disimpan');
    }

    protected function generateNoNota()
    {
        $currentYear = now()->year; // Get the current year
        $latestNota = Transaksi::latest()->first(); // Get the latest transaction
        
        // If there is no transaction yet, start with 1
        $nextNumber = is_null($latestNota) ? 1 : ((int)substr($latestNota->no_nota, 0, strpos($latestNota->no_nota, '/'))) + 1;

        // Construct 'no_nota' with the next number, static string, and current year
        $noNota = sprintf('%s/GS/KOP/%s', $nextNumber, $currentYear);

        return $noNota;
    }

    public function getKodeBarang($namaBarang)
    {
        // Mencari barang berdasarkan nama_barang
        $barang = Barang::where('nama_barang', $namaBarang)->first();

        // Jika barang ditemukan, kembalikan kode_barang
        if ($barang) {
            return $barang->kode_barang;
        }

        // Jika barang tidak ditemukan, Anda bisa kembalikan null atau handle sesuai kebutuhan
        return null;
    }

    
    // Controller Laporan
    public function showLaporan()
    {
        // Logika untuk halaman Laporan 
        return view('kasir.laporan');
    }

    public function showDataTransaksi(Request $request)
    {
        // Start the query with eager loading relationships
        $query = Transaksi::with(['detailTransaksis', 'kasir', 'anggota']);

        // Filter by date range if provided
        if ($request->filled('filterFromDate')) {
            $query->whereDate('tanggal_penjualan', '>=', $request->filterFromDate);
        }

        if ($request->filled('filterToDate')) {
            $query->whereDate('tanggal_penjualan', '<=', $request->filterToDate);
        }

        // Filter by status if provided
        if ($request->filled('filterStatus')) {
            // Adjust the condition based on how you store the status in your database
            // For example, if you store status in lowercase, make sure to convert the request parameter accordingly
            $query->where('status', strtolower($request->filterStatus));
        }

        // Execute the query
        $transaksis = $query->get();

        // Return the view with transactions data
        return view('kasir.laporan', compact('transaksis'));
    }

    public function showDetailTransaksi(Request $request)
    {
        // Start the query with eager loading relationships
        $query = DetailTransaksi::with(['transaksi', 'barang']);

        // Filter by date range if provided
        if ($request->filled('filterFromDate')) {
            $query->whereHas('transaksi', function ($query) use ($request) {
                $query->whereDate('tanggal_penjualan', '>=', $request->filterFromDate);
            });
        }

        if ($request->filled('filterToDate')) {
            $query->whereHas('transaksi', function ($query) use ($request) {
                $query->whereDate('tanggal_penjualan', '<=', $request->filterToDate);
            });
        }

        // Filter by status if provided (assuming 'status' is a field in the transaksi table)
        if ($request->filled('filterStatus')) {
            $query->whereHas('transaksi', function ($query) use ($request) {
                $query->where('status', strtolower($request->filterStatus));
            });
        }

        // Execute the query
        $detailTransaksis = $query->get();

        // Return the view with detail transaksi data
        return view('kasir.detail_transaksi', compact('detailTransaksis'));
    }

}
