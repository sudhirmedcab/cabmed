<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin || Log in</title>
  @livewireStyles
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <!-- <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css"> -->
  <!-- Theme style -->
  <!-- <link rel="stylesheet" href="dist/css/adminlte.min.css"> -->
  
  <link rel="stylesheet" href="{{url('backend_assets/plugins/fontawesome-free/css/all.min.css')}}">
  <link rel="stylesheet" href="{{url('backend_assets/css/adminlte.min.css')}}">
  <!-- <link rel="stylesheet" href="{{url('backend_assets/css/style.css')}}"> -->
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
          <b>Medcab Admin</b>
  </div>
  <!-- /.login-logo -->
      <div class="toastrMsg">
            @if(Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ Session::get('success') }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
         </div>


      <div class="card">
        <div class="card-body login-card-body">
          <p class="login-box-msg">Sign in to start your session</p>

          <form wire:submit="login">

              <div class="toastrMsg">
                  @if(Session::has('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{ Session::get('error') }}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
               </div>


                <div class="input-group mb-3">
                  <input type="email" class="form-control" placeholder="Enter the Your Email" autocomplete="off" wire:model="admin_id"  />
                            @error("admin_id")  <p class="pt-2 px-1 text-danger">{{$message }}</p> 
                            @enderror
                      <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                      </div>
                  </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Enter Your Password" autocomplete="off" wire:model="admin_pass"  />
                            @error("form.admin_pass")  <p class="pt-2 px-1 text-danger">{{ 
                            str_replace('form.admin_pass', 'admin_pass', $message) }}</p>  @enderror
                          <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-lock"></span>
                    </div>
                  </div>
                </div>
                  <div class="row float-right">
                    <!-- /.col -->
                    <div class="col-4">
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    <!-- /.col -->
                  </div>
          </form>

          <!-- /.social-auth-links -->
        </div>
        <!-- /.login-card-body -->
      </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
 <!-- Bootstrap 4 -->
 <!-- AdminLTE App -->
 

<script src="{{url('backend_assets/js/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{url('backend_assets/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{url('backend_assets/js/adminlte.min.js')}}"></script>
@livewireScripts
</body>
</html>
