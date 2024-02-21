<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Gunung Slamat</title>

    <!-- plugins:css -->
    <link rel="stylesheet" href="<?php echo e(asset('skydash/vendors/feather/feather.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('skydash/vendors/ti-icons/css/themify-icons.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('skydash/vendors/css/vendor.bundle.base.css')); ?>">
    <!-- endinject -->

    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="<?php echo e(asset('skydash/vendors/datatables.net-bs4/dataTables.bootstrap4.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('skydash/vendors/ti-icons/css/themify-icons.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('skydash/js/select.dataTables.min.css')); ?>">
    <!-- End plugin css for this page -->

    <!-- inject:css -->
    <link rel="stylesheet" href="<?php echo e(asset('skydash/css/vertical-layout-light/style.css')); ?>">

    <!-- endinject -->
    <link rel="shortcut icon" href="<?php echo e(asset('skydash/images/logo_GS_1.png')); ?>" />

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- select2 -->
    <link href="<?php echo e(asset('skydash/vendors/select2/select2.min.css')); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('skydash/vendors/select2-bootstrap-theme/select2-bootstrap.min.css')); ?>">

    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->

    <!-- <link href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet"> -->

</head>

<body>
    <div class="container-scroller">
        <?php echo $__env->make('layout.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="container-fluid page-body-wrapper">
            <?php echo $__env->make('layout.setting_panel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <?php if(auth()->user()->role === 'admin'): ?>
                <?php echo $__env->make('admin.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php elseif(auth()->user()->role === 'kasir'): ?>
                <?php echo $__env->make('kasir.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php elseif(auth()->user()->role === 'kepala_toko'): ?>
                <?php echo $__env->make('kepala_toko.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php elseif(auth()->user()->role === 'ketua_koperasi'): ?>
                <?php echo $__env->make('ketua_koperasi.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php elseif(auth()->user()->role === 'keuangan'): ?>
                <?php echo $__env->make('keuangan.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>

            <div class="main-panel">
               <div class="content-wrapper">
                    <?php echo $__env->yieldContent('content'); ?>
                </div> 
                <?php echo $__env->make('layout.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    </div>

    <!-- plugins:js -->
    <script src="<?php echo e(asset('skydash/vendors/js/vendor.bundle.base.js')); ?>"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="<?php echo e(asset('skydash/vendors/chart.js/Chart.min.js')); ?>"></script>
    <script src="<?php echo e(asset('skydash/vendors/datatables.net/jquery.dataTables.js')); ?>"></script>
    <script src="<?php echo e(asset('skydash/vendors/datatables.net-bs4/dataTables.bootstrap4.js')); ?>"></script>
    <script src="<?php echo e(asset('skydash/js/dataTables.select.min.js')); ?>"></script>

    <!-- End plugin js for this page -->
    <!-- inject:js -->
     <script src="<?php echo e(asset('skydash/js/off-canvas.js')); ?>"></script>
    <script src="<?php echo e(asset('skydash/js/hoverable-collapse.js')); ?>"></script>
    <script src="<?php echo e(asset('skydash/js/template.js')); ?>"></script>
    <script src="<?php echo e(asset('skydash/js/settings.js')); ?>"></script>
    <script src="<?php echo e(asset('skydash/js/todolist.js')); ?>"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="<?php echo e(asset('skydash/js/dashboard.js')); ?>"></script>
    <script src="<?php echo e(asset('skydash/js/Chart.roundedBarCharts.js')); ?>"></script>
    <!-- End custom js for this page-->

    <!-- datatables -->
    <!-- <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script> -->
    <script src="<?php echo e(asset('skydash/vendors/datatables.net-bs4/dataTables.bootstrap4.js')); ?>"></script>
    <script src="<?php echo e(asset('skydash/vendors/datatables.net/jquery.dataTables.js')); ?>"></script>


    <!-- select2 -->
    <script src="<?php echo e(asset('skydash/vendors/select2/select2.min.js')); ?>"></script>
    <script src="<?php echo e(asset('skydash/js/select2.js')); ?>"></script>

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>

</html>
<?php /**PATH D:\Latihan\pkl\resources\views/layout/main.blade.php ENDPATH**/ ?>