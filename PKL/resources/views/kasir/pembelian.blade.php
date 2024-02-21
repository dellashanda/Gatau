@extends('layout.main')

@section('content')
<div class="col-lg-50 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-2"> 
                <h2 class="card-title" style="font-size: 1.5rem;">TABEL PEMBELIAN</h2>
                
                <div class="d-flex">
                    <button type="button" class="btn btn-primary btn-sm rounded-2 ml-auto" data-toggle="modal" data-target="#modalPembelian">Insert Data</button>
                    <button type="button" class="btn btn-primary btn-sm rounded-2 ml-1" data-toggle="modal" data-target="#modalDetailPembelian">Insert Detail</button>
                    <a href="#" class="btn btn-primary btn-sm rounded-2 ml-1">Excel</a>
                </div>
            </div>

            <div class="input-group mb-3">
                <input type="text" class="form-control col-md-3 rounded-start" placeholder="Cari" aria-label="Recipient's username" aria-describedby="button-addon2" id="search" name="search">
                <div class="input-group-append">
                    <button class="btn btn-primary btn-sm" type="submit">
                        <i class="icon-search"></i> 
                    </button>
                </div>
            </div>

            <div id="searchResults" class="table-responsive">
                <table class="table table-striped table-bordered text-center table-hover" id="myTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Pembelian</th>
                            <th>No Nota</th>
                            <th>Mitra</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $counter = 1;
                        @endphp

                        @forelse ($pembelians as $pembelian)
                            <tr>
                                <td class="py-1">{{ $counter++ }}</td>
                                <td>{{ $pembelian->tanggal_pembelian }}</td>
                                <td>{{ $pembelian->no_nota }}</td>
                                <td>{{ $pembelian->mitra }}</td>
                                <td>{{ number_format($pembelian->harga, 0, ',', ',') }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary btn-sm rounded-2 btn-edit" data-toggle="modal" data-target="#modalEditPembelian" data-id="{{ $pembelian->id }}">Edit</button>
                                        <a href="{{ route('deletePembelian', ['id' => $pembelian->id]) }}" class="btn btn-danger btn-sm rounded-2" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</a>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Modal Edit Pembelian -->
                            <div class="modal fade" id="modalEditPembelian" tabindex="-1" role="dialog" aria-labelledby="modal_label" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="modalTitle">Edit Data Pembelian</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                        <form class="form-editPembelian" method="POST" action="{{ route('kasir.updatePembelian', ['id' => $pembelian->id]) }}" id="formEditPembelian">
                                          @csrf
                                          @method('PUT')
                                          <input type="hidden" name="id" id="id" value="{{ $pembelian->id }}">
                                          <div class="form-group">
                                              <label for="tanggal_pembelian">Tanggal Pembelian</label>
                                              <input type="date" class="form-control" id="tanggal_pembelian" name="tanggal_pembelian" value="{{ $pembelian->tanggal_pembelian }}">
                                          </div>
                                          <div class="form-group">
                                            <label for="no_nota">No Nota</label>
                                            <input type="text" class="form-control" id="no_nota" name="no_nota" placeholder="No Nota" value="{{ $pembelian->no_nota }}">
                                          </div>
                                          <div class="form-group">
                                            <label for="mitra">Mitra</label>
                                            <input type="text" class="form-control" id="mitra" name="mitra" placeholder="Mitra" value="{{ $pembelian->mitra }}">
                                          </div>
                                          <div class="form-group">
                                            <label for="harga">Harga</label>
                                            <input type="number" class="form-control" id="harga" name="harga" placeholder="Harga" value="{{ $pembelian->harga }}">
                                          </div>
                                          <button type="submit" class="btn btn-primary">Submit</button>
                                          <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                                        </form>
                                    </div>
                                  </div>
                                </div>
                            </div>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data pembelian tersedia.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Modal Insert Pembelian -->
            <div class="modal fade" id="modalPembelian" tabindex="-1" role="dialog" aria-labelledby="modalPembelian_label" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Insert Data Pembelian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form class="form-pembelian" method="POST" action="{{ route('kasir.entryPembelian') }}">
                      @csrf
                      <div class="form-group">
                          <label for="tanggal_pembelian">Tanggal Pembelian</label>
                          <input type="date" class="form-control" id="tanggal_pembelian" name="tanggal_pembelian">
                      </div>
                      <div class="form-group">
                        <label for="no_nota">No Nota</label>
                        <input type="text" class="form-control" id="no_nota" name="no_nota" placeholder="No Nota">
                      </div>
                      <div class="form-group">
                        <label for="mitra">Mitra</label>
                        <input type="text" class="form-control" id="mitra" name="mitra" placeholder="Mitra">
                      </div>
                      <div class="form-group">
                        <label for="harga">Harga</label>
                        <input type="number" class="form-control" id="harga" name="harga" placeholder="Harga">
                      </div>
                      <button type="submit" class="btn btn-primary">Submit</button>
                      <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>

            <!-- Modal Detail Pembelian -->
            <div class="modal fade" id="modalDetailPembelian" tabindex="-1" role="dialog" aria-labelledby="modal_label" aria-hidden="true">
                <div class="modal-dialog" style="max-width: 500px;" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="modalTitle">Detail Pembelian</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <input type="text" id="searchBox" placeholder="Cari">
                    </div>               
                  </div>
                </div>
            </div>            

            <nav aria-label="Page navigation example" class="mt-3">
                <ul class="pagination justify-content-end">
                    {{ $pembelians->appends(request()->input())->links() }}
                </ul>
            </nav>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

      // Inisialisasi variable id
      var id;

      // Fungsi untuk menangani klik tombol "Edit"
      $('.btn-edit').on('click', function () {
          // Ambil data dari baris yang sesuai
          id = $(this).data('id');
          var tanggal_pembelian = $(this).closest('tr').find('td:eq(1)').text();
          var no_nota = $(this).closest('tr').find('td:eq(2)').text();
          var mitra = $(this).closest('tr').find('td:eq(3)').text();
          var harga = $(this).closest('tr').find('td:eq(4)').html().replace(/[^0-9]/g, '');

          // Isi nilai-nilai dalam form modal dengan data yang sesuai
          $('#modalEditPembelian-' + id + ' #id').val(id);
          $('#modalEditPembelian-' + id + ' #tanggal_pembelian').val(tanggal_pembelian);
          $('#modalEditPembelian-' + id + ' #no_nota').val(no_nota);
          $('#modalEditPembelian-' + id + ' #mitra').val(mitra);
          $('#modalEditPembelian-' + id + ' #harga').val(harga);

          // Modifikasi URL formulir edit dengan menambahkan parameter page
          var editUrl = '{{ url("kasir/update-pembelian") }}/' + id + '?page=' + currentPage;
          $('#formEditPembelian-' + id).attr('action', editUrl);
      });


      // Event listener untuk form submit
      // $('form.form-pembelian').on('submit', function(e) {
      //     e.preventDefault(); // Mencegah submit form secara default

      //     var form = $(this);

      //     // AJAX call untuk submit form data
      //     $.ajax({
      //         url: form.attr('action'),
      //         type: 'POST',
      //         data: form.serialize(),
      //         success: function(response) {
      //             // Tutup modal pembelian
      //             $('#modalPembelian').modal('hide');

      //             // Buka modal detail pembelian
      //             $('#modalDetailPembelian').modal('show');

      //             // Tambahkan baris baru ke tabel pembelian
      //             var newRow = `<tr>
      //                 <td>${response.counter}</td>
      //                 <td>${response.tanggal_pembelian}</td>
      //                 <td>${response.no_nota}</td>
      //                 <td>${response.mitra}</td>
      //                 <td>${response.harga_formatted}</td>
      //                 <td>
      //                     <div class="btn-group">
      //                         <button type="button" class="btn btn-primary btn-sm rounded-2 btn-edit" data-toggle="modal" data-target="#modalEditPembelian" data-id="${response.id}">Edit</button>
      //                         <a href="#" class="btn btn-danger btn-sm rounded-2" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</a>
      //                     </div>
      //                 </td>
      //             </tr>`;

      //             $('#myTable tbody').prepend(newRow); // Menambahkan baris baru ke awal tbody
      //         },
      //         error: function(xhr, status, error) {
      //             console.error("Error: " + xhr.responseText);
      //         }
      //     });
      // });


      $('#search').on('keyup', function () {
          // Ambil nilai pencarian
          var keyword = $(this).val();

          // Ajax request untuk mengambil data pembelian berdasarkan keyword pencarian
          $.ajax({
              url: '{{ route('searchPembelian') }}',
              method: 'GET',
              data: {
                  keyword: keyword
              },
              success: function(response) {
                  // Hapus data pada tabel pembelian
                  $('#pembelianTable tbody').empty();

                  // Loop melalui data pembelian
                  $.each(response.data, function(index, value) {
                      // Tambahkan data ke tabel pembelian
                      $('#pembelianTable tbody').append('<tr>\
                          <td>' + value.no + '</td>\
                          <td>' + value.tanggal_pembelian + '</td>\
                          <td>' + value.no_nota + '</td>\
                          <td>' + value.mitra + '</td>\
                          <td>' + value.harga + '</td>\
                          <td>\
                              <button type="button" class="btn btn-primary btn-sm rounded-2 btn-detail" data-toggle="modal" data-target="#modalDetailPembelian" data-id="' + value.id + '">Detail</button>\
                          </td>\
                        </tr>');
                  });
              },
              error: function(xhr, status, error) {
                  // Tangani kesalahan
                  console.error(xhr.responseText);
              }
          });
      });
    });
</script>
@endsection
