 
<div class="content">
  <div class="container-fluid mt-2">

  <div class="login-box card">
  <div class="card-body py-1 pb-3">
        <p class="login-box-msg">Sign in to start your session</p>
        @if (session()->has('message'))
            <div class="alert alert-warning">{{ session('message') }}</div>
        @endif
        <form wire:submit.prevent="loginForm">
          <div class="row">
            <div class="col">
            <div class="form-group">
                <label for="account">Login As</label>
                <select wire:model="login_as" class="custom-select rounded-0 form-control form-control-sm" id="account">
                    <option value="">Select</option>
                    <option value="Admin">Admin</option>
                    <option value="Telicaller">Telicaller</option>
                    <option value="Manager">Manager</option>
                </select>
                @error('login_as') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group mb-3">
                <input type="email" class="rounded-0 form-control-sm form-control" placeholder="Enter Your Email" wire:model="admin_id" />
                <div class="d-none input-group-append">
                    <div class=" input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
                @error('admin_id') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group mb-3">
                <input type="password" class="rounded-0 form-control-sm form-control" placeholder="Enter Your Password" wire:model="admin_pass" />
                <div class="d-none input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
                @error('admin_pass') <span class="text-danger">{{ $message }}</span> @enderror
                
                
            </div>
            @if (session()->has('access_error'))
                    <div class="mt-2 alert alert-danger">
                        {{ session('access_error') }}
                    </div>
                @endif
            <div class="row">
                <div class="col-12">
                    <button type="submit"
                       wire:loading.attr="disabled" 
                       class="mt-2 rounded-0 form-control form-control-sm btn-primary">
                       <i wire:loading wire:target="loginForm" class="fa fa-spinner fa-spin mt-2 ml-2"></i>Submit 
                    </button>
                </div>
            </div>
            </div>
        </form>

        <!-- /.social-auth-links -->
    </div>
    <!-- /.login-card-body -->
</div>
</div>
</div>
