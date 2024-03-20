<div class="content">
  <div class="container-fluid">
  @include('livewire.admin.vehicle.vehicle_nav_component')

  @if(!empty($cityCountData))
    <div class="card">
      <div class="card-header custom__filter__select">
        <div class="row">
          <div class="col-6 col-md-2">
            <div class="form-group">
              <label class="custom__label " for="vehicle_rc_no">Export Data</label>
              <button style="line-height:0" wire:click="cityCountDataDownlaod"  class="custom__input__field form-control btn-primary text-white rounded-0 form-control-sm">
                <p class="m-0 p-0">Export &nbsp; <i class="fa fa-download" aria-hidden="true"></i></p>
              </button>
            </div>
          </div>

          <div class="col-6 col-md-5">
            <div class="form-group">
              <label class="custom__label" for="vehicle_rc_no">State</label>
              <select wire:model.live.debounce.150ms="city_state" wire:loading.attr="disabled" wire:target="city_state" class="custom__input__field custom-select rounded-0 form-control form-control-sm select2Data" id="city_state">
                @foreach ($stateData as $list)
                <option @if($list->state_id === 27 ) selected @endif value="{{ $list->state_id }}">{{ $list->state_name }} (Total City: {{ $list->total_city_count }}) </option>

                @endforeach
              </select>
            </div>
          </div>
          <div class="col __col-3">
            <div class="form-group">
              <label class="custom__label" for="toDate">Search</label>
              <input type="search" wire:model.live.debounce.150ms="search" wire:loading.attr="disabled" wire:target="city_state" class="custom__input__field form-control rounded-0 form-control-sm float-right" placeholder="Search">
            </div>
          </div>
        </div>

      </div>
      <!-- <table class="table table-bordered table-sm table-responsive-sm mt-2"> -->
      <div class="card-body p-2 overflow-auto">
        <table class="table custom__table table-bordered table-sm">
          <tr>
                <th>Sr. No.</th>
                <th>City Name</th>
                <th>Total</th>
                <th>MFR </th>
                <th>PTS</th>
                <th>PTS(AC)</th>
                <th>BLS</th>
                <th>BLS(AC)</th>
                <th>ALS</th>
                <th>DB(S)</th>
                <th>DB(M)</th>
                <th>DB(B)</th>
                <th>DB(M)Fridge</th>
                <th>DB(B)Fridge</th>
          </tr>

          @if (!empty($cityCountData))
          @php
          $srno = 1
          @endphp
          <tr>
            @foreach($cityCountData as $list)
          <tr>
                <td class="table-plus">{{$srno}}</td>
                <td>{{$list->city_name}}</td>
                <td>{{$list->total_vehicle}}</td>
                <td>{{$list->medical_first_responder}}</td>
                <td>{{$list->patient_transfer_ambulances}}</td>
                <td>{{$list->patience_ransafer_ac}}</td>
                <td>{{$list->basic_life_support}}</td>
                <td>{{$list->basic_life_support_ac}}</td>
                <td>{{$list->advance_life_support}}</td>
                <td>{{$list->dead_body_small}}</td>
                <td>{{$list->dead_body_medium}}</td>
                <td>{{$list->dead_body_big}}</td>
                <td>{{$list->dead_body_medium_fridge}}</td>
                <td>{{$list->dead_body_big_fridge}}</td>
          </tr>
          @php
          $srno++
          @endphp
          @endforeach
          @endif

          </tr>


        </table>
        <div style="text-align:center;" wire:loading wire:target="selectedDate" wire:key="selectedDate"><i class="fa fa-spinner fa-spin mt-2 ml-2"></i>loading</div>
        <div class="custom__pagination mt-2 text-right pt-1 card-footer__ clearfix">
          {!! $cityCountData->links() !!}
        </div>
      </div>
    </div>
    <div class="container h-100 w-100">
            <div class="row w-100 h-100 align-items-center justify-content-center" wire:loading wire:target="selectedDate,city_state,filterCondition" wire:key="selectedDate,city_state,filterCondition">
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
        @elseif(!empty($districtCountData))
    <div class="card">
      <div class="card-header custom__filter__select">
        <div class="row">
          <div class="col-6 col-md-2">
            <div class="form-group">
              <label class="custom__label " for="vehicle_rc_no">Export Data</label>
              <button style="line-height:0" wire:click="districtCountDataDownlaod" class="custom__input__field form-control btn-primary text-white rounded-0 form-control-sm">
                <p class="m-0 p-0">Export &nbsp; <i class="fa fa-download" aria-hidden="true"></i></p>
              </button>
            </div>
          </div>

          <div class="col-6 col-md-5">
            <div class="form-group">
              <label class="custom__label" for="vehicle_rc_no">State</label>
              <select wire:model.live.debounce.150ms="district_state" wire:loading.attr="disabled" wire:target="district_state" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="district_state">
                @foreach ($stateData as $list)
                <option @if($list->state_id === 27 ) selected @endif value="{{ $list->state_id }}">{{ $list->state_name }} (Total District: {{ $list->total_district_count }}) </option>

                @endforeach
              </select>
            </div>
          </div>
          <div class="col __col-3">
            <div class="form-group">
              <label class="custom__label" for="toDate">Search</label>
              <input type="search" wire:model.live.debounce.150ms="search" wire:loading.attr="disabled" wire:target="district_state" class="custom__input__field form-control rounded-0 form-control-sm float-right" placeholder="Search">
            </div>
          </div>
        </div>

      </div>
      <!-- <table class="table table-bordered table-sm table-responsive-sm mt-2"> -->
      <div class="card-body p-2 overflow-auto">
        <table class="table custom__table table-bordered table-sm">
          <tr>
                <th>Sr. No.</th>
                <th>City Name</th>
                <th>Total</th>
                <th>MFR </th>
                <th>PTS</th>
                <th>PTS(AC)</th>
                <th>BLS</th>
                <th>BLS(AC)</th>
                <th>ALS</th>
                <th>DB(S)</th>
                <th>DB(M)</th>
                <th>DB(B)</th>
                <th>DB(M)Fridge</th>
                <th>DB(B)Fridge</th>
          </tr>

          @if (!empty($districtCountData))
          @php
          $srno = 1
          @endphp
          <tr>
            @foreach($districtCountData as $list)
          <tr>
                <td class="table-plus">{{$srno}}</td>
                <td>{{$list->district_name}}</td>
                <td>{{$list->total_vehicle}}</td>
                <td>{{$list->medical_first_responder}}</td>
                <td>{{$list->patient_transfer_ambulances}}</td>
                <td>{{$list->patience_ransafer_ac}}</td>
                <td>{{$list->basic_life_support}}</td>
                <td>{{$list->basic_life_support_ac}}</td>
                <td>{{$list->advance_life_support}}</td>
                <td>{{$list->dead_body_small}}</td>
                <td>{{$list->dead_body_medium}}</td>
                <td>{{$list->dead_body_big}}</td>
                <td>{{$list->dead_body_medium_fridge}}</td>
                <td>{{$list->dead_body_big_fridge}}</td>
          </tr>
          @php
          $srno++
          @endphp
          @endforeach
          @endif

          </tr>


        </table>
        <!-- <h6 style="padding-left:15px;">Total Vehicle Your Search State Is : {{ $sumVehicleCountsByDstrict }}</h6>
		<h6 style="padding-left:15px;">Total Vehicle Is : {{ $total_vehicle }}</h6> -->
        <div style="text-align:center;" wire:loading wire:target="selectedDate" wire:key="selectedDate"><i class="fa fa-spinner fa-spin mt-2 ml-2"></i>loading</div>
        <div class="custom__pagination mt-2 text-right pt-1 card-footer__ clearfix">
        {!! $districtCountData->links() !!}
        </div>
      </div>
    </div>
    <div class="container h-100 w-100">
            <div class="row w-100 h-100 align-items-center justify-content-center" wire:loading wire:target="selectedDate,district_state,filterCondition" wire:key="selectedDate,district_state,filterCondition">
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
    @elseif(!empty($total_data))

    <div class="card">
      <div class="card-header custom__filter__select">
        <div class="row">
          <div class="col-6 col-md-2">
            <div class="form-group">
              <label class="custom__label " for="vehicle_rc_no">Export Data</label>
              <button style="line-height:0" class="custom__input__field form-control btn-primary text-white rounded-0 form-control-sm">
                <p class="m-0 p-0">Export &nbsp; <i class="fa fa-download" aria-hidden="true"></i></p>
              </button>
            </div>
          </div>

          <div class="col-6 col-md-5">
            <div class="form-group">
              <label class="custom__label" for="vehicle_rc_no">State</label>
              <select wire:model.live.debounce.150ms="bookingState" wire:loading.attr="disabled" wire:target="bookingState" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="bookingState">
                @foreach ($stateData as $list)
                <option @if($list->state_id === 27 ) selected @endif value="{{ $list->state_id }}">{{ $list->state_name }} (Total City: {{ $list->total_city_count }}) </option>

                @endforeach
              </select>
            </div>
          </div>
          <div class="col __col-3">
            <div class="form-group">
              <label class="custom__label" for="toDate">Search</label>
              <input type="search" wire:model.live.debounce.150ms="search" wire:loading.attr="disabled" wire:target="bookingState" class="custom__input__field form-control rounded-0 form-control-sm float-right" placeholder="Search">
            </div>
          </div>
        </div>

      </div>
      <!-- <table class="table table-bordered table-sm table-responsive-sm mt-2"> -->
      <div class="card-body p-2 overflow-auto">
        <table class="table custom__table table-bordered table-sm">
        @if (!empty($total_data))
										<?php $sr = 1; ?>
								@foreach ($total_data['driverInfo'] as $key_dv)  

								<thead>
									<tr>
										<th style="font-size: 10px;">
										{{ $key_dv->city_name }} Vehicle : ({{ $key_dv->total_vehicle }}) </th>
									</tr>
                                        </thead>
                                        <tbody>
									   
                                             <tr>
                                               <td>Booking Type </td>
                                               <td>MFR
											   <br> V: ({{$key_dv->medical_first_responder}})</td>
												<td>PTS <br>V: ({{$key_dv->patient_transfer_ambulances}})</td>
												<td>PTS <br>V: (AC)({{$key_dv->patience_ransafer_ac}})</td>
												<td>BLS <br>V: ({{$key_dv->basic_life_support}})</td>
												<td>BLS(AC) <br>V: ({{$key_dv->basic_life_support_ac}})</td>
												<td>ALS <br>V: ({{$key_dv->advance_life_support}})</td>
												<td>DB(S) <br>V: {{$key_dv->dead_body_small}}</td>
												<td>DB(M) <br>V: {{$key_dv->dead_body_medium}}</td>
												<td>DB(B) <br>V: {{$key_dv->dead_body_big}}</td>
												<td>DB(M) <br>V: Fridge {{$key_dv->dead_body_medium_fridge}}</td>
												<td>DB(B) <br>V: Fridge{{$key_dv->dead_body_big_fridge}}</td>
												<td>Others</td>
                                             </tr>
                                           
                                            @foreach ($total_data['bookingInfo'] as $key)  

												@if($key_dv->city_name == $key->city_name)

													<tr>
														<td> Total Booking : ({{ $key->total_booking }})
															<br> Enquiry Booking T: {{$key->enquiry_booking}}</td>
													<td>{{$key->enq_booking_a}}</td>
													<td>{{$key->enq_booking_b}}</td>
														<td>{{$key->patience_ransafer_ac}}</td>
														<td>{{$key->enq_booking_c}}</td>
														<td>{{$key->enq_booking_c_ac}}</td>
														<td>{{$key->enq_booking_d}}</td>
														<td>{{$key->enq_booking_h}}</td>
														<td>{{$key->enq_booking_h1}}</td>
														<td>{{$key->enq_booking_h2}}</td>
														<td>{{$key->enq_booking_h1_ac}}</td>
														<td>{{$key->enq_booking_h_ac}}</td>
														<td>{{$key->enq_booking_no_cat}}</td>
														
													</tr>
												

													<tr>
														<td>New Booking T: {{$key->new_booking}}</td>
														<td>{{$key->new_booking_a}}</td>
														<td>{{$key->new_booking_b}}</td>
														<td>{{$key->patience_ransafer_ac}}</td>
														<td>{{$key->new_booking_c}}</td>
														<td>{{$key->new_booking_c_ac}}</td>
														<td>{{$key->new_booking_d}}</td>
														<td>{{$key->new_booking_h}}</td>
														<td>{{$key->new_booking_h1}}</td>
														<td>{{$key->new_booking_h2}}</td>
														<td>{{$key->new_booking_h1_ac}}</td>
														<td>{{$key->new_booking_h_ac}}</td>
														<td>{{$key->new_booking_no_cat}}</td>
														
													</tr>


													<tr>
													
														<td>Ongoing Booking T: {{$key->ongoing_booking}}</td>
														<td>{{$key->ongoing_booking_a}}</td>
													<td>{{$key->ongoing_booking_b}}</td>
														<td>{{$key->patience_ransafer_ac}}</td>
														<td>{{$key->ongoing_booking_c}}</td>
														<td>{{$key->ongoing_booking_c_ac}}</td>
														<td>{{$key->ongoing_booking_d}}</td>
														<td>{{$key->ongoing_booking_h}}</td>
														<td>{{$key->ongoing_booking_h1}}</td>
														<td>{{$key->ongoing_booking_h2}}</td>
														<td>{{$key->ongoing_booking_h1_ac}}</td>
														<td>{{$key->ongoing_booking_h_ac}}</td>
														<td>{{$key->ongoing_booking_no_cat}}</td>
														
													</tr>


													<tr>
													
													
													<td>Invoice Assign T: {{$key->invoice_booking}}</td> 
													<td>{{$key->invoice_booking_a}}</td>
													<td>{{$key->invoice_booking_b}}</td>
														<td>{{$key->patience_ransafer_ac}}</td>
														<td>{{$key->invoice_booking_c}}</td>
														<td>{{$key->invoice_booking_c_ac}}</td>
														<td>{{$key->invoice_booking_d}}</td>
														<td>{{$key->invoice_booking_h}}</td>
														<td>{{$key->invoice_booking_h1}}</td>
														<td>{{$key->invoice_booking_h2}}</td>
														<td>{{$key->invoice_booking_h1_ac}}</td>
														<td>{{$key->invoice_booking_h_ac}}</td>
														<td>{{$key->invoice_booking_no_cat}}</td>
													
												</tr>



												<tr>
													
												<td>Complete Booking T: {{$key->complete_booking}}</td> 
												<td>{{$key->complete_booking_a}}</td>
													<td>{{$key->complete_booking_b}}</td>
														<td>{{$key->patience_ransafer_ac}}</td>
														<td>{{$key->complete_booking_c}}</td>
														<td>{{$key->complete_booking_c_ac}}</td>
														<td>{{$key->complete_booking_d}}</td>
														<td>{{$key->complete_booking_h}}</td>
														<td>{{$key->complete_booking_h1}}</td>
														<td>{{$key->complete_booking_h2}}</td>
														<td>{{$key->complete_booking_h1_ac}}</td>
														<td>{{$key->complete_booking_h_ac}}</td>
														<td>{{$key->complete_booking_no_cat}}</td>
												
												</tr>

												<tr>
													
												<td>Cancel Booking T: {{$key->cancel_booking}}</td> 
												<td>{{$key->cancel_booking_a}}</td>
													<td>{{$key->cancel_booking_b}}</td>
														<td>{{$key->patience_ransafer_ac}}</td>
														<td>{{$key->cancel_booking_c}}</td>
														<td>{{$key->cancel_booking_c_ac}}</td>
														<td>{{$key->cancel_booking_d}}</td>
														<td>{{$key->cancel_booking_h}}</td>
														<td>{{$key->cancel_booking_h1}}</td>
														<td>{{$key->cancel_booking_h2}}</td>
														<td>{{$key->cancel_booking_h1_ac}}</td>
														<td>{{$key->cancel_booking_h_ac}}</td>
														<td>{{$key->cancel_booking_no_cat}}</td>
													
												</tr>


												<tr>
													
												<td>Future Booking T: {{$key->future_booking}}</td>
													<td>{{$key->future_booking_a}}</td>
													<td>{{$key->future_booking_b}}</td>
														<td>{{$key->patience_ransafer_ac}}</td>
														<td>{{$key->future_booking_c}}</td>
														<td>{{$key->future_booking_c_ac}}</td>
														<td>{{$key->future_booking_d}}</td>
														<td>{{$key->future_booking_h}}</td>
														<td>{{$key->future_booking_h1}}</td>
														<td>{{$key->future_booking_h2}}</td>
														<td>{{$key->future_booking_h1_ac}}</td>
														<td>{{$key->future_booking_h_ac}}</td>
														<td>{{$key->future_booking_no_cat}}</td>
													
												</tr>

									      		@endif
		
                                @endforeach
                                @endforeach
											@endif
               </tr>
        </table>
        <div style="text-align:center;" wire:loading wire:target="selectedDate" wire:key="selectedDate"><i class="fa fa-spinner fa-spin mt-2 ml-2"></i>loading</div>
        <div class="custom__pagination mt-2 text-right pt-1 card-footer__ clearfix">
        {!! $driverInfo->links() !!}

        </div>
      </div>
    </div>
    <div class="container h-100 w-100">
            <div class="row w-100 h-100 align-items-center justify-content-center" wire:loading wire:target="selectedDate,bookingState,filterCondition" wire:key="selectedDate,bookingState,filterCondition">
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
    @endif



  </div>
</div>
</div>
 <!-- /.card -->
 <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script>
    $(document).ready(function () {
        $('#city_state').select2();
        $('#city_state').on('change', function (e) {
            var data = $('#city_state').select2("val");
            @this.set('ottPlatform', data);
        });
    });
</script>
  <!-- /.row -->