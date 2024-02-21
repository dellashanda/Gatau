@extends('layout.main')

@section('content')
<div class="col-lg-50 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-2"> 
                <h2 class="card-title" style="font-size: 1.5rem;">TRANSAKSI</h2>
                
                <button type="button" class="btn btn-primary btn-sm rounded-2 ml-auto" data-toggle="modal" data-target="#modalTransaksi">Tambah Transaksi</button>
            </div>

            <!-- Modal Transaksi -->
            <div class="modal fade" id="modalTransaksi" tabindex="-1" role="dialog" aria-labelledby="modal_label" aria-hidden="true">
                <div class="modal-dialog" style="max-width: 700px;" role="document">
                    <div class="modal-content" >
                        <div class="modal-header">
                            <h5 class="modal-title" id="modal">Daftar Barang</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-5 mb-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Cari Barang" aria-label="Search" id="search" name="search">
                                    </div>
                                </div>
                            </div>
                            <table class="table table-responsive table-striped table-bordered text-center table-hover" id="search_list">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Barang</th>
                                        <th>Harga Anggota</th>
                                        <th>Harga Non-Anggota</th>
                                        <th>Jumlah</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>


                                    @foreach ($barangs as $index => $barang)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $barang->nama_barang }}</td>
                                            <td class="harga-anggota">{{ number_format($barang->harga_anggota, 0, ',', ',') }}</td>
                                            <td class="harga-nonanggota">{{ number_format($barang->harga_nonanggota, 0, ',', ',') }}</td>
                                            <td>
                                                <input type="number" name="items[{{ $index }}][jumlah]" class="form-control" value="1">
                                            </td>
                                            <td>
                                                <!-- Sembunyikan input untuk menyimpan kode_barang -->
                                                <input type="hidden" name="items[{{ $index }}][kode_barang]" value="{{ $barang->kode_barang }}">
                                                <!-- Tombol atau aksi untuk menambah barang ke transaksi -->
                                                <a href="#" class="btn btn-primary btn-sm rounded-2 btn-tambah" 
                                                    data-kode_barang="{{ $barang->kode_barang }}"
                                                    data-harga-anggota="{{ $barang->harga_anggota }}" 
                                                    data-harga-nonanggota="{{ $barang->harga_nonanggota }}">Tambah
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <form class="forms-sample" method="POST" action="{{ route('kasir.checkout') }}" id="formCheckout">
            @csrf
                <div style="display: flex; justify-content: flex-start; align-items: flex-start;">
                    <div class="form-group" style="margin-right: 20px;"> <!-- Tambahkan margin untuk sedikit ruang antar div -->
                        <label for="id_anggota">Anggota Koperasi</label>
                        <div>
                            <select class="form-control" id="id_anggota" name="id_anggota">
                                <option value="" selected disabled></option>
                                @foreach ($anggotaKoperasi as $anggota)
                                <option value="{{ $anggota->nik }}">{{ $anggota->nama }} - {{ $anggota->nik }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="width: 140px;"> <!-- Tetapkan lebar untuk memastikan konsistensi -->
                        <label for="pilihan_pembayaran">Pilihan Pembayaran</label>
                        <select class="form-control" id="pilihan_pembayaran" name="pilihan_pembayaran">
                            <option value="cash">Cash</option>
                            <option value="tempo">Tempo</option>
                        </select>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered text-center table-hover" id="tabel_transaksi">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                                <th>Total Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Baris akan ditambahkan di sini oleh script jQuery -->
                        </tbody>
                    </table>
                </div>
                
                <div class="right-container mt-2" style="display: flex; flex-direction: column; align-items: flex-end;">
                    <!-- Subtotal dengan kotak -->
                    <div class="subtotal-container mt-3">
                        <h5>Subtotal <div id="subtotal" name="subtotal" class="info-box" style="margin-left: 24px; text-align: center;">0</div></h5>
                    </div>
                    <input type="hidden" id="inputSubtotal" name="subtotal" value="0">

                    <!-- Pembayaran -->
                    <div class="payment-container">
                        <h5>Tunai <input type="number" id="tunai" name="tunai" class="form-control" style="display: inline-block; margin-left: 48px; text-align: center;"></h5>
                    </div>

                    <!-- Kembalian dengan kotak -->
                        <div class="change-container">
                        <h5>Kembalian <div id="kembalian" name="kembalian" class="info-box" style="margin-left: 10px; text-align: center;">0</div></h5>
                    </div>

                    <!-- Tombol Checkout -->
                    <div class="checkout-container mt-3">
                        <button type="submit" id="btnCheckout" class="btn btn-primary btn-sm">Checkout</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.dropdown-toggle').dropdown();

    $('#id_anggota').select2({
        width: '200px' // Dropdown akan menyesuaikan lebar berdasarkan item terpanjang
    });

    function updateSubtotal() {
        var subtotal = 0;
        $('#tabel_transaksi tbody tr').each(function() {
            var totalHarga = parseInt($(this).find('td:eq(4)').text().replace(/,/g, ''));
            subtotal += totalHarga;
        });
        $('#subtotal').text(subtotal.toLocaleString()); // Memperbarui teks subtotal pada tampilan
        $('#inputSubtotal').val(subtotal); // Memperbarui nilai input tersembunyi dengan subtotal yang sebenarnya
        updateKembalian(); // Update kembalian setiap kali subtotal berubah
    }

    function updateKembalian() {
        var subtotal = parseInt($('#subtotal').text().replace(/,/g, '') || '0');
        var uangDibayarkan = $('#tunai').val(); // Ambil nilai input tunai sebagai string

        if (uangDibayarkan) { // Cek apakah input tunai tidak kosong
            uangDibayarkan = parseInt(uangDibayarkan); // Konversi input tunai ke integer
            var kembalian = uangDibayarkan - subtotal;
            $('#kembalian').text(kembalian.toLocaleString()); // Perbarui teks kembalian
        } else {
            $('#kembalian').text('0'); // Jika input tunai kosong, tetapkan kembalian menjadi 0
        }
    }

    $('#tunai').on('input', function() {
        updateKembalian(); // Update kembalian setiap kali input uang dibayarkan berubah
    });

    $('#id_anggota, #pilihan_pembayaran').on('change', function() {
        perbaruiHarga();
    });

    // Fungsi untuk menentukan harga terpilih berdasarkan kondisi saat itu
    function determinePrice(hargaAnggota, hargaNonAnggota) {
        var isMember = $('#id_anggota').val() !== null && $('#id_anggota').val() !== "";
        var isCashPayment = $('#pilihan_pembayaran').val() === 'cash';
        return (!isMember || !isCashPayment) ? hargaNonAnggota : hargaAnggota;
    }

    // Saat tombol "Tambah Transaksi" diklik, perbarui harga di modal berdasarkan pilihan id_anggota dan pilihan_pembayaran
    $('.btn-tambah-transaksi').on('click', function() {
        // Perbarui harga pada setiap baris di modal
        $('#modalTransaksi .modal-body tr').each(function() {
            var hargaAnggota = parseInt($(this).find('.harga-anggota').data('harga-anggota'));
            var hargaNonAnggota = parseInt($(this).find('.harga-nonanggota').data('harga-nonanggota'));
            var hargaTerpilih = determinePrice(hargaAnggota, hargaNonAnggota);

            // Perbarui teks harga pada modal
            $(this).find('.harga-anggota').text(hargaTerpilih.toLocaleString());
            // Jika perlu, tambahkan kode untuk memperbarui atribut atau elemen lain yang terkait dengan harga
        });
    });

    // Fungsi untuk menambahkan barang ke dalam tabel transaksi
    $(document).on('click', '.btn-tambah', function() {
        var row = $(this).closest('tr');
        var namaBarang = row.find('td:eq(1)').text();
        var jumlah = row.find('input[type="number"]').val();
        var hargaAnggota = parseInt($(this).data('harga-anggota'), 10);
        var hargaNonAnggota = parseInt($(this).data('harga-nonanggota'), 10);

        var hargaTerpilih = determinePrice(hargaAnggota, hargaNonAnggota);

        if (!isNaN(hargaTerpilih) && !isNaN(jumlah)) {
            var totalHarga = jumlah * hargaTerpilih;
            var index = $('#tabel_transaksi tbody tr').length + 1;

            var newRow = `<tr data-harga-anggota="${hargaAnggota}" data-harga-nonanggota="${hargaNonAnggota}">
                <td>${index}</td>
                <td>${namaBarang}</td>
                <td>${jumlah}</td>
                <td class="harga">${hargaTerpilih.toLocaleString()}</td>
                <td class="total">${totalHarga.toLocaleString()}</td>
                <td>
                    <button type='button' class='btn btn-danger btn-sm btn-delete'>Hapus</button>
                    <input type="hidden" name="items[${index - 1}][kode_barang]" value="${$(this).data('kode_barang')}">
                    <input type="hidden" name="items[${index - 1}][jumlah]" value="${jumlah}">
                    <input type="hidden" name="items[${index - 1}][harga]" value="${hargaTerpilih}">
                </td>
            </tr>`;

            $('#tabel_transaksi tbody').append(newRow);
            updateSubtotal();
        } else {
            alert('Terdapat kesalahan dalam data harga atau jumlah. Silakan periksa kembali.');
        }
    });

    function perbaruiHarga() {
        $('#tabel_transaksi tbody tr').each(function() {
            var row = $(this);
            var jumlah = parseInt(row.find('td:eq(2)').text());
            var hargaAnggota = parseInt(row.data('harga-anggota'));
            var hargaNonAnggota = parseInt(row.data('harga-nonanggota'));

            // Tentukan harga berdasarkan status anggota dan metode pembayaran
            var isMember = $('#id_anggota').val() !== null && $('#id_anggota').val() !== "";
            var isCashPayment = $('#pilihan_pembayaran').val() === 'cash';
            var hargaTerpilih = (!isMember || !isCashPayment) ? hargaNonAnggota : hargaAnggota;

            var totalHarga = jumlah * hargaTerpilih;

            row.find('td.harga').text(hargaTerpilih.toLocaleString());
            row.find('td.total').text(totalHarga.toLocaleString());
            row.find('input[name*="[harga]"]').val(hargaTerpilih);
        });

        updateSubtotal();
    }

    $(document).on('click', '.btn-delete', function() {
        $(this).closest('tr').remove(); // Menghapus baris terdekat dari tombol yang diklik

        // Setelah menghapus baris, perbarui nomor urut dan subtotal
        // updateRowNumbers();
        updateSubtotal();
    });

    function updateRowNumbers() {
        $('#tabel_transaksi tbody tr').each(function(index) {
            $(this).find('td:first').text(index + 1); // Memperbarui nomor urut setiap baris
        });
    }

    $('#search').on('keyup', function() {
        var query = $(this).val();
        $.ajax({
            url: "{{ url('search-barang-transaksi') }}",
            type: "GET",
            data: {'search': query},
            success: function(data) {
                $('#search_list tbody').empty(); // Kosongkan tabel sebelum menambahkan hasil baru
                $('#search_list tbody').html(data.html); // Hanya menambahkan hasil pencarian terakhir
            }
        });
    });
});
</script>


@endsection
