<div class="container-fluid">
    <!-- Add driver -->
    <div class="card card-default add__driver__form">
      <!-- .......1....... -->
      <div class="card-header align-items-center d-flex">
        <h3 class="card-title">Auto Search the Nearest Driver</h3>
        <div class="card-tools d-flex align-items-center ml-auto">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool">
          </button>
          <div class="col-3 ml-auto d-flex align-items-end justify-content-end">
            <a href="#" class="submit__btn text-primary font-weight-bold my-1 d-flex align-items-center justify-content-center">
            Submit
            </a>
          </div>
        </div>
      </div>
      <!-- /.card-header -->
      @if (session()->has('message'))
      <div class="alert alert-success alert-dismissible" role="alert">
        <span type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></span>
        <strong>{{ session('message') }}!</strong>
       </div>
            @endif

            <div class="card ">
        <div class="card-header custom__filter__select ">
          <form wire:submit.prevent="autoSearchBookingStep1Form" class="mb-5">
            <div class="row">
                <div class="col-6 col-sm-auto col-md-4">
                    <div class="form-group">
                        <label class="custom__label" for="fromDate">Enter Address </label>
                        <input wire:model="pickup_address" autocomplete type="text" class="custom__input__field rounded-0 form-control form-control-sm" id="pickup_address" placeholder="Enter the Pick Up Address">
                        <input type="hidden" wire:model="pickup__address" id="p_latitude" wire:ignore>
                        <input type="hidden" wire:model="p_latitude" id="p_latitude" wire:ignore>
                        <input type="hidden" wire:model="p_longitude" id="p_longitude" wire:ignore>
                     @error('pickup__address') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-6 col-sm-auto col-md-2">
                    <div class="form-group">
                        <label class="custom__label">Select Duty</label>
                        <select  wire:model="driver_duty_status"  class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="driver_duty_status">
                            <!-- <option  value="">Choose Driver</option> -->
                            <option selected value="All">All Driver</option>
                            <option value="ON">ON Duty Driver</option>
                            <option value="OFF">OFF Duty Driver</option>
                        </select>
                        @error('driver_duty_status') <span class="text-danger">{{ $message }}</span> @enderror
                     </div>
                </div>
                <div class="col-6 col-sm-auto col-md-2">
                    <div class="form-group">
                        <label class="custom__label">Select Category Name</label>
                        <select  wire:model="SelecetdCategory" class="custom__input__field custom-select rounded-0 form-control form-control-sm">
                           <option  value="" selected>All Category</option>
                          @foreach ($ambulanceCategory as $category)
                              <option  value="{{$category->ambulance_category_type}}">{{$category->ambulance_category_name}}</option>
                          @endforeach
                        </select>
                        @error('SelecetdCategory') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

                @if (!is_null($SelecetdCategory))
                <div class="col-6 col-sm-auto col-md-2">
                    <div class="form-group">
                        <label class="custom__label">Select Vehicle name</label>
                            <select wire:model="vehicleId" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="vehicleId">
                               <option  value="">All Vehicle</option>
                              @foreach ($ambulanceVehicle as $vehicle)
                              <option  value="{{$vehicle->ambulance_category_vehicle_id }}">{{$vehicle->ambulance_category_vehicle_name}}</option>
                              @endforeach
                        </select>
                        @error('vehicleId') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                @endif
                <div class="col-6 col-sm-auto col-md-2" style="margin-top: 20px;">
                        <button type="submit"
                                 wire:loading.attr="disabled" 
                                 class="rounded-0 form-control form-control-sm btn-primary">
                                 <i wire:loading wire:target="autoSearchBookingStep1Form" class="fa fa-spinner fa-spin mt-2 ml-2"></i> Submit
                        </button>    
                </div>
            </div>
            </form>
            </div>
            </div>


            <div wire:loading.remove wire:target="filterCondition" class="card-body p-2 overflow-auto">
                <table class="table custom__table table-bordered table-sm ">
                <tr>
                        <th>Sr.</th>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Distance</th>
                        <th>Update Time</th>
                        <th>Status</th>
                        <th>Vehicle</th>
                        <th>Category</th>
                        <th>Vehicle Name</th>
                        <th>Action</th>
                    </tr>
                    @php
                    $srno = 1;

                    $statusMapper['0'] = "New";
                    $statusMapper['1'] = "Active";
                    $statusMapper['2'] = "Inactive";
                 
                    @endphp

                    @if(!empty($this->driverDetails))

                    @foreach ($this->driverDetails as $list)

                    <tr>
                        <td>{{ $srno }}</td>
                        <td>{{$list->driver_id }}</td>
                        <td>{{$list->driver_name}}</td>
                        <td>{{$list->driver_mobile}}</td>
                        <td>{{number_format($list->distance, 2, '.', ',')}}.Km</td>
                        <td>{{$list->last_updated_diff_formatted}}</td>
                        <td>{{$statusMapper[$list->driver_status]}}</td>
                        <td>{{$list->vehicle_rc_number}}</td>
                        <td>{{$list->ambulance_category_name}}</td>
                        <td>{{$list->v_vehicle_name}}</td>
                        <td> <button  wire:navigate href="{{route('admin.driver-details-component',['driverId' => Crypt::encrypt($list->driver_id)])}}" class="btn-success"><i class="fa fa-eye" style="width:50px;"></i></button></td>
                       
                    </tr>
                    @php
                    $srno++
                    @endphp
                    @endforeach
                    @endif
              
                </table>
                <div class="custom__pagination mt-2 text-right pt-1 card-footer__ clearfix">
            </div>

        </div>
        <div class="container">
            <div class="row" wire:loading wire:target="ambulance_category_id,driver_duty_status,filterCondition,vehicleId" wire:key="ambulance_category_id,driver_duty_status,filterCondition,vehicleId">
                <div class="col">
                    <div class="loader">
                        <div class="loader-inner">
                            <div class="loading one"></div>
                        </div>
                        <div class="loader-inner">
                            <div class="loading two"></div>
                        </div>
                        <div class="loader-inner">
                            <div class="loading three"></div>
                        </div>
                        <div class="loader-inner">
                            <div class="loading four"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @php $googleMap = DB::table('aa_setting')->where('a_setting_id','9')->first();
        @endphp
        <script type="text/javascript"
        src="https://maps.google.com/maps/api/js?key={{$googleMap->a_setting_value}}&libraries=places" ></script>
    <script>
        window.addEventListener('load', initialize)
  
        function initialize() {
          var pickup_address = new google.maps.places.Autocomplete(document.getElementById('pickup_address'));
            pickup_address.addListener('place_changed', function () {
            var pickup_place = pickup_address.getPlace();
            @this.set('pickup__address', pickup_place);
            @this.set('p_latitude', pickup_place.geometry.location.lat());
            @this.set('p_longitude', pickup_place.geometry.location.lng());
            });

        }
    </script>

    </div>
    </div>
    </div>
