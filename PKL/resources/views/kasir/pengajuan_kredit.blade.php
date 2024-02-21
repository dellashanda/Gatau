@extends('layout.main')

@section('content')
<div class="col-lg-50 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-2"> 
                <h2 class="card-title" style="font-size: 1.5rem;">TABEL PENGAJUAN KREDIT</h2>
                
                <div class="d-flex">
                    <button type="button" class="btn btn-primary btn-sm rounded-2 ml-auto" data-toggle="modal" data-target="#modalPengajuan">Tambah Pengajuan</button>
                    <!-- <a href="#" class="btn btn-primary btn-sm rounded-2 ml-1">Excel</a> -->
                </div>
            </div>

            <!-- Modal Entry Pengajuan -->
            <div class="modal fade" id="modalPengajuan" tabindex="-1" role="dialog" aria-labelledby="modal_label" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal">Insert Data Pengajuan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="forms-sample" method="POST" action="{{ route('kasir.entryPengajuan') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="tanggal_pengajuan">Tanggal Pengajuan</label>
                            <input type="date" class="form-control" id="tanggal_pengajuan" name="tanggal_pengajuan">
                        </div>
                        <div class="form-group">
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

                        <div class="form-group">
                            <label for="lama_angsuran">Lama Angsuran (Bulan)</label>
                            <input type="number" class="form-control" id="lama_angsuran" name="lama_angsuran">
                        </div>

                        <div class="form-group">
                            <label>Jenis Pengajuan</label>
                            <div class="form-check">
                                <label class="form-check-label">
                                <input type="radio" class="form-check-input" id="jenis_pengajuan_uang" name="jenis_pengajuan" value="uang">
                                Uang
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                <input type="radio" class="form-check-input" id="jenis_pengajuan_barang" name="jenis_pengajuan" value="barang">
                                Barang
                                </label>
                            </div>
                        </div>

                        <div id="uangFields">
                            <label style="font-weight: bold;">Uang</label>
                            <div class="form-group">
                                <label for="nominal">Nominal</label>
                                <input type="number" class="form-control" id="nominal" name="nominal" placeholder="Nominal">
                            </div>
                        </div>

                        <div id="barangFields">
                            <label style="font-weight: bold;">Barang</label>
                            <div class="form-group">
                                <label for="nama_barang">Nama Barang</label>
                                <input type="text" class="form-control" id="nama_barang" name="nama_barang" placeholder="Nama Barang">
                            </div>
                            <div class="form-group">
                                <label for="merk">Merk</label>
                                <input type="text" class="form-control" id="merk" name="merk" placeholder="Merk">
                            </div>
                            <div class="form-group">
                                <label for="jenis_barang">Jenis</label>
                                <input type="text" class="form-control" id="jenis_barang" name="jenis_barang" placeholder="Jenis">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                        </form>
                    </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-bordered text-center table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama</th>
                            <th>No Telepon</th>
                            <th>Jenis</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $counter = 1;
                        @endphp

                        @foreach ($pengajuan_kredits as $pengajuan_kredit)

                        <tr>
                            <td class="py-1">{{ $counter++ }}</td>
                            <td>{{ $pengajuan_kredit->tanggal_pengajuan }}</td>
                            <td>{{ $pengajuan_kredit->anggota->nama }}</td>
                            <td>{{ $pengajuan_kredit->anggota->no_telp }}</td>
                            <td>{{ ucfirst($pengajuan_kredit->jenis_pengajuan) }}</td>
                            <td class="text-left">
                                @if($pengajuan_kredit->jenis_pengajuan == 'uang')
                                    Nominal : {{ number_format($pengajuan_kredit->nominal, 0, ',', ',') }}
                                @elseif($pengajuan_kredit->jenis_pengajuan == 'barang')
                                    <div class="mb-1">
                                        Nama Barang: {{ $pengajuan_kredit->nama_barang }}
                                    </div>
                                    <div class="mb-1">
                                        Merk: {{ $pengajuan_kredit->merk }}
                                    </div>
                                    <div>
                                        Jenis: {{ $pengajuan_kredit->jenis_barang }}
                                    </div>
                                @else
                                    Deskripsi Tidak Diketahui
                                @endif
                            </td>
                            <td class="font-weight-medium">
                                <div class="badge 
                                    {{ $pengajuan_kredit->status == 'Menunggu' ? 'badge-warning' : 
                                    ($pengajuan_kredit->status == 'Disetujui' ? 'badge-success' : 
                                    ($pengajuan_kredit->status == 'Ditolak' ? 'badge-danger' : 'badge-secondary')) }}">
                                    {{ $pengajuan_kredit->status }}
                                </div>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary btn-sm rounded-2 btn-edit" data-toggle="modal" data-target="#modalEditPengajuan_{{ $pengajuan_kredit->id }}" data-id="{{ $pengajuan_kredit->id }}">Edit</button>
                                    <a href="{{ route('deletePengajuan', ['id' => $pengajuan_kredit->id]) }}" class="btn btn-danger btn-sm rounded-2" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</a>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal Edit Pengajuan -->
                        <div class="modal fade" id="modalEditPengajuan_{{ $pengajuan_kredit->id }}" tabindex="-1" role="dialog" aria-labelledby="modal_label" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title" id="modal">Edit Data Pengajuan</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body">
                                  <form class="form-editPengajuan" method="POST" action="{{ route('kasir.updatePengajuan', ['id' => $pengajuan_kredit->id]) }}" id="formEditPengajuan" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="id" id="id" value="{{ $pengajuan_kredit->id }}">
                                    <div class="form-group">
                                        <label for="tanggal_pengajuan">Tanggal Pengajuan</label>
                                        <input type="date" class="form-control" id="tanggal_pengajuan" name="tanggal_pengajuan" value="{{ $pengajuan_kredit->tanggal_pengajuan }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="id_anggota">Anggota Koperasi</label>
                                        <div>
                                            <select class="form-control" id="id_anggota" name="id_anggota">
                                                <option value="" selected disabled></option>
                                                @foreach ($anggotaKoperasi as $anggota)
                                                    <option value="{{ $anggota->nik }}" @if($pengajuan_kredit->anggota->nama == $anggota->nama) selected @endif>
                                                        {{ $anggota->nama }} - {{ $anggota->nik }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="jenis_pengajuan">Jenis Pengajuan</label>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                            <input type="radio" class="form-check-input" id="edit_jenis_pengajuan_uang" name="jenis_pengajuan" value="uang" {{ $pengajuan_kredit->jenis_pengajuan == 'uang' ? 'checked' : '' }}>
                                            Uang
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                            <input type="radio" class="form-check-input" id="edit_jenis_pengajuan_barang" name="jenis_pengajuan" value="barang" {{ $pengajuan_kredit->jenis_pengajuan == 'barang' ? 'checked' : '' }}>
                                            Barang
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Tampilkan field nominal jika jenis pengajuan adalah uang -->
                                    <div id="uangFields" style="display:{{ $pengajuan_kredit->jenis_pengajuan == 'uang' ? 'block' : 'none' }}">
                                        <label style="font-weight: bold;">Uang</label>
                                        <div class="form-group">
                                            <label for="nominal">Nominal</label>
                                            <input type="number" class="form-control" id="nominal" name="nominal" placeholder="Nominal" value="{{ $pengajuan_kredit->nominal }}">
                                        </div>
                                    </div>

                                    <!-- Tampilkan field barang jika jenis pengajuan adalah barang -->
                                    <div id="barangFields" style="display:{{ $pengajuan_kredit->jenis_pengajuan == 'barang' ? 'block' : 'none' }}">
                                        <label style="font-weight: bold;">Barang</label>
                                        <div class="form-group">
                                            <label for="nama_barang">Nama Barang</label>
                                            <input type="text" class="form-control" id="nama_barang" name="nama_barang" placeholder="Nama Barang" value="{{ $pengajuan_kredit->nama_barang }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="merk">Merk</label>
                                            <input type="text" class="form-control" id="merk" name="merk" placeholder="Merk" value="{{ $pengajuan_kredit->merk }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="jenis_barang">Jenis</label>
                                            <input type="text" class="form-control" id="jenis_barang" name="jenis_barang" placeholder="Jenis" value="{{ $pengajuan_kredit->jenis_barang }}">
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                                  </form>
                                </div>
                            </div>
                        </div>
                    </div>

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#id_anggota').select2({
            width: '100%' // Mengatur lebar tetap menjadi 300px
        });

        // Fungsi untuk menampilkan atau menyembunyikan field
        function toggleFields(jenisPengajuan, modalId) {
            if (jenisPengajuan === 'uang') {
                $(modalId + ' #uangFields').show();
                $(modalId + ' #barangFields').hide();
            } else if (jenisPengajuan === 'barang') {
                $(modalId + ' #uangFields').hide();
                $(modalId + ' #barangFields').show();
            } else {
                $(modalId + ' #uangFields').hide();
                $(modalId + ' #barangFields').hide();
            }
        }

        // Inisialisasi modal insert
        $('#modalPengajuan').on('shown.bs.modal', function() {
            toggleFields(null, '#modalPengajuan');
        });

        // Event listener untuk perubahan jenis pengajuan
        $("input[name='jenis_pengajuan']").change(function () {
            var jenisPengajuan = $(this).val();
            var modalId = '#' + $(this).closest('.modal').attr('id');
            toggleFields(jenisPengajuan, modalId);
        });

        // Inisialisasi field saat modal edit dibuka
        $('.modal').on('shown.bs.modal', function() {
            var modalId = '#' + $(this).attr('id');
            var jenisPengajuan = $(modalId + " input[name='jenis_pengajuan']:checked").val();
            toggleFields(jenisPengajuan, modalId);
        });

        // Event listener untuk tombol edit
        $('.btn-edit').on('click', function () {
            var id = $(this).data('id');
            var editUrl = '{{ url("kasir/update-pengajuan") }}/' + id;

            // Perbarui action form berdasarkan ID pengajuan kredit
            $('#formEditPengajuan_' + id).attr('action', editUrl);

            // Lakukan AJAX request untuk mendapatkan data dan isi form
            $.ajax({
                url: '{{ url("kasir/get-pengajuan") }}/' + id,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    // Isi form dengan data yang didapat
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>


@endsection
