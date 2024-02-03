<section class="content">
  <div class="container-fluid">
    <!-- SELECT2 EXAMPLE -->

    <!-- /.card -->
    <div class="card text-center">
      <div class="card-header pt-1 pb-3">
        <ul class="nav nav-tabs custom__nav__tab  card-header-tabs">
          <li class="nav-item">
            <a class="nav-link fs-1 active" href="/driver" wire:navigate>All </a>
          </li>
          <li class="nav-item">
            <a class="nav-link fs-1" href="/manage-driver" wire:navigate class="nav-link">Add</a>
          </li>
          <li class="nav-item">
            <a class="nav-link fs-1" href="#">Devision</a>
          </li>
          <li class="nav-item">
            <a class="nav-link fs-1" href="#">District</a>
          </li>
          <li class="nav-item">
            <a class="nav-link fs-1" href="#">Under Reg.</a>
          </li>
          <li class="nav-item">
            <a class="nav-link fs-1" href="#">Under FRC</a>
          </li>
          <li class="nav-item">
            <a class="nav-link fs-1" href="#">Active</a>
          </li>
          <li class="nav-item">
            <a class="nav-link fs-1" href="#">On Duty</a>
          </li>
          <li class="nav-item">
            <a class="nav-link fs-1" href="#">Off Duty</a>
          </li>
          <li class="nav-item">
            <a class="nav-link fs-1" href="#">Verify By driver</a>
          </li>

          <li class="nav-item">
            <a class="nav-link fs-1" href="#">Verify By Partner</a>
          </li>
        </ul>
      </div>

    </div>
    <!-- /.row -->
  </div>
  <div class="container-fluid">
    <!-- SELECT2 EXAMPLE -->
    <div class="card card-default">
      <div class="card-header">
        <h3 class="card-title">Add Driver</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool" data-card-widget="remove">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>



      <!-- /.card-header -->
      <div class="card-body">
        @if($addDriver)
        <div class="callout callout-info">
          <h5>Driver info</h5>
          <hr>
          <h6>Name</h6>
          <p>{{ $driverDataStep1->driver_name ?? $driverDataStep1->driver_name}} {{ $driverDataStep1->driver_last_name ?? $driverDataStep1->driver_last_name}}</p>
          <h6>Mobile no.</h6>
          <p>{{ $driverDataStep1->driver_mobile ?? $driverDataStep1->driver_mobile }} </p>
        </div>
        @endif

        @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
        @endif


        <form>
          <div class="row">
            <div class="col-3">

              <div class="form-group">
                <label>Create Driver (For)</label>

                <select wire:change="partners()" wire:model="create_for" class="custom-select rounded-0 form-control form-control-sm" id="exampleSelectRounded0">
                  <option selected value="0">Self</option>
                  <option value="1">Partner</option>
                </select>
              </div>
            </div>
            <div class="col-3">
              <div class="form-group">
                <label for="name">Candidate Name
                </label>
                <select {{ !$isPartner ? 'disabled' : '' }} wire:model="partner_id" class="custom-select rounded-0 form-control form-control-sm" id="exampleSelectRounded0">
                  <option>Select name</option>
                  @if($isPartner)
                  @foreach ($partners as $list)
                  <option value="{{$list->partner_id}}">{{$list->partner_f_name.' '.$list->partner_l_name.' ('.$list->partner_mobile.')'}}</option>
                  @endforeach
                  @endif
                </select>

                @error('partner_id') <span class="text-danger">Name field is required</span> @enderror
              </div>
            </div>
            <div class="col-3">
              <div class="form-group">
                <label for="driver_first_name">Driver Name</label>
                <input wire:model="driver_first_name" type="text" class="rounded-0 form-control form-control-sm" id="driver_first_name" placeholder="Enter name Id">
                @error('driver_first_name') <span class="text-danger">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-3">
              <div class="form-group">
                <label for="driver_last_name">Driver Last Name</label>
                <input wire:model="driver_last_name" type="text" class="rounded-0 form-control form-control-sm" id="driver_last_name" placeholder="Enter last name">
                @error('driver_last_name') <span class="text-danger">{{ $message }}</span> @enderror
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label for="driver_mobile">Driver Mobile</label>
                <input wire:model="driver_mobile" type="text" class="rounded-0 form-control form-control-sm" id="driver_mobile" placeholder="Enter Driver Mobile">
                @error('driver_mobile') <span class="text-danger">{{ $message }}</span> @enderror

              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label for="vehicle_rc_no">Vehicle RC No.</label>
                <input wire:model="vehicle_rc_no" type="text" class="rounded-0 form-control form-control-sm" id="vehicle_rc_no" placeholder="Enter Vehicle RC No.">
                @error('vehicle_rc_no') <span class="text-danger">{{ $message }}</span> @enderror
              </div>
            </div>
            Loading:: <div wire:loading.delay>Loading..</div>
          </div>
          <!-- <input type="hidden" wire:model="id"> -->
          <div class="row">
            <div class="col-2">
              <div class="form-group">
                <button wire:click.prevent="store()" wire:loading.attr="disabled" class="rounded-0 form-control form-control-sm btn-primary">Save
                  <div wire:loading.delay.longer>Saving..</div>
                </button>
              </div>
            </div>
          </div>
        </form>
        <!-- /.row -->
        {{$isPartner ? 'isPartner' : 'noisPartner'}}
        {{$addDriver}}
        <!-- /.row -->
      </div>
      <!-- /.card-body -->

    </div>
    <!-- /.card -->

    <!-- /.row -->
  </div>

  <!-- /.container-fluid -->
</section>