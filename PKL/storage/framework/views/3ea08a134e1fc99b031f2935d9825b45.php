

<?php $__env->startSection('content'); ?>
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
                        <form class="forms-sample" method="POST" action="<?php echo e(route('kasir.entryPengajuan')); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <label for="tanggal_pengajuan">Tanggal Pengajuan</label>
                            <input type="date" class="form-control" id="tanggal_pengajuan" name="tanggal_pengajuan">
                        </div>
                        <div class="form-group">
                            <label for="id_anggota">Anggota Koperasi</label>
                            <div>
                                <select class="form-control" id="id_anggota" name="id_anggota">
                                    <option value="" selected disabled></option>
                                    <?php $__currentLoopData = $anggotaKoperasi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $anggota): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($anggota->nik); ?>"><?php echo e($anggota->nama); ?> - <?php echo e($anggota->nik); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                        <?php
                            $counter = 1;
                        ?>

                        <?php $__currentLoopData = $pengajuan_kredits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pengajuan_kredit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

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
                            <td class="font-weight-medium">
                                <div class="badge 
                                    <?php echo e($pengajuan_kredit->status == 'Menunggu' ? 'badge-warning' : 
                                    ($pengajuan_kredit->status == 'Disetujui' ? 'badge-success' : 
                                    ($pengajuan_kredit->status == 'Ditolak' ? 'badge-danger' : 'badge-secondary'))); ?>">
                                    <?php echo e($pengajuan_kredit->status); ?>

                                </div>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary btn-sm rounded-2 btn-edit" data-toggle="modal" data-target="#modalEditPengajuan_<?php echo e($pengajuan_kredit->id); ?>" data-id="<?php echo e($pengajuan_kredit->id); ?>">Edit</button>
                                    <a href="<?php echo e(route('deletePengajuan', ['id' => $pengajuan_kredit->id])); ?>" class="btn btn-danger btn-sm rounded-2" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</a>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal Edit Pengajuan -->
                        <div class="modal fade" id="modalEditPengajuan_<?php echo e($pengajuan_kredit->id); ?>" tabindex="-1" role="dialog" aria-labelledby="modal_label" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title" id="modal">Edit Data Pengajuan</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body">
                                  <form class="form-editPengajuan" method="POST" action="<?php echo e(route('kasir.updatePengajuan', ['id' => $pengajuan_kredit->id])); ?>" id="formEditPengajuan" enctype="multipart/form-data">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PUT'); ?>
                                    <input type="hidden" name="id" id="id" value="<?php echo e($pengajuan_kredit->id); ?>">
                                    <div class="form-group">
                                        <label for="tanggal_pengajuan">Tanggal Pengajuan</label>
                                        <input type="date" class="form-control" id="tanggal_pengajuan" name="tanggal_pengajuan" value="<?php echo e($pengajuan_kredit->tanggal_pengajuan); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="id_anggota">Anggota Koperasi</label>
                                        <div>
                                            <select class="form-control" id="id_anggota" name="id_anggota">
                                                <option value="" selected disabled></option>
                                                <?php $__currentLoopData = $anggotaKoperasi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $anggota): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($anggota->nik); ?>" <?php if($pengajuan_kredit->anggota->nama == $anggota->nama): ?> selected <?php endif; ?>>
                                                        <?php echo e($anggota->nama); ?> - <?php echo e($anggota->nik); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="jenis_pengajuan">Jenis Pengajuan</label>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                            <input type="radio" class="form-check-input" id="edit_jenis_pengajuan_uang" name="jenis_pengajuan" value="uang" <?php echo e($pengajuan_kredit->jenis_pengajuan == 'uang' ? 'checked' : ''); ?>>
                                            Uang
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                            <input type="radio" class="form-check-input" id="edit_jenis_pengajuan_barang" name="jenis_pengajuan" value="barang" <?php echo e($pengajuan_kredit->jenis_pengajuan == 'barang' ? 'checked' : ''); ?>>
                                            Barang
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Tampilkan field nominal jika jenis pengajuan adalah uang -->
                                    <div id="uangFields" style="display:<?php echo e($pengajuan_kredit->jenis_pengajuan == 'uang' ? 'block' : 'none'); ?>">
                                        <label style="font-weight: bold;">Uang</label>
                                        <div class="form-group">
                                            <label for="nominal">Nominal</label>
                                            <input type="number" class="form-control" id="nominal" name="nominal" placeholder="Nominal" value="<?php echo e($pengajuan_kredit->nominal); ?>">
                                        </div>
                                    </div>

                                    <!-- Tampilkan field barang jika jenis pengajuan adalah barang -->
                                    <div id="barangFields" style="display:<?php echo e($pengajuan_kredit->jenis_pengajuan == 'barang' ? 'block' : 'none'); ?>">
                                        <label style="font-weight: bold;">Barang</label>
                                        <div class="form-group">
                                            <label for="nama_barang">Nama Barang</label>
                                            <input type="text" class="form-control" id="nama_barang" name="nama_barang" placeholder="Nama Barang" value="<?php echo e($pengajuan_kredit->nama_barang); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="merk">Merk</label>
                                            <input type="text" class="form-control" id="merk" name="merk" placeholder="Merk" value="<?php echo e($pengajuan_kredit->merk); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="jenis_barang">Jenis</label>
                                            <input type="text" class="form-control" id="jenis_barang" name="jenis_barang" placeholder="Jenis" value="<?php echo e($pengajuan_kredit->jenis_barang); ?>">
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                                  </form>
                                </div>
                            </div>
                        </div>
                    </div>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
            var editUrl = '<?php echo e(url("kasir/update-pengajuan")); ?>/' + id;

            // Perbarui action form berdasarkan ID pengajuan kredit
            $('#formEditPengajuan_' + id).attr('action', editUrl);

            // Lakukan AJAX request untuk mendapatkan data dan isi form
            $.ajax({
                url: '<?php echo e(url("kasir/get-pengajuan")); ?>/' + id,
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


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Latihan\pkl\resources\views/kasir/pengajuan_kredit.blade.php ENDPATH**/ ?>