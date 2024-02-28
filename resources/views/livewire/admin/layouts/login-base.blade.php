<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MEDCAB | CARE</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <!-- <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css"> -->
  <!-- Theme style -->
  <!-- <link rel="stylesheet" href="dist/css/adminlte.min.css"> -->
  <link rel="stylesheet" href="{{url('backend_assets/plugins/fontawesome-free/css/all.min.css')}}">
  <link rel="stylesheet" href="{{url('backend_assets/css/adminlte.min.css')}}">
  <link rel="stylesheet" href="{{url('backend_assets/css/style.css')}}">
  <link rel="stylesheet" href="{{url('backend_assets/css/customStyle.css')}}">

  <link rel="stylesheet" href="{{url('backend_assets/css/select2-bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{url('backend_assets/css/select2.min.css')}}">
  <!-- <link rel="stylesheet" href="https://cdn.tailwindcss.com/3.4.1"> -->
   
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
        {{$slot}}
</div>
<!-- jQuery -->
<script src="{{url('backend_assets/js/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{url('backend_assets/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{url('backend_assets/js/adminlte.min.js')}}"></script>
<script src="{{url('backend_assets/js/select2.full.min.js')}}"></script>
 
</body>
</html>
