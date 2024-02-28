
@php 
$vehicleId = $this->vehicleId;
$decriptedVehicleId = decrypt($this->vehicleId);
@endphp

<div class="content">
  <div class="container-fluid mt-2">
    <div class="{{$isStep1FormSubmitted ? 'custom__card' : '' }} card card-default add__driver__form">
      <div class="card-header align-items-center d-flex">
        <h3 class="card-title">{{$decriptedVehicleId ? 'Update' : 'Add'}} Vehicle</h3>
        <div class="card-tools d-flex align-items-center ml-auto">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool">
            @if($isStep1FormSubmitted) <i class="fas fa-check-circle"></i> @endif

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
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif
      <div class="card-body py-1 pb-3">
        <form wire:submit.prevent="step1Form">
          <div class="row">
          <div class="col-6 col-sm-4 col-md-3">
              <div class="form-group">
                <label>Partner Name</label> 

                <select  @if($isStep1FormSubmitted) disabled @endif wire:model="partner_id" class="custom-select rounded-0 form-control form-control-sm">
                    <option selected value="0">Select</option>
                        @if($partners)
                          @foreach ($partners as $list)
                          <option value="{{$list->partner_id}}">{{$list->partner_f_name.' '.$list->partner_l_name.' ('.$list->partner_mobile.')'}}</option>
                          @endforeach
                        @endif
                    </select>
                @error('partner_id') <span class="text-danger">{{ $message }}</span> @enderror

              </div>
            </div>
         
            <div class="col-6 col-sm-4 col-md-3">
              <div class="form-group">
                <label for="vehicle_rc_number">Vehicle RC No.</label>
                <input wire:model="vehicle_rc_number" type="text"  oninput="this.value = this.value.toUpperCase()" @if($isStep1FormSubmitted) disabled @endif class="rounded-0 form-control form-control-sm" id="vehicle_rc_number" placeholder="Enter Vehicle RC No.">
                @error('vehicle_rc_number') <span class="text-danger">{{ $message }}</span> @enderror
              </div>
            </div>

            <div class="col-6 col-sm-4 col-md-3">
              <div class="form-group">
                <label for="vehicle_rc_image">RC Image</label>
                    <input type="file" wire:model="vehicle_rc_image" accept=".jpeg,.jpg,.png" value="{{$decriptedVehicleId ? $vehicle_rc_image : ''}}" class="rounded-0 form-control form-control-sm" id="exampleInputFile">
                    @error('vehicle_rc_image') <span class="text-danger">{{ $message }}</span> @enderror
            
                  </div>
            </div>

            <div class="col-6 col-sm-4 col-md-3">
              <div class="form-group">
                <label class="custom__label" for="vehicle_exp_date">RC Expiry :</label>
                <input wire:model.live="vehicle_exp_date" type="date" class="rounded-0 form-control form-control-sm" id="vehicle_exp_date" placeholder="Enter expiry">
                @error('vehicle_exp_date') <span class="text-danger">{{ $message }}</span> @enderror

                @if(!empty($decriptedVehicleId))
                <input type="hidden" wire:model="vehicle_id" value="{{$decriptedVehicleId}}">
                @else
                <input type="hidden" wire:model="vehicle_id" value="{{$decriptedVehicleId}}">
                 @endif
                <input type="hidden" wire:model="vehicle_details_id">
                
              </div>
            
          </div>
          <button type="submit"
                       wire:loading.attr="disabled" 
                       class="mt-2 rounded-0 form-control form-control-sm btn-primary">
                       <i wire:loading wire:target="step1Form" class="fa fa-spinner fa-spin mt-2 ml-2"></i> {{$decriptedVehicleId ? 'Update' : 'Submit'}}
                       </button>
        </form>
      </div>
    </div>
    </div>

    <!-- Ambulance Details -->
    <div class="@if($isStep1FormSubmitted && $isStep2FormSubmitted && $isStep3FormSubmitted) custom__card @endif card card-default add__driver__form">
      <div class="card-header align-items-center d-flex">
        <h3 class="card-title">Ambulance Details</h3>
        @if($errors->has('vehicle_id'))
          <p class="card-title text-warning">&nbsp;&nbsp; ({{ $errors->first('vehicle_id') }})</p>
        @endif
        <div class="card-tools d-flex align-items-center ml-auto">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool">
          @if($isStep1FormSubmitted && $isStep2FormSubmitted ) 
            <i class="fas fas fa-check-circle"></i>
          @endif
          </button>
        
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body py-1 pb-3">
        <form wire:submit.prevent="step2Form">
          <div class="row">
          <div class="col-6 col-sm-4 col-md-3">
              <div class="form-group">
                <label for="exampleInputFile">Ambulance Front Image</label>
                    <input type="file" wire:model="vehicle_front_image" accept=".jpeg,.jpg,.png" value="{{$decriptedVehicleId ? $vehicle_front_image : ''}}" class="rounded-0 form-control form-control-sm" id="exampleInputFile">
                    @error('vehicle_front_image') <span class="text-danger">{{ $message }}</span> @enderror
                  </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3">
              <div class="form-group">
                <label for="exampleInputFile">Ambulance Back Image</label>
                    <input type="file" wire:model="vehicle_back_image" accept=".jpeg,.jpg,.png" value="{{$decriptedVehicleId ? $vehicle_back_image : ''}}" class="rounded-0 form-control form-control-sm" id="exampleInputFile">
                 @error('vehicle_back_image') <span class="text-danger">{{ $message }}</span> @enderror
                  </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3">
              <div class="form-group">
                <label>Creategory</label>
                <select  wire:model="ambulanceCategory" class="custom-select rounded-0 form-control form-control-sm">
                <option selected value="">Select</option>
                @foreach ($ambulanceCatList as $list)
                <option  value="{{ $list->ambulance_category_type }}">{{ $list->ambulance_category_name }}</option>
                @endforeach
                </select>
                @error('ambulanceCategory') <span class="text-danger">{{ $message }}</span> @enderror
                <input type="hidden" wire:model="vehicle_id">
                <input type="hidden" wire:model="vehicle_details_id">
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3">
              <div class="form-group">
                <label>Vehicle Name</label>
                <select  wire:model="v_vehicle_name_id" class="custom-select rounded-0 form-control form-control-sm">
                <option selected value="">Select</option>
                @foreach ($vehicleList as $list)
                <option  value="{{ $list->ambulance_category_vehicle_id }}">{{ $list->ambulance_category_vehicle_name }}</option>
                @endforeach
                </select>
                @error('v_vehicle_name_id') <span class="text-danger">{{ $message }}</span> @enderror
           
              </div>
            </div>

            @if(!empty($decriptedVehicleId))
                <input type="hidden" wire:model="vehicle_id" value="{{$decriptedVehicleId}}">
                @else
                <input type="hidden" wire:model="vehicle_id" value="{{$decriptedVehicleId}}">
                 @endif
          
              <button type="submit"
                       wire:loading.attr="disabled" 
                       class="mt-2 rounded-0 form-control form-control-sm btn-primary">
                       <i wire:loading wire:target="step2Form" class="fa fa-spinner fa-spin mt-2 ml-2"></i>{{$decriptedVehicleId ? 'Update' : 'Submit'}} 
                     </button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <!-- Ambulance Fitness -->
    <div class="@if($isStep1FormSubmitted && $isStep2FormSubmitted && $isStep3FormSubmitted) custom__card @endif card card-default add__driver__form">
      <div class="card-header align-items-center d-flex">
        <h3 class="card-title">Ambulance Fitness</h3>
        @if($errors->has('vehicle_id'))
          <p class="card-title text-warning">&nbsp;&nbsp; ({{ $errors->first('vehicle_id') }})</p>
        @endif
        <div class="card-tools ml-auto d-flex align-items-center">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool">
          @if($isStep1FormSubmitted && $isStep2FormSubmitted) 
            <i class="fas fas fa-check-circle"></i>
          @endif
      </button>
          
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body py-1 pb-3 row">
        <form wire:submit.prevent="step3Form">
          <div class="row">
          <div class="col-6 col-sm-4 col-md-2">
              <div class="form-group">
                <label for="exampleInputFile">Fitness Image</label>
                    <input type="file" wire:model="vehicle_details_fitness_certi_img" value="{{$vehicle_back_image ?? ''}}" accept=".jpeg,.jpg,.png" class="rounded-0 form-control form-control-sm" id="exampleInputFile">
                    @error('vehicle_details_fitness_certi_img') <span class="text-danger">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-2">
              <div class="form-group">
                <label class="custom__label" for="vehicle_details_fitness_exp_date">Fitness Expiry :</label>
                <input  wire:model="vehicle_details_fitness_exp_date" type="date" value="{{$vehicle_details_fitness_exp_date ?? ''}}" class=" rounded-0 form-control form-control-sm" id="toDate" placeholder="Enter to date">
                @error('vehicle_details_fitness_exp_date') <span class="text-danger">{{ $message }}</span> @enderror
              </div>
            </div>
         
            <div class="col-6 col-sm-4 col-md-2">
              <div class="form-group">
                <label class="custom__label" for="toDate">Insurance Expiry :</label>
                <input wire:model.live="vehicle_details_insurance_exp_date" type="date"  value="{{$vehicle_details_insurance_exp_date ?? ''}}" class=" rounded-0 form-control form-control-sm" id="toDate" placeholder="Enter to date">
                @error('vehicle_details_insurance_exp_date') <span class="text-danger">{{ $message }}</span> @enderror
              </div>
            </div>
            
            <div class="col-6 col-sm-4 col-md-2">
              <div class="form-group">
                <label for="vehicle_details_insurance_holder_name">Insurance Holder Name</label>
                <input wire:model="vehicle_details_insurance_holder_name" type="text" value="{{$vehicle_details_insurance_holder_name ?? ''}}" class="rounded-0 form-control form-control-sm" id="driver_first_name" placeholder="Enter Name">
                @error('vehicle_details_insurance_holder_name') <span class="text-danger">{{ $message }}</span> @enderror
                <input type="hidden" wire:model="vehicle_id">
                <input type="hidden" wire:model="vehicle_details_id">
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-2">
              <div class="form-group">
                <label for="exampleInputFile">Insurance Image</label>
                    <input type="file" wire:model="vehicle_details_insurance_img" value="{{$vehicle_details_insurance_img ?? ''}}" accept=".jpeg,.jpg,.png" class="rounded-0 form-control form-control-sm" id="exampleInputFile">
                    @error('vehicle_details_insurance_img') <span class="text-danger">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-2">
              <div class="form-group">
                <label for="exampleInputFile">Pollution Certification Image</label>
                    <input  wire:model="vehicle_details_pollution_img" type="file" value="{{$vehicle_details_pollution_img ?? ''}}" accept=".jpeg,.jpg,.png" class="rounded-0 form-control form-control-sm" id="exampleInputFile">
                @error('vehicle_details_pollution_img') <span class="text-danger">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-2">
              <div class="form-group">
                <label class="custom__label" for="vehicle_details_pollution_exp_date">Pollution Expiry :</label>
                <input wire:model.live="vehicle_details_pollution_exp_date" type="date" value="{{$vehicle_details_pollution_exp_date ?? ''}}" class=" rounded-0 form-control form-control-sm" id="toDate" placeholder="Enter to date">
                @error('vehicle_details_pollution_exp_date') <span class="text-danger">{{ $message }}</span> @enderror
              </div>

              
                @if(!empty($decriptedVehicleId))
                <input type="hidden" wire:model="vehicle_id" value="{{$decriptedVehicleId}}">
                <input type="hidden" wire:model="vehicle_details_id" value="{{$vehicle_details_id}}">
                @else
                <input type="hidden" wire:model="vehicle_id" value="{{$decriptedVehicleId}}">
                <input type="hidden" wire:model="vehicle_details_id" value="{{$vehicle_details_id}}">
                 @endif

              <button type="submit"
                       wire:loading.attr="disabled" 
                       class="mt-2 rounded-0 form-control form-control-sm btn-primary">
                       <i wire:loading wire:target="step5Form" class="fa fa-spinner fa-spin mt-2 ml-2"></i> {{$vehicle_details_id ? 'Update' : 'Submit'}}
                       </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- /.card -->
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script>
    $(document).ready(function () {
        $('.select2-dropdown').select2();
        $('.select2-dropdown').on('change', function (e) {
            var data = $('.select2-dropdown').select2("val");
            @this.set('ottPlatform', data);
        });
    });
</script>
  <!-- /.row -->

</div>