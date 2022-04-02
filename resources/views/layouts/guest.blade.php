{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body>
        <div class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </div>
    </body>
</html> --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Panzabi.com Tailors</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{'assets/alt/plugins/fontawesome-free/css/all.min.css'}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{'assets/alt/plugins/icheck-bootstrap/icheck-bootstrap.min.css'}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{'assets/alt/dist/css/adminlte.min.css'}}">
  <style>
      .font-medium.text-red-600 {
    color: red;
}

ul.mt-3.list-disc.list-inside.text-sm.text-red-600 {
    color: red;
}
ul.mt-3.list-disc.list-inside.text-sm.text-red-600 li {
    list-style: auto;
}
  </style>
</head>
<body class="hold-transition register-page">
    {{ $slot }}   
<!-- jQuery -->
<script src="{{'assets/alt/plugins/jquery/jquery.min.js'}}"></script>
<!-- Bootstrap 4 -->
<script src="{{'assets/alt/plugins/bootstrap/js/bootstrap.bundle.min.js'}}"></script>
<!-- AdminLTE App -->
<script src="{{'assets/alt/dist/js/adminlte.min.js'}}"></script>
</body>
</html>

