

<?php $__env->startSection('content'); ?>
<div class="col-lg-50 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-2"> 
                <h2 class="card-title" style="font-size: 1.5rem;">TABEL LAPORAN TRANSAKSI</h2>
                
                <div class="d-flex">
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

            <div style="display: flex; justify-content: flex-start; align-items: flex-start;">
                <div class="filter-container" style="display: flex;">
                    <form id="formFilter" action="<?php echo e(route('kasir.detailTransaksi')); ?>" method="GET" style="display: flex;">
                        <div class="form-group" style="max-width: 180px; margin-right: 10px;">
                            <label for="filterFromDate">Dari Tanggal</label>
                            <input type="date" class="form-control" id="filterFromDate" name="filterFromDate">
                        </div>
                        <div class="form-group" style="max-width: 180px; margin-right: 10px;">
                            <label for="filterToDate">Sampai Tanggal</label>
                            <input type="date" class="form-control" id="filterToDate" name="filterToDate">
                        </div>
                        <div class="form-group" style="margin-right: 10px;">
                            <button type="submit" class="btn btn-primary btn-sm mt-4">Filter</button>
                            <button type="button" class="btn btn-danger btn-sm ml-0 mt-4" id="resetFilter">Reset Filter</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabel Detail Transaksi -->
            <div class="table-responsive">
                <table class="table table-striped table-bordered text-center table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>No Nota</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $detailTransaksis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="py-1"><?php echo e($loop->iteration); ?></td>
                                <td><?php echo e(optional($detail->transaksi)->tanggal_penjualan); ?></td>
                                <td><?php echo e(optional($detail->transaksi)->no_nota); ?></td>
                                <td><?php echo e($detail->kode_barang); ?></td>
                                <td><?php echo e(optional($detail->barang)->nama_barang); ?></td>
                                <td><?php echo e($detail->harga); ?></td>
                                <td><?php echo e($detail->jumlah); ?></td>
                                <td><?php echo e($detail->subtotal); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
              
                <nav aria-label="Page navigation example" class="mt-3">
                    <ul class="pagination justify-content-end">
                        <!-- Pagination items -->
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    document.getElementById('resetFilter').addEventListener('click', function() {
        // Reset input values
        document.getElementById('filterFromDate').value = '';
        document.getElementById('filterToDate').value = '';
        document.getElementsByName('filterStatus')[0].selectedIndex = 0;

        // Submit the form to refresh the page with no filters applied
        document.getElementById('formFilter').submit();
    });
});
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Latihan\pkl\resources\views/kasir/detail_transaksi.blade.php ENDPATH**/ ?>