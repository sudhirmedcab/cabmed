<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>404 ERROR</title>

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
<body>
   <!-- Main content -->
   <section class="content">
      <div class="error-page">
        <h2 class="headline text-warning"> 404</h2>

        <div class="error-content">
          <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page not found.</h3>

          <p>
            We could not find the page you were looking for.
            Meanwhile, you may <a href="../../index.html">return to dashboard</a> or try using the search form.
          </p>

          <form class="search-form">
            <div class="input-group">
              <input type="text" name="search" class="form-control" placeholder="Search">

              <div class="input-group-append">
                <button type="submit" name="submit" class="btn btn-warning"><i class="fas fa-search"></i>
                </button>
              </div>
            </div>
            <!-- /.input-group -->
          </form>
        </div>
        <!-- /.error-content -->
      </div>
      <!-- /.error-page -->
    </section>
    <!-- /.content -->
</body>
</html>
