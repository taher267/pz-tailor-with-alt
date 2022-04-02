<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
  <!-- Theme style -->
  <link rel="stylesheet" href="{{config('app.url').'/assets/alt/dist/css/adminlte.min.css'}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{config('app.url').'/assets/alt/plugins/overlayScrollbars/css/OverlayScrollbars.min.css'}}">
  @livewireStyles
@stack('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed" data-panel-auto-height-mode="height">
<div class="wrapper">

{{$slot}}

<!-- jQuery -->
<script src="{{config('app.url').'/assets/alt/plugins/jquery/jquery.min.js'}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{config('app.url').'/assets/alt/plugins/jquery-ui/jquery-ui.min.js'}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{config('app.url').'/assets/alt/plugins/bootstrap/js/bootstrap.bundle.min.js'}}"></script>
<!-- overlayScrollbars -->
<script src="{{config('app.url').'/assets/alt/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js'}}"></script>
<!-- AdminLTE App -->
<script src="{{config('app.url').'/assets/alt/dist/js/adminlte.js'}}"></script>
<!-- AdminLTE for demo purposes -->
{{-- <script src="{{config('app.url').'/assets/alt/dist/js/demo.js'}}"></script> --}}
@livewireScripts
@stack('scripts')
</body>
</html>
