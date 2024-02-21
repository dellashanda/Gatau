@extends('layout.main')

@section('content')
<div class="col-lg-50 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-2"> 
                <h2 class="card-title" style="font-size: 1.5rem;">TABEL ANGGOTA</h2>
                
                <div class="d-flex">
                    <button type="button" class="btn btn-primary btn-sm rounded-2 ml-auto" data-toggle="modal" data-target="#modalAnggota">Insert Data</button>
                    <a href="#" class="btn btn-primary btn-sm rounded-2 ml-1">Excel</a>
                </div>
            </div>

            <!-- Formulir Pencarian -->
            <form id="formPencarian">
                <div class="input-group mb-3">
                    <input type="text" class="form-control col-md-3" placeholder="Cari Anggota" aria-label="Search" id="search" name="search">
                    <div class="input-group-append">
                        <button class="btn btn-primary btn-sm" type="button" id="tombolCari">
                            <i class="icon-search"></i>
                        </button>
                    </div>
                </div>
            </form>

            <!-- Modal Insert Anggota -->
            <div class="modal fade" id="modalAnggota" tabindex="-1" role="dialog" aria-labelledby="modal_label" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modal">Insert Data Anggota</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form class="forms-sample" method="POST" action="{{ route('kasir.entryAnggota') }}" id="formInsertAnggota">
                      @csrf
                      <div class="form-group">
                        <label for="kode_barang">NIK</label>
                        <input type="text" class="form-control" id="nik" name="nik" placeholder="NIK">
                      </div>
                      <div class="form-group">
                        <label for="nama_barang">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama">
                      </div>
                      <div class="form-group">
                          <label for="departemen">Departemen</label>
                          <input type="text" class="form-control" id="departemen" name="departemen" placeholder="Departemen">
                      </div>
                      <div class="form-group">
                          <label for="bagian">Bagian</label>
                          <input type="text" class="form-control" id="bagian" name="bagian" placeholder="Bagian">
                      </div>
                      <div class="form-group">
                          <label for="jabatan">Jabatan</label>
                          <input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="Jabatan">
                      </div>
                      <div class="form-group">
                          <label for="bagian">SGroup</label>
                          <select class="form-control" id="sgroup" name="sgroup">
                              <option value="" selected disabled>Pilih SGroup</option>
                              <option value="HRN">HRN</option>
                              <option value="BLN">BLN</option>
                              <option value="BRG">BRG</option>
                          </select>
                      </div>
                      <div class="form-group">
                          <label for="no_telp">No Telepon</label>
                          <input type="text" class="form-control" id="no_telp" name="no_telp" placeholder="No Telepon">
                      </div>
                      <div class="form-group">
                          <label for="norek">No Rekening</label>
                          <input type="text" class="form-control" id="norek" name="norek" placeholder="No Rekening">
                      </div>
                      <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                      <button type="button" class="btn btn-light btn-sm" data-dismiss="modal" id="cancelButton">Cancel</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>

            <!-- Tabel Anggota -->
            <div class="table-responsive" id="search_list">
                <table class="table table-striped table-bordered text-center table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Bagian</th>
                            <th>SGroup</th>
                            <th>No Rekening</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                        @php
                            $counter = 1;
                        @endphp

                        @forelse ($anggotas as $anggota)
                        <tr>
                            <td class="py-1">{{ $counter++ }}</td>
                            <td>{{ $anggota->nik }}</td>
                            <td>{{ $anggota->nama }}</td>
                            <td>{{ $anggota->bagian }}</td>
                            <td>{{ $anggota->sgroup }}</td>
                            <td>{{ $anggota->norek }}</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary btn-sm rounded-2 btn-edit" data-toggle="modal" data-target="#modalEditAnggota" data-nik="{{ $anggota->nik }}" data-nama="{{ $anggota->nama }}" 
                                        data-departemen="{{ $anggota->departemen }}" data-bagian="{{ $anggota->bagian }}" data-jabatan="{{ $anggota->jabatan }}" data-sgroup="{{ $anggota->sgroup }}" data-no_telp="{{ $anggota->no_telp }}" 
                                        data-norek="{{ $anggota->norek }}">Edit</button>
                                    <a href="{{ route('deleteAnggota', ['nik' => $anggota->nik]) }}" class="btn btn-danger btn-sm rounded-2" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</a>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal Edit Anggota -->
                        <div class="modal fade" id="modalEditAnggota" tabindex="-1" role="dialog" aria-labelledby="modal_label" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modal">Edit Data Anggota</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form class="forms-sample" method="POST" action="{{ route('kasir.updateAnggota', ['nik' => $anggota->nik]) }}" id="formEditAnggota">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                                <label for="kode_barang">NIK</label>
                                                <input type="text" class="form-control" id="nik" name="nik" placeholder="NIK">
                                            </div>
                                            <div class="form-group">
                                                <label for="nama_barang">Nama</label>
                                                <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama">
                                            </div>
                                            <div class="form-group">
                                                <label for="departemen">Departemen</label>
                                                <input type="text" class="form-control" id="departemen" name="departemen" placeholder="Departemen">
                                            </div>
                                            <div class="form-group">
                                                <label for="bagian">Bagian</label>
                                                <input type="text" class="form-control" id="bagian" name="bagian" placeholder="Bagian">
                                            </div>
                                            <div class="form-group">
                                                <label for="jabatan">Jabatan</label>
                                                <input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="Jabatan">
                                            </div>
                                            <div class="form-group">
                                                <label for="bagian">SGroup</label>
                                                <select class="form-control" id="sgroup" name="sgroup">
                                                    <option value="" disabled>Pilih SGroup</option>
                                                    <option value="HRN" @if($anggota->sgroup == 'HRN') selected @endif>HRN</option>
                                                    <option value="BLN" @if($anggota->sgroup == 'BLN') selected @endif>BLN</option>
                                                    <option value="BRG" @if($anggota->sgroup == 'BRG') selected @endif>BRG</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="no_telp">No Telepon</label>
                                                <input type="text" class="form-control" id="no_telp" name="no_telp" placeholder="No Telepon">
                                            </div>
                                            <div class="form-group">
                                                <label for="norek">No Rekening</label>
                                                <input type="text" class="form-control" id="norek" name="norek" placeholder="No Rekening">
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                                            <button type="button" class="btn btn-light btn-sm" data-dismiss="modal">Cancel</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data anggota tersedia.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>                
              
                <nav aria-label="Page navigation example" class="mt-3">
                    <ul class="pagination justify-content-end">
                        {{ $anggotas->appends(request()->input())->links() }}
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    // Dapatkan halaman saat ini dari URL
    var currentPage = window.location.href.match(/page=(\d+)/);
    currentPage = currentPage ? currentPage[1] : 1;

    // Fungsi untuk menangani klik tombol "Edit"
    $('.btn-edit').on('click', function () {
        // Ambil data dari attributes
        var nik = $(this).data('nik');
        var nama = $(this).data('nama');
        var departemen = $(this).data('departemen');
        var bagian = $(this).data('bagian');
        var jabatan = $(this).data('jabatan');
        var sgroup = $(this).data('sgroup');
        var no_telp = $(this).data('no_telp');
        var norek = $(this).data('norek');

        // Isi form pada modal edit dengan data yang diambil
        $('#modalEditAnggota').find('#nik').val(nik);
        $('#modalEditAnggota').find('#nama').val(nama);
        $('#modalEditAnggota').find('#departemen').val(departemen);
        $('#modalEditAnggota').find('#bagian').val(bagian);
        $('#modalEditAnggota').find('#jabatan').val(jabatan);
        $('#modalEditAnggota').find('#sgroup').val(sgroup);
        $('#modalEditAnggota').find('#no_telp').val(no_telp);
        $('#modalEditAnggota').find('#norek').val(norek);


        // Modifikasi URL formulir edit dengan menambahkan parameter page
        var editUrl = '{{ url("kasir/update-anggota") }}/' + nik + '?page=' + currentPage;
        $('#formEditAnggota').attr('action', editUrl);
    });

    document.getElementById("cancelButton").addEventListener("click", function() {
        document.getElementById("formInsertAnggota").reset(); 
    });

    $('#search').on('keyup', function() {
        var query = $(this).val();
        $.ajax({
            url: "{{ url('search-anggota') }}",
            type: "GET",
            data: {'search': query},
            success: function(data) {
                $('#search_list tbody').html(data.html);
            }
        });
    });
});

</script>

@endsection
