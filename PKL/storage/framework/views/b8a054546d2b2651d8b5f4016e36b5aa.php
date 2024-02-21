

<?php $__env->startSection('content'); ?>
<div class="col-lg-15 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-2"> 
                <h2 class="card-title" style="font-size: 1.5rem;">TABEL BARANG</h2>
                
                <!-- Button Insert & Excel -->
                <div class="d-flex">
                    <button type="button" class="btn btn-primary btn-sm rounded-2 ml-auto" data-toggle="modal" data-target="#modalBarang">Insert Data</button>
                    <a href="#" class="btn btn-primary btn-sm rounded-2 ml-1">Excel</a>
                </div>
            </div>

            <!-- Search -->
            <div class="input-group mb-3">
                <input type="text" class="form-control col-md-3 rounded-start" aria-describedby="button-addon2" id="search" name="search" placeholder="Cari Barang" onfocus="this.value=''">
                <div class="input-group-append">
                    <button class="btn btn-primary btn-sm" type="button">
                        <i class="icon-search"></i> 
                    </button>
                </div>
            </div>

            <!-- Modal Insert Barang -->
            <div class="modal fade" id="modalBarang" tabindex="-1" role="dialog" aria-labelledby="modal_label" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modal">Insert Data Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeButton">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form class="forms-sample" method="POST" action="<?php echo e(route('kasir.entryBarang')); ?>" id="formInsertBarang">
                      <?php echo csrf_field(); ?>
                      <div class="form-group">
                        <label for="kode_barang">Kode Barang</label>
                        <input type="text" class="form-control" id="kode_barang" name="kode_barang" placeholder="Kode Barang">
                      </div>
                      <div class="form-group">
                        <label for="nama_barang">Nama Barang</label>
                        <input type="text" class="form-control" id="nama_barang" name="nama_barang" placeholder="Nama Barang">
                      </div>
                      <div class="form-group">
                          <label for="jumlah">Jumlah</label>
                          <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="Jumlah">
                      </div>
                      <div class="form-group">
                          <label for="harga_beli">Harga Beli</label>
                          <input type="number" class="form-control" id="harga_beli" name="harga_beli" placeholder="Harga Beli">
                      </div>
                      <div class="form-group">
                        <label for="harga_anggota">Harga Anggota</label>
                        <input type="number" class="form-control" id="harga_anggota" name="harga_anggota" placeholder="Harga Anggota">
                      </div>
                      <div class="form-group">
                        <label for="harga_nonanggota">Harga Non-Anggota</label>
                        <input type="number" class="form-control" id="harga_nonanggota" name="harga_nonanggota" placeholder="Harga Non-Anggota">
                      </div>
                      <button type="submit" class="btn btn-primary">Submit</button>
                      <button type="button" class="btn btn-light" data-dismiss="modal" id="cancelButton">Cancel</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>

            <!-- Tabel Barang -->
            <div class="table-responsive" id="search_list">
                <table class="table table-striped table-bordered text-center table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Stok</th>
                            <th>Harga Beli</th>
                            <th>Harga Anggota</th>
                            <th>Harga Non-Anggota</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                            $counter = 1;
                        ?>

                        <?php $__empty_1 = true; $__currentLoopData = $barangs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $barang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                          <tr>
                              <td class="py-1"><?php echo e($counter++); ?></td>
                              <td><?php echo e($barang->kode_barang); ?></td>
                              <td><?php echo e($barang->nama_barang); ?></td>
                              <td><?php echo e($barang->stok); ?></td>
                              <td><?php echo e(number_format($barang->harga_beli, 0, ',', ',')); ?></td>
                              <td><?php echo e(number_format($barang->harga_anggota, 0, ',', ',')); ?></td>
                              <td><?php echo e(number_format($barang->harga_nonanggota, 0, ',', ',')); ?></td>
                              <td>
                                  <div class="btn-group">
                                      <button type="button" class="btn btn-primary btn-sm rounded-2 btn-edit" data-toggle="modal" data-target="#modalEditBarang" data-kode_barang="<?php echo e($barang->kode_barang); ?>" data-nama_barang="<?php echo e($barang->nama_barang); ?>" data-stok="<?php echo e($barang->stok); ?>" data-harga_beli="<?php echo e($barang->harga_beli); ?>" data-harga_anggota="<?php echo e($barang->harga_nonanggota); ?>" data-harga_nonanggota="<?php echo e($barang->harga_nonanggota); ?>">Edit</button>
                                      <a href="<?php echo e(route('deleteBarang', ['kode_barang' => $barang->kode_barang])); ?>" class="btn btn-danger btn-sm rounded-2" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</a>
                                  </div>
                              </td>
                          </tr>   
                          
                          <!-- Modal Edit Barang -->
                          <div class="modal fade" id="modalEditBarang" tabindex="-1" role="dialog" aria-labelledby="modal_label" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="modal">Edit Data Barang</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <form class="forms-sample" method="POST" action="<?php echo e(route('kasir.updateBarang', ['kode_barang' => $barang->kode_barang])); ?>" id="formEditBarang">
                                      <?php echo csrf_field(); ?>
                                      <?php echo method_field('PUT'); ?>
                                      <div class="form-group">
                                        <label for="kode_barang">Kode Barang</label>
                                        <input type="text" class="form-control" id="kode_barang" name="kode_barang" placeholder="Kode Barang">
                                      </div>
                                      <div class="form-group">
                                        <label for="nama_barang">Nama Barang</label>
                                        <input type="text" class="form-control" id="nama_barang" name="nama_barang" placeholder="Nama Barang">
                                      </div>
                                      <div class="form-group">
                                          <label for="jumlah">Jumlah</label>
                                          <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="Jumlah">
                                      </div>
                                      <div class="form-group">
                                          <label for="harga_beli">Harga Beli</label>
                                          <input type="number" class="form-control" id="harga_beli" name="harga_beli" placeholder="Harga Beli">
                                      </div>
                                      <div class="form-group">
                                        <label for="harga_anggota">Harga Anggota</label>
                                        <input type="number" class="form-control" id="harga_anggota" name="harga_anggota" placeholder="Harga Anggota">
                                      </div>
                                      <div class="form-group">
                                        <label for="harga_nonanggota">Harga Non-Anggota</label>
                                        <input type="number" class="form-control" id="harga_nonanggota" name="harga_nonanggota" placeholder="Harga Non-Anggota">
                                      </div>
                                      <button type="submit" class="btn btn-primary">Submit</button>
                                      <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                                    </form>
                                  </div>
                                </div>
                              </div>
                          </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                          <td colspan="8" class="text-center">Tidak ada data barang tersedia.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
              
                <nav aria-label="Page navigation example" class="mt-3">
                    <ul class="pagination justify-content-end">
                        <?php echo e($barangs->appends(request()->input())->links()); ?>

                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.btn-edit').on('click', function () {
        var kode_barang = $(this).data('kode_barang');
        var nama_barang = $(this).data('nama_barang');
        var stok = $(this).data('stok');
        var harga_beli = $(this).data('harga_beli');
        var harga_anggota = $(this).data('harga_anggota');
        var harga_nonanggota = $(this).data('harga_nonanggota');

        $('#modalEditBarang').find('#kode_barang').val(kode_barang);
        $('#modalEditBarang').find('#nama_barang').val(nama_barang);
        $('#modalEditBarang').find('#jumlah').val(stok);
        $('#modalEditBarang').find('#harga_beli').val(harga_beli);
        $('#modalEditBarang').find('#harga_anggota').val(harga_anggota);
        $('#modalEditBarang').find('#harga_nonanggota').val(harga_nonanggota);

        // Modifikasi URL formulir edit dengan menambahkan parameter page
        var editUrl = '<?php echo e(url("kasir/update-barang")); ?>/' + kode_barang + '?page=' + currentPage;
        $('#formEditBarang').attr('action', editUrl);
    });

    document.getElementById("cancelButton").addEventListener("click", function() {
        document.getElementById("formInsertBarang").reset(); 
    });

    document.getElementById("closeButton").addEventListener("click", function() {
        document.getElementById("formInsertBarang").reset(); 
    });

    $('#search').on('keyup', function() {
        var query = $(this).val();
        $.ajax({
            url: "<?php echo e(url('/kasir/search-barang')); ?>",
            type: "GET",
            data: {'search': query},
            success: function(data) {
                $('#search_list tbody').html(data.html);
            }
        });
    });
});


</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Latihan\pkl\resources\views/kasir/barang.blade.php ENDPATH**/ ?>