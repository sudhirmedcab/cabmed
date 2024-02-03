<section class="content">
<div class="container-fluid">
        <!-- SELECT2 EXAMPLE -->
       
        <!-- /.card -->
        <div class="card text-center">
          <div class="card-header pt-1 pb-3">
            <ul class="nav nav-tabs custom__nav__tab  card-header-tabs">
              <li class="nav-item">
                <a class="nav-link fs-1 active" href="/driver" wire:navigate >All </a>
              </li>
              <li class="nav-item">
                <a class="nav-link fs-1" href="/manage-driver" wire:navigate class="nav-link" >Add</a>
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
              </li><li class="nav-item">
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
          step1 {{$step1}}
          step2 {{$step2}}
          <div class="card-body"> 
         
           @if($step1Data)
                  <div class="callout callout-info">
                  <h5>step1 data Driver info</h5><hr>
                    <h6>Name</h6>
                    <p>{{ $driverDataStep1->driver_name ?? $driverDataStep1->driver_name}} {{ $driverDataStep1->driver_last_name ?? $driverDataStep1->driver_last_name}}</p>
                    <h6>Mobile no.</h6>
                    <p>{{ $driverDataStep1->driver_mobile ?? $driverDataStep1->driver_mobile }} </p>
                    <h6>Vehicle RC No.</h6>
                      <p>{{ $vehicle_rc_no ?? $this->vehicle_rc_no }}</p>
                </div>
                @endif
                @if($step2Data)
                  <div class="callout callout-info">
                  <h5>step2 data </h5><hr>
                    <h6>Driver Image</h6>
                    <p>
                      <img src="{{ asset('assets/driver/1433_driver_profile1706452946.jpg') }}">
                    </p>
                    <h6>City.</h6>
                    <p>city name</p>
                  </div>
                @endif
                @if($step3Data)
                  <div class="callout callout-info">
                  <h5>step3 data Driver Image</h5><hr>
                  <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                          <label for="driver_mobile">Driver DL(Front)</label>
                          <img src="{{ asset($driverDataStep3->driver_details_dl_front_img ?? $driverDataStep3->driver_details_dl_front_img) }}">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                          <label for="driver_mobile">Driver DL(Front)</label>
                          <img src="{{ asset($driverDataStep3->driver_details_dl_front_img ?? $driverDataStep3->driver_details_dl_front_img) }}">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                          <label for="driver_mobile">Driver DL(Back)</label>
                          <img src="{{ asset($driverDataStep3->driver_details_dl_back_image ?? $driverDataStep3->driver_details_dl_back_image) }}">
                        </div>
                    </div>
                   </div>
                   <div class="col-4">
                        <div class="form-group">
                          <label for="driver_mobile">Driver DL(Back)</label>
                          <img src="{{ asset($driverDataStep3->driver_details_dl_back_image ?? $driverDataStep3->driver_details_dl_back_image) }}">
                        </div>
                    </div>
                   </div>
                </div>
                @endif
                @if($step4Data)
                  <div class="callout callout-info">
                  <h5>step4 data Driver Image</h5><hr>
                    <h6>Name</h6>
                    <p>{{ $driverDataStep1->driver_name ?? $driverDataStep1->driver_name}} {{ $driverDataStep1->driver_last_name ?? $driverDataStep1->driver_last_name}}</p>
                    <h6>Mobile no.</h6>
                    <p>{{ $driverDataStep1->driver_mobile ?? $driverDataStep1->driver_mobile }} </p>
                    <h6>Vehicle RC No.</h6>
                      <p>{{ $vehicle_rc_no ?? $this->vehicle_rc_no }}</p>
                </div>
                @endif

                @if($step5Data)
                  <div class="callout callout-info">
                  <h5>step5 data Driver Image</h5><hr>
                    <h6>Name</h6>
                    <p>{{ $driverDataStep1->driver_name ?? $driverDataStep1->driver_name}} {{ $driverDataStep1->driver_last_name ?? $driverDataStep1->driver_last_name}}</p>
                    <h6>Mobile no.</h6>
                    <p>{{ $driverDataStep1->driver_mobile ?? $driverDataStep1->driver_mobile }} </p>
                    <h6>Vehicle RC No.</h6>
                      <p>{{ $vehicle_rc_no ?? $this->vehicle_rc_no }}</p>
                </div>
                @endif
        @if (session()->has('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif
        @if($step1)
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
                        <select {{ !$isPartner ? 'disabled' : '' }}  wire:model="partner_id" class="custom-select rounded-0 form-control form-control-sm" id="exampleSelectRounded0">
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
                        <input {{ $isPartner ? 'disabled' : '' }} wire:model="vehicle_rc_no" type="text" class="rounded-0 form-control form-control-sm" id="vehicle_rc_no" placeholder="Enter Vehicle RC No.">
                        @error('vehicle_rc_no') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    </div>
                   </div>
                    <!-- <input type="hidden" wire:model="id"> -->
                    <div class="row">
                    <div class="col-2">
                    <div class="form-group">
                      <button 
                       wire:click.prevent="store()"
                       wire:loading.attr="disabledl" 
                       class="rounded-0 form-control form-control-sm btn-primary">Save
                       </button>
                      </div>
                    </div>
                    </div>
                </form>
                @endif
            <!-- /.row -->
 <!-- {{$isPartner ? 'isPartner' : 'noisPartner'}}
  {{$step1}} -->
            <!-- /.row -->
 
        @if($step2)
             <form wire:submit.prevent="step2Form">
           
            <div class="row">
                  <div class="col-6">
                      <div class="form-group">
                          <label for="driver_profile_img">Driver Image</label>
                          <input wire:model="driver_profile_img" type="file" class="rounded-0 form-control form-control-sm" id="driver_image" placeholder="Enter Driver Mobile">
                          @error('driver_profile_img') <span class="text-danger">{{ $message }}</span> @enderror
                      </div>
                    </div>
                    <div class="col-6">
                  <div class="form-group">
                      <label for="vehicle_rc_no">City</label>
                      <select wire:model="driver_city" wire:loading.attr="disabled" wire:target="driver_city" class="custom-select rounded-0 form-control form-control-sm" id="exampleSelectRounded0">
                          @forelse ($city as $list)
                              <option value="{{ $list->city_id }}">{{ $list->city_name }}</option>
                          @empty
                              <option value="" disabled>No cities available</option>
                          @endforelse
                      </select>
                      @error('driver_city') <span class="text-danger">{{ $message }}</span> @enderror
                  </div>
                </div>
 
                  </div>
                    <input type="hidden" wire:model="driver_id">
                    <div class="row">
                    <div class="col-2">
                    <div class="form-group">
                      <button type="submit"
                       wire:loading.attr="disabled" 
                       class="rounded-0 form-control form-control-sm btn-primary">Save
                       </button>
                      </div>
                    </div>
                    </div>
                </form>
                @endif

                @if($step3)
             <form wire:submit.prevent="step3Form">
             <div class="row">
             <div class="col-4">
                    <div class="form-group">
                        <label for="driver_dl_front">Driver DL (Front)</label>
                        <input wire:model="driver_dl_front" type="file" class="rounded-0 form-control form-control-sm" id="driver_image" placeholder="Enter Driver Mobile">
                        @error('driver_dl_front') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-4">
                    <div class="form-group">
                        <label for="driver_dl_back">Driver DL (Back)</label>
                        <input wire:model="driver_dl_back" type="file" class="rounded-0 form-control form-control-sm" id="driver_image" placeholder="Enter Driver Mobile">
                        @error('driver_dl_back') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-4">
                    <div class="form-group">
                        <label for="driver_profile_img">Expiry Date</label>
                        <input wire:model="driver_dl_expiry" type="date" class="rounded-0 form-control form-control-sm" id="driver_image" placeholder="Enter Driver Mobile">
                        @error('driver_dl_expiry') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    
                   </div>
                    <div class="row">
                    <input type="hidden" wire:model="driver_id">
                    <div class="col-2">
                    <div class="form-group">
                      <button type="submit"
                       wire:loading.attr="disabled" 
                       class="rounded-0 form-control form-control-sm btn-primary">Save
                       </button>
                      </div>
                    </div>
                    </div>
                </form>
                @endif
                
                @if($step4)
             <form wire:submit.prevent="step4Form">
             <div class="row">
             <div class="col-4">
                    <div class="form-group">
                        <label for="driver_adhar_front">Driver Adhar (Front)</label>
                        <input wire:model="driver_adhar_front" type="file" class="rounded-0 form-control form-control-sm" id="driver_image" placeholder="Enter Adhar front">
                        @error('driver_adhar_front') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-4">
                    <div class="form-group">
                        <label for="driver_adhar_back">Driver Adhar (Back)</label>
                        <input wire:model="driver_adhar_back" type="file" class="rounded-0 form-control form-control-sm" id="driver_adhar_back" placeholder="Enter Adhar Back">
                        @error('driver_adhar_back') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-4">
                    <div class="form-group">
                        <label for="driver_adhar_no">Adhar Number</label>
                        <input wire:model="driver_adhar_no" type="text" class="rounded-0 form-control form-control-sm" id="driver_adhar_no" placeholder="Enter Adhar number">
                        @error('driver_adhar_no') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    
                  </div>
                    <!-- <input type="hidden" wire:model="id"> -->
                    <div class="row">
                    <div class="col-2">
                    <div class="form-group">
                      <button type="submit"
                       wire:loading.attr="disabled" 
                       class="rounded-0 form-control form-control-sm btn-primary">Save
                       </button>
                      </div>
                    </div>
                    </div>
                </form>
                @endif

                
                @if($step5)
             <form wire:submit.prevent="step5Form">
             <div class="row">
                  <div class="col-6">
                    <div class="form-group">
                        <label for="driver_pan_front">Driver Pan (Front)</label>
                        <input wire:model="driver_pan_front" type="file" class="rounded-0 form-control form-control-sm" id="driver_image" placeholder="Enter Driver Mobile">
                        @error('driver_pan_front') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                  </div>
                  
                  <div class="col-6">
                    <div class="form-group">
                        <label for="driver_pan_no">Driver Pan no</label>
                        <input wire:model="driver_pan_no" type="text" class="rounded-0 form-control form-control-sm" id="driver_image" placeholder="Enter Driver Mobile">
                        @error('driver_pan_no') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-6">
                    <div class="form-group">
                        <label for="driver_police_verification">Driver Police verification image</label>
                        <input wire:model="driver_police_verification" type="file" class="rounded-0 form-control form-control-sm" id="driver_image" placeholder="Enter Driver Mobile">
                        @error('driver_police_verification') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                  </div>
                  
                  <div class="col-6">
                    <div class="form-group">
                        <label for="driver_police_verification_expiry">Driver Police Verification Expiry</label>
                        <input wire:model="driver_police_verification_expiry" type="text" class="rounded-0 form-control form-control-sm" id="driver_image" placeholder="Enter Driver Mobile">
                        @error('driver_police_verification_expiry') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                  </div>
              </div>
                    <!-- <input type="hidden" wire:model="id"> -->
                    <div class="row">
                    <div class="col-2">
                    <div class="form-group">
                      <button type="submit"
                       wire:loading.attr="disabled" 
                       class="rounded-0 form-control form-control-sm btn-primary">Save
                       </button>
                      </div>
                    </div>
                    </div>
                </form>
                @endif

            <!-- /.row -->

          </div>
          <!-- /.card-body -->
          
        </div>
        <!-- /.card -->
 
        <!-- /.row -->
      </div>

      <!-- /.container-fluid -->
    </section>