<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  @php
   $URL = config('app.url');
  @endphp
  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
  <!-- Theme style -->
  <link rel="stylesheet" href="{{$URL.'/assets/alt/dist/css/adminlte.min.css'}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{$URL.'/assets/alt/plugins/overlayScrollbars/css/OverlayScrollbars.min.css'}}">
  @livewireStyles
@stack('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed" data-panel-auto-height-mode="height">
<div class="wrapper">
  <!-- Navbar -->
  @livewire('dashboard-top-nav-component');
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @livewire('dashboard-sidebar-component');
{{$slot}}
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper iframe-mode" data-widget="iframe" data-loading-screen="750">
    <div class="nav navbar navbar-expand navbar-white navbar-light border-bottom p-0">
      <div class="nav-item dropdown">
        <a class="nav-link bg-danger dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Close</a>
        <div class="dropdown-menu mt-0">
          <a class="dropdown-item" href="#" data-widget="iframe-close" data-type="all">Close All</a>
          <a class="dropdown-item" href="#" data-widget="iframe-close" data-type="all-other">Close All Other</a>
        </div>
      </div>
      <a class="nav-link bg-light" href="#" data-widget="iframe-scrollleft"><i class="fas fa-angle-double-left"></i></a>
      <ul class="navbar-nav overflow-hidden" role="tablist"></ul>
      <a class="nav-link bg-light" href="#" data-widget="iframe-scrollright"><i class="fas fa-angle-double-right"></i></a>
      <a class="nav-link bg-light" href="#" data-widget="iframe-fullscreen"><i class="fas fa-expand"></i></a>
    </div>
    <div class="tab-content">
      <div class="tab-empty">
        <h2 class="display-4">No tab selected!</h2>
      </div>
      <div class="tab-loading">
        <div>
          <h2 class="display-4">Loading <i class="fa fa-sync fa-spin"></i></h2>
        </div>
      </div>
    </div>
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="#">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{$URL.'/assets/alt/plugins/jquery/jquery.min.js'}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{$URL.'/assets/alt/plugins/jquery-ui/jquery-ui.min.js'}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{$URL.'/assets/alt/plugins/bootstrap/js/bootstrap.bundle.min.js'}}"></script>
<!-- overlayScrollbars -->
<script src="{{$URL.'/assets/alt/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js'}}"></script>
<!-- AdminLTE App -->
<script src="{{$URL.'/assets/alt/dist/js/adminlte.js'}}"></script>
<!-- AdminLTE for demo purposes -->
{{-- <script src="{{$URL.'/assets/alt/dist/js/demo.js'}}"></script> --}}
@livewireScripts
@stack('scripts')
</body>
</html>
