<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  @php
    $URL = config('app.url');
 @endphp
 {{-- "{!! config('app.name', 'Tailors-Panzabi.com')!!}" --}}
  <title>✂@yield('title',config('app.name', 'Tailors-Panzabi.com')), পাঞ্জাবী.কম | টেইলার্স</title>
  {{-- ✂️ --}}
  
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
  <!-- Theme style -->
  <link rel="stylesheet" href="{{$URL.'/assets/alt/dist/css/adminlte.min.css'}}">
  <link rel="stylesheet" href="{{$URL.'/css/responsive.css'}}">
  <link rel="stylesheet" href="/css/style.css">
  @livewireStyles
@stack('styles')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  @livewire('dashboard-top-nav-component')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @livewire('dashboard-sidebar-component')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    {{$slot}}
  </div>

  <!-- Content Wrapper. Contains page content -->

  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  @livewire('dashboard-right-sidebar')
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2021 <a href="#">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{$URL.'/assets/alt/plugins/jquery/jquery.min.js'}}"></script>
<!-- Bootstrap 4 -->
<script src="{{$URL.'/assets/alt/plugins/bootstrap/js/bootstrap.bundle.min.js'}}"></script>
<!-- AdminLTE App -->
<script src="{{$URL.'/assets/alt/dist/js/adminlte.min.js'}}"></script>
{{-- <script src="{{$URL.'/assets/alt/dist/js/demo.js'}}"></script> --}}
<script src="/assets/alt/plugins/sweetalert2/sweetalert2.min.js"></script>
<script>
  //Toastr
  var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
</script>
@livewireScripts
@stack('scripts')
</body>
</html>
