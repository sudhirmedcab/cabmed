


<div class="content">
    @if($activeTab == 'ConsumerEmergency')
    <div class="container-fluid">
        @if (session()->has('message') && session()->has('type') == 'delete')
        <div class="alert alert-danger">{{ session('message') }}</div>
        @elseif (session()->has('message') && session()->has('type') == 'store')
        <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        @include('livewire.admin.ambulance.booking-nav-component')

        @if ($isOpen)
        @include('livewire.admin.ambulance.consmer_emergency_models')
        @endif

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
						<th> Name</th>
						<th> Mobile</th>
						<th>Wallet</th>
                        <th>Remark</th>
						<th>Requested Time</th>
                        <th>Action</th>
                    </tr>
                    @php
                    $srno = 1;
                    @endphp
                    @if(!empty($consumer_list))
                    @foreach ($consumer_list as $list)     
                    <tr>
                             <td class="table-plus">{{$srno++}}</td>
                              <td>{{$list->consumer_emergency_id }}</td>
                              <td>{{$list->consumer_emergency_booking_id }}</a></td>
                             <td>{{$list->consumer_name}}</td>
                             <td>{{$list->consumer_mobile_no}}</td>
							<td>&#8377;.{{$list->consumer_wallet_amount}}</td>
                            <td> @if($list->remark_id ) {{$list->remark_text}} @else
                            <input type="text" placeholder="Enter The Remark" id="remarkTest" class="text-center">
                                 @endif</td>
                          <td> @php
                                $timestamp = is_numeric($list->consumer_emergency_request_timing) ? (int)$list->consumer_emergency_request_timing : null;
                                 @endphp

                                    @if(isset($timestamp))
                                         {{ date('j F Y, H:i:s A', $timestamp) }}
                                  @else
                              @endif</td>                       
                      
                        <td class="action__btn lbtn-group">
                           @if($list->consumer_emergency_status=='1')
                            <button class="btn-primary"><i class="fa fa-check"></i></button>
                            @else
                            <button class="btn-danger submitRemark" type="submit"><i class="fa fa-times" aria-hidden="true"></i></button>
                            @endif                      
                         <button class="btn-success" wire:click="showMap({{$list->consumer_emergency_id}})"><i class="fa fa-eye"></i></button>

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
                {{$consumer_list->links()}}
                </div>
            </div>
        </div>

        <div class="container h-100 w-100">
            <div class="row w-100 h-100 align-items-center justify-content-center" wire:loading wire:target="selectedDate,selectedFromDate,filterCondition,selectedToDate" wire:key="selectedDate,selectedFromDate,selectedToDate,Offduty">
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

      <!-- /.card -->
   

    @endif 

    @if($this->activeTab == 'DriverEmergency')

        <div class="container-fluid">
        @if (session()->has('message') && session()->has('type') == 'delete')
        <div class="alert alert-danger">{{ session('message') }}</div>
        @elseif (session()->has('message') && session()->has('type') == 'store')
        <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        @include('livewire.admin.ambulance.booking-nav-component')

        @if ($isOpen)
        @include('livewire.admin.ambulance.consmer_emergency_models')
        @endif

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
						<th> Name</th>
						<th> Mobile</th>
						<th>Wallet Amounts</th>
						<th>Requested Time</th>
						<th>Remark</th>
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
                              <td> @if($list->remark_id ) {{$list->remark_text}} @else
                            <input type="text" placeholder="Enter The Remark" class="text-center">
                                 @endif</td>
                            <td class="action__btn lbtn-group">
                           @if($list->driver_emergency_status=='1')
                            <button class="btn-primary"><i class="fa fa-check"></i></button>
                            @else
                            <button class="btn-danger"><i class="fa fa-times" aria-hidden="true"></i></button>
                            @endif
                            <button class="btn-success" wire:click="showMap({{$list->driver_emergency_driver_id}})"><i class="fa fa-eye"></i></button>

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
    @endif 
</div>

  <!-- /.row -->


