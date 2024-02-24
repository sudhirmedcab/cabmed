<div class="content">
  <div class="container-fluid mt-2">
    <!-- Add driver -->
    <div class="card card-default add__driver__form">
      <!-- .......1....... -->
      <div class="card-header align-items-center d-flex">
        <h3 class="card-title">Generate Booking</h3>
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
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif
      <div class="card-body py-1 pb-3">
        <form wire:submit.prevent="generateBookingStep1Form">booking id : {{$booking_by_cid}}{{$this->booking_by_cid}}
          <div class="row">
           
            <div class="col-6 col-sm-4 col-md-5">
              <div class="form-group">
                <label for="driver_mobile">Customer Mobile</label>
                <input wire:model="customer_mobile" type="text" class="rounded-0 form-control form-control-sm" id="driver_mobile" placeholder="Enter Mobile">
                @error('customer_mobile') <span class="text-danger">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-5">
              <div class="form-group">
                <label for="name">Customer Name</label>{{$customer_name}}
                <input wire:model="customer_name" 
                type="text" 
                 class="rounded-0 form-control form-control-sm" id="name" 
                 placeholder="Enter name">
                @error('customer_name') <span class="text-danger">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-6 col-sm-4 col-md-2">
              <div class="form-group">
              <button type="submit"
                       wire:loading.attr="disabled" 
                       class="mt-4 rounded-0 form-control form-control-sm btn-primary">
                       <i wire:loading wire:target="step1Form" class="fa fa-spinner fa-spin mt-2 ml-2"></i> Submit
              </button>    
              </div>
            </div>
          </div>
        </form>
        @if($errors->has('booking_by_cid'))
                <p class="card-title text-warning">&nbsp;&nbsp; *{{ $errors->first('booking_by_cid') }}</p>
              @endif
      </div>
      <!-- .......2..... -->
      <div class="card-header align-items-center d-flex">
      </div>
      <div class="card-body py-1 pb-3 ">
        <form wire:submit.prevent="generateBookingStep2Form" >
          <div class="row">
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                  <label data-toggle="tooltip" data-placement="top" title="Booking lead source">Booking Lead Source</label>
                  <select wire:model="booking_source" class="custom-select rounded-0 form-control form-control-sm" id="exampleSelectRounded0">
                    <option value="">Select</option>
                    <option value="APP">App</option>
                    <option value="app" selected="">App Enquiry</option>
                    <option value="web">Website Enquiry</option>
                    <option value="ivr">IvR</option>
                    <option value="directCall">Direct Call</option>
                    <option value="whatsapp">Whatsapp Chat (Double click)</option>
                  </select>
                  @error('booking_source') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
              </div>
            
              <div class="col-6 col-sm-4 col-md-6 col-lg-5">
                <div class="form-group">
                  <label for="exampleInputFile">Pickup Address</label>
                      <input wire:model="pickup_address" autocomplete type="text"  class="rounded-0 form-control form-control-sm" id="pickup_address">
                      <input type="hidden" wire:model="pickup__address" id="p_latitude" wire:ignore>
                      <input type="hidden" wire:model="p_latitude" id="p_latitude" wire:ignore>
                      <input type="hidden" wire:model="p_longitude" id="p_longitude" wire:ignore>
                      <input type="hidden" wire:model="booking_con_mobile" id="booking_con_mobile">
                      
                      @error('pickup__address') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
              </div>
              <div class="col-6 col-sm-4 col-md-6 col-lg-5">
                <div class="form-group">
                  <label for="exampleInputFile">Drop Address</label>
                      <input wire:model="drop_address" type="text" class="rounded-0 form-control form-control-sm" id="drop_address">
                      <input type="hidden" wire:model="drop__address" id="p_latitude" wire:ignore>
                      <input type="hidden" wire:model="d_latitude" id="d_latitude" wire:ignore>
                      <input type="hidden" wire:model="d_longitude" id="d_longitude" wire:ignore>
                      @error('drop__address') <span class="text-danger">{{ $message }}</span> @enderror

                </div>
              </div>
              <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                  <label for="date_time">Date Time</label>
                  <input wire:model="booking_schedule_time" type="datetime-local" class="rounded-0 form-control form-control-sm" id="booking_schedule_time" placeholder="Enter Date Time">
                  @error('booking_schedule_time') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
              </div>
              <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                  <label for="date_time">Remark</label>
                  <input wire:model="support_remark" type="text" class="rounded-0 form-control form-control-sm" id="driver_dob" placeholder="Enter Remark">
                  @error('support_remark') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
              </div>
              <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                  <label for="booking for">Booking for (Optional)</label>
                      <input wire:model="booking_for" type="text"  class="rounded-0 form-control form-control-sm" id="booking_for">
                      @error('booking_for') <span class="text-danger">{{ $message }}</span> @enderror
                  
                    </div>
              </div>
              <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                  <div class="form-group">
                      <label>Duty Status</label>
                      <select wire:model="duty_status" class="custom-select rounded-0 form-control form-control-sm" id="exampleSelectRounded0">
                        <option value="">Select</option>
                        <option value="ON">On</option>
                        <option value="OFF">Off</option>
                        <option value="All">All</option>
                      </select>
                      @error('booking_type') <span class="text-danger">{{ $message }}</span> @enderror
                  </div>
              </div>
              <div class="col-6 col-sm-4 col-md-3 col-lg-2">
              <div class="form-group">
                      <label>Select Driver</label>
                      <select wire:model="select_driver" class="custom-select rounded-0 form-control form-control-sm" id="exampleSelectRounded0">
                        <option value="nearest">Nearest</option>
                        <option value="ALL">All</option>
                      </select>
                      @error('select_driver') <span class="text-danger">{{ $message }}</span> @enderror
                  </div>
              </div>
              <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                  <input type="hidden" wire:model="booking_by_cid">
                  <input type="hidden" wire:model="booking_id" id="booking_id">

                  <button type="submit" wire:loading.attr="disabled" class="mt-4 rounded-0 form-control form-control-sm btn-primary">
                  <i wire:loading="" wire:target="generateBookingStep2Form" class="fa fa-spinner fa-spin mt-2 ml-2"></i>Submit</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      <!-- .......3...... -->
      @if($ambulanceDetails)
      <div class="card-header align-items-center d-flex">
      </div>
      <form wire:submit.prevent="generateBookingStep3Form">
        <div class="card-body py-1 pb-3 ">
          <table class="table custom__table table-bordered table-sm ">
                    <div class="form-group mb-2">
                        <label style="border-bottom:2px solid; font-size:small">Ambulance Category List :(Distance: {{$this->distance}} Km, Duration: {{$this->duration}})</label>
                    </div>
                      <tr>
                          <th>Sr.</th>
                          <th>Select</th>
                          <th class="text-left">Category Name</th>
                          <th>Category Icon</th>
                          <th>Base rate</th>
                          <th>Per Km Charge</th>
                          <th>Extra Km Charge</th>
                          <th>Total Service Charge</th>
                          <th>Total Fare Rate</th>
                      </tr>
                      @php
                      $srno = 1
                      @endphp
                      @foreach($ambulanceDetails as $index =>$list)
                      <tr wire:click="selectRow({{ $index }})">
                          <td>{{$srno++}}</td>
                          <td>
                          <input type="radio" wire:key="{{$index}}" wire:click="selectRow({{ $index }})"  name="rp1">
                          </td>
                          <td class="text-left">@if($list['category_name'])
                          {{$list['category_name']}}
                            @else
                              N/A
                            @endif</td>
                          <td class="cat__icon">
                            @if($list['category_icon'])
                            <img src="{{env('Image_url').'/'.$list['category_icon']}}"</td>
                            @else
                            N/A
                            @endif
                          <td>{{$list['base_rate']}}</td>
                          <td>{{$list['per_km_rate']}}</td>
                          <td>{{$list['per_ext_km_rate']}}</td>
                          <td>{{$list['rate_service_charge']}}</td>
                          <td>{{$list['total_fare']}}</td>
                        </tr>
                      @endforeach
          </table>
        </div>
        @endif
      @if($this->selected_ambulance_category_type || $this->selectedRow)
        <div class="card-body py-1 pb-3 ">
            <div class="card-header align-items-center d-flex">
            </div>
            <div class="form-group mb-2">
                      <label style="border-bottom:2px solid; font-size:small">Selected Ambulance Category: (<span style="padding:2px;" class="badge badge-primary">{{$this->selectedRow['category_name']}}</span>) </label>
                  </div>
            <div class="row">
            <div class="col col-sm-4 col-lg-2 col-md-5">
              <div class="form-group"> 
                <label for="name">Category Name</label>
                <input type="text" readonly wire:model.live="selectedRow.category_name" readonly class="rounded-0 form-control form-control-sm" id="category_name" placeholder="Enter ambulance category name">
                <type type="hidden" wire:model.live="selectedRow.category_type">
                <type type="hidden" wire:model.live="selectedRow.category_icon">
                
                @error('selectedRow.category_name') <span class="text-danger">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col col-sm-4 col-lg-2 col-md-5">
              <div class="form-group"> 
                <label for="name">Base Rate</label>
                <input type="number" min="100" wire:model.live="selectedRow.base_rate" readonly class="rounded-0 form-control form-control-sm" id="base_rate" placeholder="Enter base rate">
                @error('selectedRow.base_rate') <span class="text-danger">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col col-sm-4 col-lg-2 col-md-5">
              <div class="form-group">
                <label for="name">Per Km Charge</label>
                <input type="text" wire:model.live="selectedRow.per_km_rate" class="rounded-0 form-control form-control-sm" id="per_km_rate" placeholder="Enter per km rate">
                @error('selectedRow.per_km_rate') <span class="text-danger">{{ $message }}</span> @enderror
               
              </div>
            </div>
            <div class="col col-sm-4 col-lg-2 col-md-5">
              <div class="form-group">
                <label for="name">Extra Km Charge	</label>
                <input type="text" wire:model.live="selectedRow.per_ext_km_rate" class="rounded-0 form-control form-control-sm" id="per_ext_km_rate" placeholder="Enter extra km rate">
                @error('selectedRow.per_ext_km_rate') <span class="text-danger">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col col-sm-4 col-lg-2 col-md-5">
              <div class="form-group">
                <label for="rate_service_charge">Rate Service Charge</label>
                <input type="text" wire:model.live="selectedRow.rate_service_charge" class="rounded-0 form-control form-control-sm" id="rate_service_charge" placeholder="Enter service rate">
                @error('selectedRow.rate_service_charge') <span class="text-danger">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col col-sm-4 col-lg-2 col-md-5">
               <div class="form-group">
                <label for="total_fare">Total Fare Rate</label>
                <input type="text" wire:model="selectedRow.total_fare" class="rounded-0 form-control form-control-sm" id="total_fare" placeholder="Enter total rate">
                @error('selectedRow.total_fare') <span class="text-danger">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col col-sm-4 col-md-3 col-lg-2">
            <div class="form-group">
                    <label>Booking Status</label>
                    <select wire:model="select_booking_status" class="custom-select rounded-0 form-control form-control-sm" id="exampleSelectRounded0">
                      <option value="">Select booking type</option>
                      <option value="1">New booking</option>
                      <option value="2">Book now (ongoing)</option>
                      <option value="6">Future booking</option>
                      <option value="5">Cancel booking</option>
                    </select>
                    @error('select_booking_status') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                  <div class="form-group">
                      <label for="payment_method">Payment Method</label>
                      <select wire:model.live="booking_payment_method" class="custom-select rounded-0 form-control form-control-sm" id="exampleSelectRounded0">
                        <option value="">Select payment method</option>
                        <option value="3">Cod</option>
                        <option value="2">Advance</option>
                        <option value="1">Full</option>
                      </select>
                      @error('booking_payment_method') <span class="text-danger">{{ $message }}</span> @enderror
                  </div>
            </div>
          @if($this->booking_payment_method == 2)
              <div class="col col-sm-4 col-lg-2 col-md-5">
                <div class="form-group">
                  <label for="advance_rate_service_charge">Advance amount</label>
                  <input type="text" wire:model.live="advance_rate_service_charge" class="rounded-0 form-control form-control-sm" id="advance_rate_service_charge" placeholder="Enter service rate">
                  @error('advance_rate_service_charge') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
              </div>
              <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                  <div class="form-group">
                      <label for="payment_source_type">Payment Source</label>
                      <select wire:model.live="payment_source_type" class="custom-select rounded-0 form-control form-control-sm" id="payment_source_type">
                          <option value="">Select The Payment source</option>
                          <option value="bank_transfer">Bank Transfer </option>
                          <option value="qr_codes">QR Codes</option>
                          <option value="Others">Others</option>
                      </select>
                      @error('payment_source_type') <span class="text-danger">{{ $message }}</span> @enderror
                  </div>
            </div>
            <div class="col col-sm-4 col-lg-2 col-md-5">
                <div class="form-group">
                  <label for="transactionId">Transaction Id</label>
                  <input type="text" wire:model.live="transactionId" class="rounded-0 form-control form-control-sm" id="transactionId" placeholder="Enter transaction id">
                  @error('transactionId') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
              </div>
              <div class="col col-sm-4 col-lg-2 col-md-5">
                <div class="form-group">
                  <label for="transactionId">Transaction time</label>
                  <input type="datetime-local" wire:model.live="transaction_time" class="rounded-0 form-control form-control-sm" id="transaction_time" placeholder="Enter transaction time">
                  @error('transaction_time') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
              </div>
        @endif
        <div class="col-6 col-sm-4 col-lg-2 col-md-2">
              <div class="form-group">
              <input type="hidden" wire:model="booking_by_cid">
                  <input type="hidden" wire:model="booking_id" id="booking_id">
                <button type="submit"
                        wire:loading.attr="disabled" 
                        class="mt-4 rounded-0 form-control form-control-sm btn-primary">
                        <i wire:loading wire:target="generateBookingStep3Form" class="fa fa-spinner fa-spin mt-2 ml-2"></i> Submit
                </button>    
              </div>
            </div>
        <div class="row bg-light border mt-3 pt-2">
          <p class="col-10 col-md-12"><span style="font-weight: bold;">NAME:</span> MEDCAB CARE PRIVATE LIMITED</p>
          <p class="col-10 col-md-12"><span style="font-weight: bold;">BANK NAME:</span> AU SMALL FINANCE BANK</p>
          <p class="col-10 col-md-12"><span style="font-weight: bold;">A/C NO:</span> 2302258849813387</p>
          <p class="col-10 col-md-12"><span style="font-weight: bold;">IFSC CODE:</span> AUBL0002588</p>
        </div>

            
          </div>
          @endif
          </div>
      </form>
      
    </div>
    
    <script src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&libraries=places"></script>
    <script>
            // Initialize autocomplete for pickup address input
            var pickup_address = new google.maps.places.Autocomplete(document.getElementById('pickup_address'));
            var drop_address = new google.maps.places.Autocomplete(document.getElementById('drop_address'));
            pickup_address.addListener('place_changed', function () {
            var pickup_place = pickup_address.getPlace();
            console.log('pickup_place',pickup_place);
            @this.set('pickup__address', pickup_place);
            @this.set('p_latitude', pickup_place.geometry.location.lat());
            @this.set('p_longitude', pickup_place.geometry.location.lng());
            });

            drop_address.addListener('place_changed', function () {
            var drop_place = drop_address.getPlace();
            @this.set('drop__address', drop_place);
            @this.set('d_latitude', drop_place.geometry.location.lat());
            @this.set('d_longitude', drop_place.geometry.location.lng());
            });

    </script>
   
  </div>
</div> 
</div>
