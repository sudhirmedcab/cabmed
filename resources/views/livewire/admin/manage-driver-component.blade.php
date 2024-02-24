
<div class="content">
  <div class="container-fluid mt-2">
    <!-- Add driver -->
    <div class="{{$isStep1FormSubmitted ? 'custom__card' : '' }} card card-default add__driver__form">
      <div class="card-header align-items-center d-flex">
        <h3 class="card-title">Add Driver</h3>
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
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label>Create Driver (For)</label>
                <select {{ $this->isStep1FormSubmitted ? 'disabled' :'' }}  wire:change="partners()" wire:model="create_for" class="custom-select rounded-0 form-control form-control-sm" id="exampleSelectRounded0">
                <option selected value="">Select</option>
                <option selected value="0">Self</option>
                  <option value="1">Partner</option>
                </select>
                @error('create_for') <span class="text-danger">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <!-- {{ $this->isStep1FormSubmitted ? 'disabled' :'no' }}  -->
                <label>Partner Name</label> 
                <!-- {{$isStep1FormSubmitted ? 'as':'sd'}}  -->

                <select  {{ !$isPartner ? 'disabled' : '' }}   @if($isStep1FormSubmitted) disabled @endif wire:model="partner_id" class="custom-select rounded-0 form-control form-control-sm" id="exampleSelectRounded0">
                    <option selected value="0">Select</option>
                        @if($isPartner)
                          @foreach ($partners as $list)
                          <option value="{{$list->partner_id}}">{{$list->partner_f_name.' '.$list->partner_l_name.' ('.$list->partner_mobile.')'}}</option>
                          @endforeach
                        @endif
                    </select>
                @error('partner_id') <span class="text-danger">{{ $message }}</span> @enderror

              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label for="driver_first_name">Driver First Name</label>
                <input wire:model="driver_first_name" 
                type="text" 
                 class="rounded-0 form-control form-control-sm" id="driver_first_name" 
                 placeholder="Enter first name">
                @error('driver_first_name') <span class="text-danger">{{ $message }}</span> @enderror
             
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label for="driver_last_name">Driver Last Name</label>
                <input wire:model="driver_last_name" type="text" class="rounded-0 form-control form-control-sm" id="driver_first_name" placeholder="Enter last name">
                @error('driver_last_name') <span class="text-danger">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label for="driver_mobile">Driver Mobile</label>
                <input wire:model="driver_mobile" type="text" class="rounded-0 form-control form-control-sm" id="driver_mobile" placeholder="Enter Driver Mobile">
                @error('driver_mobile') <span class="text-danger">{{ $message }}</span> @enderror
              
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label for="driver_dob">Driver DOB</label>
                <input wire:model="driver_dob" type="date" class="rounded-0 form-control form-control-sm" id="driver_mobile" placeholder="Enter Driver Mobile">
                @error('driver_dob') <span class="text-danger">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label for="driver_mobile">Gender</label>
                <select  wire:model="driver_gender" class="custom-select rounded-0 form-control form-control-sm" id="exampleSelectRounded0">
                <option selected value="">Select</option>
                          <option value="Male">Male</option>
                          <option value="Female">Female</option>
                    </select>
                    @error('driver_gender') <span class="text-danger">{{ $message }}</span> @enderror
              
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label for="driver_city">Driver City</label>
                <select wire:model.live.debounce.150ms="driver_city" wire:loading.attr="disabled"  class="custom-select rounded-0 form-control form-control-sm" id="driver_city_id">
                <option  value="">Select</option>
                @foreach ($city as $list)
                <option  value="{{ $list->city_id }}">{{ $list->city_name }}</option>
                @endforeach
              </select>
                @error('driver_city') <span class="text-danger">{{ $message }}</span> @enderror
           
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label for="vehicle_rc_no">Vehicle RC No.</label>
                <input wire:model="vehicle_rc_no" type="text"  {{ $isPartner ? 'disabled' : '' }} oninput="this.value = this.value.toUpperCase()" @if($isStep1FormSubmitted) disabled @endif class="rounded-0 form-control form-control-sm" id="vehicle_rc_no" placeholder="Enter Vehicle RC No.">
                @error('vehicle_rc_no') <span class="text-danger">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label for="driver_profile_image">Profile Image</label>
                <input type="file" wire:model="driver_profile_image" class="rounded-0 form-control form-control-sm" accept=".jpeg,.jpg,.png" id="vehicle_rc_no" placeholder="Enter Vehicle RC No.">
                @error('driver_profile_image') <span class="text-danger">{{ $message }}</span> @enderror
                <input type="hidden" wire:model="driver_id">
              
              </div>
            </div>
            
          </div>
          <button type="submit"
                       wire:loading.attr="disabled" 
                       class="mt-2 rounded-0 form-control form-control-sm btn-primary">
                       <i wire:loading wire:target="step1Form" class="fa fa-spinner fa-spin mt-2 ml-2"></i> {{$isStep1FormSubmitted ? 'Update' : 'Submit'}}
                       </button>
        </form>
      </div>
    </div>

    <!-- Basic Driver Details -->
    <div class="@if($isStep1FormSubmitted && $isStep2FormSubmitted) custom__card @endif card card-default add__driver__form">
      <div class="card-header align-items-center d-flex">
        <h3 class="card-title">Driver Basic Details</h3>
        @error('driver_id') <p class="card-title text-warning">&nbsp;&nbsp; ({{$message}})</p>@enderror

        <div class="card-tools d-flex align-items-center ml-auto">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
             <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool">
          @if($isStep1FormSubmitted && $isStep2FormSubmitted) <i class="fas fas fa-check-circle"></i> @endif
          </button>
          <div class="col-3 ml-auto d-flex align-items-end justify-content-end">
            <a href="#" class="submit__btn text-primary font-weight-bold my-1 d-flex align-items-center justify-content-center">
             {{$isStep2FormSubmitted ? 'Update' : 'Submit'}}
            </a>
          </div>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body py-1 pb-3 ">
        <form wire:submit.prevent="step2Form">
          <div class="row">
            <div class="col-6 col-sm-4 col-md-3 col-lg-3">
              <div class="form-group">
                <label for="exampleInputFile">Aadhaar Front Image</label>
                    <input wire:model="driver_adhar_front" type="file" accept=".jpeg,.jpg,.png" class="rounded-0 form-control form-control-sm" id="exampleInputFile">
                    @error('driver_adhar_front') <span class="text-danger">{{$message}}</span> @enderror
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-3">
              <div class="form-group">
                <label for="exampleInputFile">Aadhaar Back Image</label>
                    <input wire:model="driver_adhar_back" type="file" accept=".jpeg,.jpg,.png" class="rounded-0 form-control form-control-sm" id="driver_adhar_back">
                @error('driver_adhar_back') <span class="text-danger">{{$message}}</span> @enderror
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label for="driver_adhar_no">Aadhaar Number</label>
                <input wire:model="driver_adhar_no" type="number" class="rounded-0 form-control form-control-sm" id="driver_first_name" placeholder="Enter aadhaar number">
                @error('driver_adhar_no') <span class="text-danger">{{$message}}</span> @enderror
             
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label for="driver_pan_img">Pan Image</label>
                      <input wire:model="driver_pan_img" type="file" accept=".jpeg,.jpg,.png" class="rounded-0 form-control form-control-sm" id="driver_pan_back">
                @error('driver_pan_img') <span class="text-danger">{{$message}}</span> @enderror
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label for="driver_pan_no">Pan Number</label>
                <input wire:model="driver_pan_no" type="text" oninput="this.value = this.value.toUpperCase()" class="rounded-0 form-control form-control-sm" id="driver_first_name" placeholder="Enter PAN Number">
                @error('driver_pan_no') <span class="text-danger">{{ $message }}</span> @enderror
                    <input type="hidden" wire:model="driver_id">
                <input type="hidden" wire:model="driver_details_id">

              </div>
            </div>
          </div>
          <button type="submit"
                       wire:loading.attr="disabled" 
                       @if(!$isStep1FormSubmitted) disabled @endif class="mt-2 rounded-0 form-control form-control-sm btn-primary">
                       <i wire:loading wire:target="step2Form" class="fa fa-spinner fa-spin mt-2 ml-2"></i>{{$isStep2FormSubmitted ? 'Update' : 'Submit'}} 
                       </button>
        </form>
      </div>
    </div>

    <!-- Verification -->
    <div class=" @if($isStep1FormSubmitted && $isStep2FormSubmitted && $isStep3FormSubmitted) custom__card @endif card card-default add__driver__form">
      <div class="card-header align-items-center d-flex">
        <h3 class="card-title">Verification</h3> 

        @if($errors->has('driver_id'))
        <p class="card-title text-warning">&nbsp;&nbsp; ({{ $errors->first('driver_id') }})</p>
        @elseif($errors->has('driver_details_id'))
          <p class="card-title text-warning">&nbsp;&nbsp; ({{ $errors->first('driver_details_id') }})</p>
        @endif
 
        <div class="card-tools d-flex align-items-center ml-auto">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool">
          @if($isStep1FormSubmitted && $isStep2FormSubmitted && $isStep3FormSubmitted) 
            <i class="fas fas fa-check-circle"></i>
          @endif
          </button>
          <div class="col-3 ml-auto d-flex align-items-end justify-content-end">
            <a href="#" class="submit__btn text-primary font-weight-bold my-1 d-flex align-items-center justify-content-center">
            {{$isStep2FormSubmitted ? 'Update' : 'Submit'}} 
            </a>
          </div>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body py-1 pb-3">
        <form wire:submit.prevent="step3Form">
          <div class="row">
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label for="exampleInputFile">Police Verification Image</label>
                    <input wire:model="driver_police_verification_img" type="file" accept=".jpeg,.jpg,.png" class="rounded-0 form-control form-control-sm" id="exampleInputFile">
                @error('driver_police_verification_img') <span class="text-danger">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label class="custom__label" for="toDate">Expiry :</label>
                <input wire:model.live="driver_police_verification_expiry" type="date" class="rounded-0 form-control form-control-sm rounded-0 form-control form-control-sm" id="toDate" placeholder="Enter to date">
                @error('driver_police_verification_expiry') <span class="text-danger">{{ $message }}</span> @enderror
              
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label for="exampleInputFile">DL Front Image</label>
                    <input wire:model.live="driver_dl_front" type="file" accept=".jpeg,.jpg,.png" class="rounded-0 form-control form-control-sm" id="exampleInputFile">
                @error('driver_dl_front') <span class="text-danger">{{ $message }}</span> @enderror

              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label for="exampleInputFile">DL Back Image</label>
                    <input  wire:model.live="driver_dl_back"  type="file" accept=".jpeg,.jpg,.png" class="rounded-0 form-control form-control-sm" id="exampleInputFile">
                @error('driver_dl_back') <span class="text-danger">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label for="driver_dl_no">DL Number</label>
                <input wire:model="driver_dl_no" type="text" oninput="this.value = this.value.toUpperCase()" class="rounded-0 form-control form-control-sm" id="driver_first_name" placeholder="Enter first name">
                @error('driver_dl_no') <span class="text-danger">{{ $message }}</span> @enderror
              
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 ">
              <div class="form-group">
                <label class="custom__label" for="toDate">Expiry :</label>
                <input wire:model.live="driver_dl_expiry" type="date" class=" rounded-0 form-control form-control-sm" id="toDate" placeholder="Enter to date">
                @error('driver_dl_expiry') <span class="text-danger">{{ $message }}</span> @enderror
                <input type="hidden" wire:model="driver_id">
                <input type="hidden" wire:model="driver_details_id">

              </div>
            </div>
          </div>
          <button type="submit"
                       wire:loading.attr="disabled" 
                       @if(!$isStep2FormSubmitted) disabled @endif class="mt-2 rounded-0 form-control form-control-sm btn-primary">
                       <i wire:loading wire:target="step3Form" class="fa fa-spinner fa-spin mt-2 ml-2"></i>{{$isStep3FormSubmitted ? 'Update' : 'Submit'}} 
                        </button>
        </form>
      </div>
    </div>

    <!-- Ambulance Details -->
    <div class="{{ $isPartner ? 'd-none' : '' }} @if($isStep1FormSubmitted && $isStep2FormSubmitted && $isStep3FormSubmitted && $isStep4FormSubmitted) custom__card @endif card card-default add__driver__form">
      <div class="card-header align-items-center d-flex">
        <h3 class="card-title">Ambulance Details</h3>
        @if($errors->has('driver_id'))
        <p class="card-title text-warning">&nbsp;&nbsp; ({{ $errors->first('driver_id') }})</p>
        @elseif($errors->has('driver_details_id'))
          <p class="card-title text-warning">&nbsp;&nbsp; ({{ $errors->first('driver_details_id') }})</p>
        @elseif($errors->has('vehicle_id'))
          <p class="card-title text-warning">&nbsp;&nbsp; ({{ $errors->first('driver_details_id') }})</p>
        @endif
        <div class="card-tools d-flex align-items-center ml-auto">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool">
          @if($isStep1FormSubmitted && $isStep2FormSubmitted && $isStep3FormSubmitted && $isStep4FormSubmitted) 
            <i class="fas fas fa-check-circle"></i>
          @endif
          </button>
          <div class="col-3 ml-auto d-flex align-items-end justify-content-end">
            <a href="#" class="submit__btn text-primary font-weight-bold my-1 d-flex align-items-center justify-content-center">
            {{$isStep4FormSubmitted ? 'Update' : 'Submit'}} 
            </a>
          </div>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body py-1 pb-3">
        <form wire:submit.prevent="step4Form">
          <div class="row">
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label for="exampleInputFile">Ambulance Front Image</label>
                    <input type="file" wire:model="vehicle_front_image" accept=".jpeg,.jpg,.png" class="rounded-0 form-control form-control-sm" id="exampleInputFile">
                    @error('vehicle_front_image') <span class="text-danger">{{ $message }}</span> @enderror
                  </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label for="exampleInputFile">Ambulance Back Image</label>
                    <input type="file" wire:model="vehicle_back_image" accept=".jpeg,.jpg,.png" class="rounded-0 form-control form-control-sm" id="exampleInputFile">
                 @error('vehicle_back_image') <span class="text-danger">{{ $message }}</span> @enderror
                  </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label>Creategory</label>
                <select wire:change="partners()" wire:model="ambulanceCategory" class="custom-select rounded-0 form-control form-control-sm" id="exampleSelectRounded0">
                <option selected value="">Select</option>
                @foreach ($ambulanceCatList as $list)
                <option  value="{{ $list->ambulance_category_type }}">{{ $list->ambulance_category_name }}</option>
                @endforeach
                </select>
                @error('ambulanceCategory') <span class="text-danger">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label for="vehicle_rc_image">RC Image</label>
                    <input type="file" wire:model="vehicle_rc_image" accept=".jpeg,.jpg,.png" class="rounded-0 form-control form-control-sm" id="exampleInputFile">
                    @error('vehicle_rc_image') <span class="text-danger">{{ $message }}</span> @enderror
            
                  </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label for="vehicle_rc_number">RC Number</label>
                <input wire:model="vehicle_rc_number"type="text" oninput="this.value = this.value.toUpperCase()" class="rounded-0 form-control form-control-sm" id="driver_first_name" placeholder="Enter first name">
                @error('vehicle_rc_number') <span class="text-danger">{{ $message }}</span> @enderror
              
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 ">
              <div class="form-group">
                <label class="custom__label" for="vehicle_exp_date">Expiry :</label>
                <input wire:model.live="vehicle_exp_date" type="date" class="rounded-0 form-control form-control-sm" id="vehicle_exp_date" placeholder="Enter expiry">
                @error('vehicle_exp_date') <span class="text-danger">{{ $message }}</span> @enderror
                <input type="hidden" wire:model="driver_id">
                <input type="hidden" wire:model="vehicle_id">
                <input type="hidden" wire:model="driver_details_id">
                <input type="hidden" wire:model="vehicle_details_id">
                
              </div>
              <button type="submit"
                       wire:loading.attr="disabled" 
                       @if(!$isStep3FormSubmitted) disabled @endif class="mt-2 rounded-0 form-control form-control-sm btn-primary">
                       <i wire:loading wire:target="step4Form" class="fa fa-spinner fa-spin mt-2 ml-2"></i>{{$isStep4FormSubmitted ? 'Update' : 'Submit'}} 
                        </button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <!-- Ambulance Fitness -->
    <div class="{{ $isPartner ? 'd-none' : '' }} @if($isStep1FormSubmitted && $isStep2FormSubmitted && $isStep3FormSubmitted && $isStep4FormSubmitted && $isStep5FormSubmitted) custom__card @endif card card-default add__driver__form">
      <div class="card-header align-items-center d-flex">
        <h3 class="card-title">Ambulance Fitness</h3>
        @if($errors->has('driver_id'))
        <p class="card-title text-warning">&nbsp;&nbsp; ({{ $errors->first('driver_id') }})</p>
        @elseif($errors->has('driver_details_id'))
          <p class="card-title text-warning">&nbsp;&nbsp; ({{ $errors->first('driver_details_id') }})</p>
        @elseif($errors->has('vehicle_id'))
          <p class="card-title text-warning">&nbsp;&nbsp; ({{ $errors->first('driver_details_id') }})</p>
        @endif
        <div class="card-tools ml-auto d-flex align-items-center">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool">
          @if($isStep1FormSubmitted && $isStep2FormSubmitted && $isStep3FormSubmitted && $isStep4FormSubmitted && $isStep5FormSubmitted) 
            <i class="fas fas fa-check-circle"></i>
          @endif
      </button>
          <div class="col-3 ml-auto d-flex align-items-end justify-content-end">
            <a href="#" class="submit__btn text-primary font-weight-bold my-1 d-flex align-items-center justify-content-center">
            {{$isStep5FormSubmitted ? 'Update' : 'Submit'}} 
            </a>
          </div>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body py-1 pb-3 row">
        <form wire:submit.prevent="step5Form">
          <div class="row">
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label for="exampleInputFile">Fitness Image</label>
                    <input type="file" wire:model="vehicle_details_fitness_certi_img" accept=".jpeg,.jpg,.png" class="rounded-0 form-control form-control-sm" id="exampleInputFile">
                    @error('vehicle_details_fitness_certi_img') <span class="text-danger">{{ $message }}</span> @enderror

              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label class="custom__label" for="vehicle_details_fitness_exp_date">Expiry :</label>
                <input  wire:model="vehicle_details_fitness_exp_date" type="date" class=" rounded-0 form-control form-control-sm" id="toDate" placeholder="Enter to date">
                @error('vehicle_details_fitness_exp_date') <span class="text-danger">{{ $message }}</span> @enderror
             
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label for="exampleInputFile">Insurance Image</label>
                    <input type="file" wire:model="vehicle_details_insurance_img" accept=".jpeg,.jpg,.png" class="rounded-0 form-control form-control-sm" id="exampleInputFile">
                    @error('vehicle_details_insurance_img') <span class="text-danger">{{ $message }}</span> @enderror

              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label class="custom__label" for="toDate">Expiry :</label>
                <input wire:model.live="vehicle_details_insurance_exp_date" type="date" class=" rounded-0 form-control form-control-sm" id="toDate" placeholder="Enter to date">
                @error('vehicle_details_insurance_exp_date') <span class="text-danger">{{ $message }}</span> @enderror

              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label for="vehicle_details_insurance_holder_name">Insurance Holder Name</label>
                <input wire:model="vehicle_details_insurance_holder_name" type="text" class="rounded-0 form-control form-control-sm" id="driver_first_name" placeholder="Enter Name">
                @error('vehicle_details_insurance_holder_name') <span class="text-danger">{{ $message }}</span> @enderror
              
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label for="exampleInputFile">Pollution Certification Image</label>
                    <input  wire:model="vehicle_details_pollution_img" type="file" accept=".jpeg,.jpg,.png" class="rounded-0 form-control form-control-sm" id="exampleInputFile">
                @error('vehicle_details_pollution_img') <span class="text-danger">{{ $message }}</span> @enderror

              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                <label class="custom__label" for="vehicle_details_pollution_exp_date">Expiry :</label>
                <input wire:model.live="vehicle_details_pollution_exp_date" type="date" class=" rounded-0 form-control form-control-sm" id="toDate" placeholder="Enter to date">
                @error('vehicle_details_pollution_exp_date') <span class="text-danger">{{ $message }}</span> @enderror
                <input type="hidden" wire:model="driver_id">
                <input type="hidden" wire:model="vehicle_id">
                <input type="hidden" wire:model="driver_details_id">
              </div>
              <button type="submit"
                       wire:loading.attr="disabled" 
                       class="mt-2 rounded-0 form-control form-control-sm btn-primary">
                       <i wire:loading wire:target="step5Form" class="fa fa-spinner fa-spin mt-2 ml-2"></i> 
                        {{$isStep5FormSubmitted ? 'Update' : 'Submit'}} 

                       </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- /.card -->

  <!-- /.row -->
  {{-- <div class="container-fluid">
  <div class="row">
    <div class="col-lg-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Card title</h5>

          <p class="card-text">
            Some quick example text to build on the card title and make up the bulk of the card's
            content.
          </p>

          <a href="#" class="card-link">Card link</a>
          <a href="#" class="card-link">Another link</a>
        </div>
      </div>

      <div class="card card-primary card-outline">
        <div class="card-body">
          <h5 class="card-title">Card title</h5>

          <p class="card-text">
            Some quick example text to build on the card title and make up the bulk of the card's
            content.
          </p>
          <a href="#" class="card-link">Card link</a>
          <a href="#" class="card-link">Another link</a>
        </div>
      </div><!-- /.card -->
    </div>
    <!-- /.col-md-6 -->
    <div class="col-lg-6">
      <div class="card">
        <div class="card-header">
          <h5 class="m-0">Featured</h5>
        </div>
        <div class="card-body">
          <h6 class="card-title">Special title treatment</h6>

          <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
          <a href="#" class="btn btn-primary">Go somewhere</a>
        </div>
      </div>

      <div class="card card-primary card-outline">
        <div class="card-header">
          <h5 class="m-0">Featured</h5>
        </div>
        <div class="card-body">
          <h6 class="card-title">Special title treatment</h6>

          <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
          <a href="#" class="btn btn-primary">Go somewhere</a>
        </div>
      </div>
    </div>
    <!-- /.col-md-6 -->
  </div>
  <!-- /.row -->
</div><!-- /.container-fluid --> --}}
</div>