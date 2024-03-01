<div class="content">
  <div class="container-fluid">
  @include('livewire.admin.vehicle.vehicle_nav_component')

  @if(!empty($this->activeTab == 'districtWise'))
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

          <div class="col-6 col-md-4">
            <div class="form-group">
              <label class="custom__label" for="vehicle_rc_no">State</label>
              <select wire:model.live.debounce.150ms="districtWise_state" wire:loading.attr="disabled" wire:target="districtWise_state" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="districtWise_state">
                @foreach ($stateData as $list)
                <option @if($list->state_id === 27 ) selected @endif value="{{ $list->state_id }}">{{ $list->state_name }} (Total District: {{ $list->district_count }}) </option>

                @endforeach
              </select>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="form-group">
              <label class="custom__label" for="vehicle_rc_no">Select For</label>
              <select wire:model.live.debounce.150ms="vehicleCreated" wire:loading.attr="disabled" wire:target="districtWise_state" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="vehicleCreated">
                                 <option value="All">All</option>
                                <!-- <option value="Driver">Driver</option>
                                <option value="Partner">Partner</option> -->
              </select>
            </div>
          </div>
          <div class="col __col-3">
            <div class="form-group">
              <label class="custom__label" for="toDate">Search</label>
              <input type="search" wire:model.live.debounce.150ms="search" wire:loading.attr="disabled" wire:target="districtWise_state" class="custom__input__field form-control rounded-0 form-control-sm float-right" placeholder="Search">
            </div>
          </div>
        </div>

      </div>

      <!-- <table class="table table-bordered table-sm table-responsive-sm mt-2"> -->
      <div class="card-body p-2 overflow-auto">
        <table class="table custom__table table-bordered table-sm">
          <tr>
            <th>Sr. No.</th>
			<th>District Name</th>
			<th>Total Vehicle </th>
			<th>Total On Duty </th>
			<th>Total OFF Duty </th>
			 <th>State Name</th>
          </tr>

          @if (!empty($responseData))
          @php
          $srno = 1
          @endphp
          <tr>
            @foreach($responseData as $list)
          <tr>
                <td class="table-plus">{{$srno}}</td>
                <td>{{$list['district_name']}}</td>
                <td>{{$list['vehicle_count']}}</td>
                <td>{{$list['on_duty_count']}}</td>
                <td>{{$list['off_duty_count']}}</td>
                <td>{{$list['state_name']}}</td>
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
        </div>
      </div>
    </div>
    <div class="container h-100 w-100">
            <div class="row w-100 h-100 align-items-center justify-content-center" wire:loading wire:target="selectedDate,districtWise_state,filterCondition" wire:key="selectedDate,districtWise_state,filterCondition">
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

 @elseif(!empty($this->activeTab == 'divisionWise'))

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

          <div class="col-6 col-md-4">
            <div class="form-group">
              <label class="custom__label" for="vehicle_rc_no">State</label>
              <select wire:model.live.debounce.150ms="division_state" wire:loading.attr="disabled" wire:target="division_state" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="division_state">
                @foreach ($stateData as $list)
                <option @if($list->state_id === 27 ) selected @endif value="{{ $list->state_id }}">{{ $list->state_name }} (Total Division: {{ $list->division_count }}) </option>

                @endforeach
              </select>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="form-group">
              <label class="custom__label" for="vehicle_rc_no">Select For</label>
              <select wire:model.live.debounce.150ms="vehicleCreated" wire:loading.attr="disabled" wire:target="division_state" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="vehicleCreated">
                                 <option value="All">All</option>
                                <!-- <option value="Driver">Driver</option>
                                <option value="Partner">Partner</option> -->
              </select>
            </div>
          </div>
          <div class="col __col-3">
            <div class="form-group">
              <label class="custom__label" for="toDate">Search</label>
              <input type="search" wire:model.live.debounce.150ms="search" wire:loading.attr="disabled" wire:target="division_state" class="custom__input__field form-control rounded-0 form-control-sm float-right" placeholder="Search">
            </div>
          </div>
        </div>

      </div>

      <!-- <table class="table table-bordered table-sm table-responsive-sm mt-2"> -->
      <div class="card-body p-2 overflow-auto">
        <table class="table custom__table table-bordered table-sm">
          <tr>
            <th>Sr. No.</th>
			<th>Division Name</th>
			<th>Total Vehicle </th>
			 <th>State Name</th>
          </tr>

          @if (!empty($divisionData))
          @php
          $srno = 1
          @endphp
          <tr>
            @foreach($divisionData as $list)
          <tr>
                <td class="table-plus">{{$srno}}</td>
                <td>{{$list['division_name']}}</td>
                <td>{{$list['vehicle_count']}}</td>
                <td>{{$list['state_name']}}</td>
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
        </div>
      </div>
    </div>
    <div class="container h-100 w-100">
            <div class="row w-100 h-100 align-items-center justify-content-center" wire:loading wire:target="selectedDate,division_state,filterCondition" wire:key="selectedDate,division_state,filterCondition">
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

        @elseif(!empty($this->activeTab == 'totalData'))

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

          <div class="col-6 col-md-4">
            <div class="form-group">
              <label class="custom__label" for="vehicle_rc_no">State</label>
              <select wire:model.live.debounce.150ms="division_state" wire:loading.attr="disabled" wire:target="division_state" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="division_state">
                @foreach ($stateData as $list)
                <option @if($list->state_id === 27 ) selected @endif value="{{ $list->state_id }}">{{ $list->state_name }} (Total City: {{ $list->total_city_count }}) </option>

                @endforeach
              </select>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="form-group">
              <label class="custom__label" for="vehicle_rc_no">Select For</label>
              <select wire:model.live.debounce.150ms="vehicleCreated" wire:loading.attr="disabled" wire:target="division_state" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="vehicleCreated">
                                 <option value="All">All</option>
                                <!-- <option value="Driver">Driver</option>
                                <option value="Partner">Partner</option> -->
              </select>
            </div>
          </div>
          <div class="col __col-3">
            <div class="form-group">
              <label class="custom__label" for="toDate">Search</label>
              <input type="search" wire:model.live.debounce.150ms="search" wire:loading.attr="disabled" wire:target="division_state" class="custom__input__field form-control rounded-0 form-control-sm float-right" placeholder="Search">
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
                    <th>Base of Partner</th>
										<th>Total Partner</th>
										<th>Driver(Partner) </th>
										<th>Vehicle(Partner) </th>
									
									</tr>
								<tbody>
                                @if (!empty($totalData))
                                        @foreach ($totalData['partertotalData']['partnerData'] as $index => $partner)

                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $partner->city_name }}</td>
                                                <td>Base of Partner</td>
                                                <td>{{ $partner->total_partners }}</td>
                                                <td>{{ $totalData['partertotalData']['partnerdriverData'][$index]->total_count ?? 0 }}</td>
                                                <td>{{ $totalData['partertotalData']['partnervehicleData'][$index]->total_count ?? 0 }}</td>
                                                <!-- Add more columns as needed -->
                                            </tr>
                                        @endforeach
                                        @endif
										</tbody>
									</table>
                                    
                        <div style="text-align:center;" wire:loading wire:target="selectedDate" wire:key="selectedDate"><i class="fa fa-spinner fa-spin mt-2 ml-2"></i>loading</div>
                        <div class="custom__pagination mt-2 text-right pt-1 card-footer__ clearfix">
                        {!! $partnerData->links() !!}
                        </div>
    </div>
    <div class="card-body p-2 overflow-auto">
        <table class="table custom__table table-bordered table-sm">
                  <tr>
            <th>Sr. No.</th>
            <th>City Name</th>
            <th>Base of Driver</th>
            <th>Total Partner</th>
            <th>Driver(Self) </th>
            <th>Vehicle(Driver) </th>
        
        </tr>
    <tbody>
    @if (!empty($totalData))
    @foreach ($totalData['drivertotalData']['selfdriverData'] as $selfDriver)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $selfDriver->city_name }}</td>
            <td>Base of Driver</td>
            <td>0</td>
            <td>{{ $selfDriver->total_count }}</td>
            <td>{{ $totalData['drivertotalData']['selfvehicleData'][$loop->index]->total_count ?? 0 }}</td>
            <!-- Add more columns as needed -->
        </tr>
        @endforeach
        @endif

    </tbody>
    </table>
    </div>
      <div style="text-align:center;" wire:loading wire:target="selectedDate" wire:key="selectedDate"><i class="fa fa-spinner fa-spin mt-2 ml-2"></i>loading</div>
                        <div class="custom__pagination mt-2 text-right pt-1 card-footer__ clearfix mb-3 mr-2">
                        {!! $selfdriverData->links() !!}
                        </div>
                    <div class="container h-100 w-100">
                <div class="row w-100 h-100 align-items-center justify-content-center" wire:loading wire:target="selectedDate,filterCondition,vehicleCreated,division_state" wire:key="selectedDate,division_state,vehicleCreated,filterCondition">
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

        @isset($bookingData)

        <div class="container-fluid">
        @if (session()->has('message') && session()->has('type') == 'delete')
        <div class="alert alert-danger">{{ session('message') }}</div>
        @elseif (session()->has('message') && session()->has('type') == 'store')
        <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        <div class="card custom__filter__responsive">
            <div class="card-header custom__filter__select ">

                <div class="row">

                <div class="col- col-2">
                  <div class="form-group">
                  <label class="custom__label " for="vehicle_rc_no">Export Data</label>
                  <button style="line-height:0" class="custom__input__field form-control btn-primary text-white rounded-0 form-control-sm">
                    <p class="m-0 p-0">Export &nbsp; <i class="fa fa-download" aria-hidden="true"></i></p>
                  </button>
                </div>
              </div>

                <div class="col -col-2">
                        <div class="form-group">
                            <label class="custom__label" for="fromDate">From </label>
                            <input wire:model.live="selectedFromDate" {{ !$isCustom ? 'disabled' : '' }} type="date" class="custom__input__field rounded-0 form-control form-control-sm" id="fromDate" placeholder="Enter from date">
                        </div>
                    </div>
                    <div class="col -col-2">
                        <div class="form-group">
                            <label class="custom__label" for="toDate">To</label>
                            <input wire:model.live="selectedToDate" max="<?= date('Y-m-d') ?>" type="date" {{ !$isCustom ? 'disabled' : '' }} class="custom__input__field rounded-0 form-control form-control-sm" id="toDate" placeholder="Enter to date">
                        </div>
                    </div>
                    <div class="col -col-2">
                        <div class="form-group">
                            <label class="custom__label">Select</label>
                            <select wire:model.live.debounce.150ms="selectedDate" wire:model="check_for" wire:mode.live="selectedDate" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="exampleSelectRounded0">

                                <option selected value="all">All</option>
                                <option value="today">Today</option>
                                <option value="yesterday">Yesterday</option>
                                <option value="thisWeek">This Week</option>
                                <option value="custom">Custom Date</option>
                                <option value="thisMonth">This Month</option>
                            </select>
                        </div>
                    </div>
                   
                    <div class="col __col-2">
                    <div class="form-group" wire:ignore>
                      <label class="custom__label" for="vehicle_rc_no">Choose State</label>
                      <select wire:model.live.debounce.150ms="division_state" wire:loading.attr="disabled" wire:target="division_state" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="select2-dropdown">
                        @foreach ($stateData as $list)
                        <option @selected(($list->state_id ) == 27) value="{{ $list->state_id }}">{{ $list->state_name }} (Total City: {{ $list->total_city_count }}) </option>

                        @endforeach
                      </select>
                    </div>
                  </div>

                    <div class="col __col-2">
                        <div class="form-group">
                            <label class="custom__label" for="toDate">Search</label>
                            <input type="search" wire:model.live.debounce.150ms="search" class="custom__input__field form-control rounded-0 form-control-sm float-right" placeholder="Search">
                        </div>
                    </div>
                </div>

            </div>
          
            <!-- <table class="table table-bordered table-sm table-responsive-sm mt-2"> -->
            <div wire:loading.remove wire:target="filterCondition" class="card-body p-2 overflow-auto">
                <table class="table custom__table table-bordered table-sm ">
                    <tr>
                       <th>Sr. No.</th>
                       <th>City Name</th>
                       <th>Total</th>
                       <th>Enquiry</th>
                       <th>New</th>
                       <th>Ongoing</th>
                       <th>Invoice</th>
                       <th>Complete</th>
                        <th>Cancel</th>
                        <th>Future</th>
                    </tr>
                    @if(!empty($bookingData))
                    @php
                    $srno = 1;
                    @endphp
                    @foreach ($bookingData as $key_dv)
                     <tr>
                     <td class="table-plus">{{ $srno++ }}</td>
                       <td class="table-plus">{{ $key_dv->city_name }}</td>
                       <td class="table-plus">{{ $key_dv->total_booking }}</td>
                      <td class="table-plus">{{ $key_dv->enquiry_booking }}</td>
                       <td class="table-plus">{{ $key_dv->new_booking }}</td>
                        <td class="table-plus">{{ $key_dv->ongoing_booking }}</td>
                      <td class="table-plus">{{ $key_dv->invoice_booking }}</td>
                      <td class="table-plus">{{ $key_dv->complete_booking }}</td>
                       <td class="table-plus">{{ $key_dv->cancel_booking }}</td>
                       <td class="table-plus">{{ $key_dv->future_booking }}</td>    
                    </tr>
                    @php
                    $srno++
                    @endphp
                    @endforeach
                    @endif
                </table>
                <!-- <span wire:loadingf wire:target="filterCondition">Loading...</span> -->
                <div class="custom__pagination mt-2 text-right pt-1 card-footer__ clearfix">
                {!! $bookingData->links() !!}
                </div>
            </div>
        </div>

        <div class="container h-100 w-100">
            <div class="row w-100 h-100 align-items-center justify-content-center" wire:loading wire:target="selectedDate,division_state,filterCondition" wire:key="selectedDate,division_state,filterCondition">
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

    </div>

        @endisset

  </div>
</div>
</div>

@push('scripts')
<script>
    $(document).ready(function () {
        $('#select2-dropdown').select2();
        $('#select2-dropdown').on('change', function (e) {
            var data = $('#select2-dropdown').select2("val");
            @this.set('ottPlatform', data);
        });
    });
</script>
@endpush