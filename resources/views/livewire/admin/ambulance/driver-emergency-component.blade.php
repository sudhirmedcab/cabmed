
<div class="content">
    <div class="container-fluid">
        @if (session()->has('message') && session()->has('type') == 'delete')
        <div class="alert alert-danger">{{ session('message') }}</div>
        @elseif (session()->has('message') && session()->has('type') == 'store')
        <div class="alert alert-success">{{ session('message') }}</div>
        @endif

          <p class="text-center pt-2"> Driver Emergency Data</p>

        <div class="card custom__filter__responsive">
            <div class="card-header custom__filter__select ">

                <div class="row">
                    
                <div class="col __col-{{$this->activeTab == 'UnderVerificationBySelf' || $this->activeTab == 'walletBalance' ? 2:3}}">
                        <div class="form-group">
                            <label class="custom__label" for="fromDate">From </label>
                            <input wire:model.live="selectedFromDate" {{ !$isCustom ? 'disabled' : '' }} type="date" class="custom__input__field rounded-0 form-control form-control-sm" id="fromDate" placeholder="Enter from date">
                        </div>
                    </div>
                    <div class="col __col-{{$this->activeTab == 'UnderVerificationBySelf' || $this->activeTab == 'walletBalance' ? 2:3}}">
                        <div class="form-group">
                            <label class="custom__label" for="toDate">To</label>
                            <input wire:model.live="selectedToDate" max="<?= date('Y-m-d') ?>" type="date" {{ !$isCustom ? 'disabled' : '' }} class="custom__input__field rounded-0 form-control form-control-sm" id="toDate" placeholder="Enter to date">
                        </div>
                    </div>
                    <div class="col -{{$this->activeTab == 'UnderVerificationBySelf' || $this->activeTab == 'walletBalance' ? 2:3}}">
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
                   
                    <div class="col __col-3">
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
                         <th>Sr.No.</th>
						<th>Emergency Id.</th>
						<th>Booking Id.</th>
						<th>Name</th>
						<th>Mobile</th>
						<th>Wallet Amounts</th>
						<th>Requested Time</th>
                        <th>Action</th>
                    </tr>
                    @php
                    $srno = 1;
                    @endphp
                    @if(!empty($driver_list))
                    @foreach ($driver_list as $list)     
                    <tr>
                             <td class="table-plus">{{$srno++}}</td>
                              <td>{{$list->driver_emergency_driver_id }}</td>
                              <td>{{$list->driver_emergency_booking_id }}</a></td>
                             <td>{{$list->driver_name.' '.$list->driver_last_name}}</td>
                             <td>{{$list->driver_mobile}}</td>
							<td>&#8377;.{{$list->driver_wallet_amount}}</td>
                          <td> @php
                                $timestamp = is_numeric($list->driver_emergency_request_timing) ? (int)$list->driver_emergency_request_timing : null;
                                 @endphp

                                    @if(isset($timestamp))
                                         {{ date('j F Y, H:i:s A', $timestamp) }}
                                  @else
                              @endif</td>                       
                      
                        <td class="action__btn lbtn-group">
                            <button class="btn-primary"><i class="fa fa-edit"></i></button>
                            <button class="btn-success"><i class="fa fa-eye"></i></button>
                            <!-- <button  wire:navigate href="#" target="_blank" class="btn-primary"><i class="fa fa-edit fa-sm"></i></button> -->

                        </td>
                    </tr>
                    @php
                    $srno++
                    @endphp
                    @endforeach
                    @endif
                </table>
                <!-- <span wire:loadingf wire:target="filterCondition">Loading...</span> -->
                <div class="custom__pagination mt-2 text-right pt-1 card-footer__ clearfix">
                {{$driver_list->links()}}
                </div>
            </div>
        </div>

    	<div class="card-box mb-30">
                        <div class="pd-20 card-box mb-30 p-2">
                            <div class="clearfix">
                                <div class="pull-left">
                                    <p class="p-0 m-0"> Driver Location In Map</p>         
                                </div>
                            </div>
                                    <div class="mt-2">
									<div id="map" class='rounded' style="height: 400px;"></div>
							</div>
                  </div>
                     <!-- booking Details ends -->
            
				</div>

        <div class="container h-100 w-100">
            <div class="row w-100 h-100 align-items-center justify-content-center" wire:loading wire:target="selectedDate,driverVerificationStatus,filterCondition" wire:key="selectedDate,Onduty,Offduty">
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

    <!---------------------= Js parts of the Consumer Emergency Data -------------------------------->
      <!-- /.card -->
</div>
@php 
$mapKey = DB::table('aa_setting')->where('a_setting_id', 9)->first();
@endphp
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
			function initMap() {


				var buket_map_data = @json($buket_map_data);

				var map = new google.maps.Map(document.getElementById('map'), {
					zoom: 12,
					center: new google.maps.LatLng(buket_map_data[0].driver_emergency_driver_lat, buket_map_data[0].driver_emergency_driver_long),
				});

				buket_map_data.forEach(function(location) {
					var icon = {
						url: '/assets/app_icon/large_car.png', // Replace with the URL of your custom icon
						scaledSize: new google.maps.Size(40, 40), // Adjust the size of the icon
					};

					var marker = new google.maps.Marker({
						position: new google.maps.LatLng(location.driver_emergency_driver_lat, location.driver_emergency_driver_long),
						map: map,
						title: location.driver_name + ' ' + location.driver_last_name + ' :  ' + location.time_diffrence,
						icon: icon, // Set the custom icon,

					});
				});
			}
		</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{$mapKey->a_setting_value}}&callback=initMap" async defer></script> 

  <!-- /.row -->


