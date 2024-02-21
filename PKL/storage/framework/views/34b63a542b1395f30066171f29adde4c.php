

<?php $__env->startSection('content'); ?>
<div class="col-lg-50 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-2"> 
                <h2 class="card-title" style="font-size: 1.5rem;">TABEL PENGAJUAN KREDIT</h2>
                
                <div class="d-flex">
                    <!-- <a href="#" class="btn btn-primary btn-sm rounded-2 ml-1">Excel</a> -->
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
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $counter = 1;
                        ?>

                        <?php $__empty_1 = true; $__currentLoopData = $pengajuan_kredits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pengajuan_kredit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                        <tr>
                            <td class="py-1"><?php echo e($counter++); ?></td>
                            <td><?php echo e($pengajuan_kredit->tanggal_pengajuan); ?></td>
                            <td><?php echo e($pengajuan_kredit->anggota->nama); ?></td>
                            <td><?php echo e($pengajuan_kredit->anggota->no_telp); ?></td>
                            <td><?php echo e(ucfirst($pengajuan_kredit->jenis_pengajuan)); ?></td>
                            <td class="text-left">
                                <?php if($pengajuan_kredit->jenis_pengajuan == 'uang'): ?>
                                    Nominal : <?php echo e(number_format($pengajuan_kredit->nominal, 0, ',', ',')); ?>

                                <?php elseif($pengajuan_kredit->jenis_pengajuan == 'barang'): ?>
                                    <div class="mb-1">
                                        Nama Barang: <?php echo e($pengajuan_kredit->nama_barang); ?>

                                    </div>
                                    <div class="mb-1">
                                        Merk: <?php echo e($pengajuan_kredit->merk); ?>

                                    </div>
                                    <div>
                                        Jenis: <?php echo e($pengajuan_kredit->jenis_barang); ?>

                                    </div>
                                <?php else: ?>
                                    Deskripsi Tidak Diketahui
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="<?php echo e(route('keuangan.setujuiPengajuan', ['id' => $pengajuan_kredit->id])); ?>" class="btn btn-primary btn-sm rounded-2" onclick="return confirm('Apakah Anda yakin ingin menyetujui pengajuan ini?')">Setujui</a>
                                    <a href="<?php echo e(route('keuangan.tolakPengajuan', ['id' => $pengajuan_kredit->id])); ?>" class="btn btn-danger btn-sm rounded-2" onclick="return confirm('Apakah Anda yakin ingin menolak pengajuan ini?')">Tolak</a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7">Tidak ada data pengajuan kredit.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Latihan\pkl\resources\views/keuangan/pengajuan_kredit.blade.php ENDPATH**/ ?>