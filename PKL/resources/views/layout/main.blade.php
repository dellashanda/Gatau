<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Gunung Slamat</title>

    <!-- plugins:css -->
    <link rel="stylesheet" href="{{asset('skydash/vendors/feather/feather.css')}}">
    <link rel="stylesheet" href="{{asset('skydash/vendors/ti-icons/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{asset('skydash/vendors/css/vendor.bundle.base.css')}}">
    <!-- endinject -->

    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{asset('skydash/vendors/datatables.net-bs4/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{asset('skydash/vendors/ti-icons/css/themify-icons.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('skydash/js/select.dataTables.min.css')}}">
    <!-- End plugin css for this page -->

    <!-- inject:css -->
    <link rel="stylesheet" href="{{asset('skydash/css/vertical-layout-light/style.css')}}">

    <!-- endinject -->
    <link rel="shortcut icon" href="{{asset('skydash/images/logo_GS_1.png')}}" />

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- select2 -->
    <link href="{{ asset('skydash/vendors/select2/select2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('skydash/vendors/select2-bootstrap-theme/select2-bootstrap.min.css') }}">

    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->

    <!-- <link href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet"> -->

</head>

<body>
    <div class="container-scroller">
        @include('layout.navbar')
        <div class="container-fluid page-body-wrapper">
            @include('layout.setting_panel')

            @if(auth()->user()->role === 'admin')
                @include('admin.sidebar')
            @elseif(auth()->user()->role === 'kasir')
                @include('kasir.sidebar')
            @elseif(auth()->user()->role === 'kepala_toko')
                @include('kepala_toko.sidebar')
            @elseif(auth()->user()->role === 'ketua_koperasi')
                @include('ketua_koperasi.sidebar')
                @elseif(auth()->user()->role === 'keuangan')
                @include('keuangan.sidebar')
            @endif

            <div class="main-panel">
               <div class="content-wrapper">
                    @yield('content')
                </div> 
                @include('layout.footer')
            </div>
        </div>
    </div>

    <!-- plugins:js -->
    <script src="{{asset('skydash/vendors/js/vendor.bundle.base.js')}}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{asset('skydash/vendors/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('skydash/vendors/datatables.net/jquery.dataTables.js')}}"></script>
    <script src="{{asset('skydash/vendors/datatables.net-bs4/dataTables.bootstrap4.js')}}"></script>
    <script src="{{asset('skydash/js/dataTables.select.min.js')}}"></script>

    <!-- End plugin js for this page -->
    <!-- inject:js -->
     <script src="{{asset('skydash/js/off-canvas.js')}}"></script>
    <script src="{{asset('skydash/js/hoverable-collapse.js')}}"></script>
    <script src="{{asset('skydash/js/template.js')}}"></script>
    <script src="{{asset('skydash/js/settings.js')}}"></script>
    <script src="{{asset('skydash/js/todolist.js')}}"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="{{asset('skydash/js/dashboard.js')}}"></script>
    <script src="{{asset('skydash/js/Chart.roundedBarCharts.js')}}"></script>
    <!-- End custom js for this page-->

    <!-- datatables -->
    <!-- <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script> -->
    <script src="{{asset('skydash/vendors/datatables.net-bs4/dataTables.bootstrap4.js')}}"></script>
    <script src="{{asset('skydash/vendors/datatables.net/jquery.dataTables.js')}}"></script>


    <!-- select2 -->
    <script src="{{asset('skydash/vendors/select2/select2.min.js')}}"></script>
    <script src="{{asset('skydash/js/select2.js')}}"></script>

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>

</html>
