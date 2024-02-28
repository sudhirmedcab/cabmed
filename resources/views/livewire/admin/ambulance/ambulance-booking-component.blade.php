<div class="container-fluid">
    @include('livewire.admin.ambulance.booking-nav-component')
    @if(!empty($bookingData))

    @if (session()->has('remarkSaved'))
    <div class="alert alert-success alert-dismissible" role="alert">
        <span type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></span>
        <strong>{{ session('remarkSaved') }}!</strong>
    </div>
    @endif

    @if (session()->has('errorRemark'))
    <div class="alert alert-danger alert-dismissible" role="alert">
        <span type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></span>
        <strong>{{ session('errorRemark') }}!</strong>
    </div>
    @endif

    <div class="card ">
        <div class="card-header custom__filter__select ">

            <div class="row">
                <div class="col-6 col-sm-auto col-md-2">
                    <div class="form-group">
                        <label class="custom__label" for="fromDate">From </label>
                        <input wire:model.live="selectedFromDate" {{ !$isCustom ? 'disabled' : '' }} type="date" class="custom__input__field rounded-0 form-control form-control-sm" id="fromDate" placeholder="Enter from date">
                    </div>
                </div>
                <div class="col-6 col-sm-auto col-md-2">
                    <div class="form-group">
                        <label class="custom__label" for="toDate">To</label>
                        <input wire:model.live="selectedToDate" type="date" max="<?=date('Y-m-d')?>" {{ !$isCustom ? 'disabled' : '' }} class="custom__input__field rounded-0 form-control form-control-sm" id="toDate" placeholder="Enter to date">
                    </div>
                </div>
                <div class="col-6 col-sm-auto col-md-2">
                    <div class="form-group">
                        <label class="custom__label">Date</label>
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
                <div class="col-6 col-sm-auto col-md-2">
                    <div class="form-group">
                        <label class="custom__label">Booking Status</label>
                            <select wire:model.live.debounce.150ms="selectedbookingStatus" wire:mode.live="selectedbookingStatus" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="exampleSelectRounded0">
                            <option selected value="New">New</option>

                            <option  value="All">All</option>
                            <option value="Enquiry">Enquiry</option>
                            <option value="Ongoing">Ongoing</option>
                            <option value="Invoice">Invoice</option>
                            <option  value="Complete">Complete</option>
                            <option value="Cancel">Cancel</option>
                            <option value="Future">Future</option>
                            <!-- <option value="History">History</option> -->
                        </select>
                    </div>
                </div>
                <div class="col-6 col-sm-auto col-md-2">
                    <div class="form-group">
                        <label class="custom__label">Category</label>
                        <select wire:model.live.debounce.150ms="selectedBookingType" wire:mode.live="selectedBookingType" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="exampleSelectRounded0">
                            <option selected value="Road">Road</option>
                            <option value="Rental">Rent</option>
                            <option value="Bulk">Bulk</option>
                            <option value="Animal">Animal</option>
                            <option value="Pink">Pink</option>
                        </select>
                    </div>
                </div>
                <div class="col-6 col-sm-auto col-md-2 ">
                    <div class="form-group">
                        <label class="custom__label" for="toDate">Search</label>
                        <input type="search" wire:model.live.debounce.150ms="search" class="custom__input__field form-control rounded-0 form-control-sm float-right" placeholder="Search">
                    </div>
                </div>
            </div>
            <div wire:loading.remove wire:target="filterCondition" class="card-body p-2 overflow-auto">
                <table class="table custom__table table-bordered table-sm ">
                    <tr>
                        <th>Sr.</th>
                        <th>Id</th>
                        <th>Added</th>
                        <th>Consumer</th>
                        <th>Category</th>
                        <th>Source</th>
                        <th>Pickup</th>
                        <th>Drop</th>
                        <th>Driver</th>
                        <th>Status</th>
                        <th>Remark</th>
                        <th>Action</th>
                    </tr>
                    @php
                    $srno = 1;
                    $adminData = DB::table('admin')->first();
                    @endphp
                    @if(!empty($bookingData))
                    @foreach($bookingData as $data)
                    <tr>
                        <td>{{$srno}}</td>
                        <td>{{$data->booking_id}}</td>
                        <td>
                            @if($data->created_at)
                            {{date("j F, Y h:i A" , strtotime($data->created_at))}}
                            <br />
                            @endif
                            @if($data->booking_schedule_time)
                            {{$data->booking_schedule_time}}
                            @endif
                        </td>
                        <td>
                            <p class="m-0 mt-2">{{$data->booking_con_name}}</p>
                            <p class="m-0">{{$data->booking_con_mobile}}</p>
                        </td>
                        <td>
                            @if($data->booking_type =='0')
                            <p class="m-0">Regular Booking</p>
                            @elseif($data->booking_type =='1')
                            <p class="m-0">Rental Booking</p>
                            @elseif($data->booking_type =='2')
                            <p class="m-0">Bulk Booking</p>
                            @elseif($data->booking_type =='3')
                            <p class="m-0">Hospital Booking</p>
                            @elseif($data->booking_type =='4')
                            <p class="m-0">Pink</p>
                            @elseif($data->booking_type =='6')
                            <p class="m-0">Animal</p>
                            @else
                            <p class="m-0"></p>
                            @endif

                            <p class="m-0">{{$data->booking_view_category_name}}</p>
                        </td>
                        <td>{{$data->booking_source}}</td>
                        <td>{!!wordwrap($data->booking_pickup,25,"<br>\n")!!}</td>
                        <td>{!!wordwrap($data->booking_drop,25,"<br>\n")!!}</td>
                        <td>
                            <p class="m-0 mt-2">{{$data->driver_name}}</p>
                            <p class="m-0">{{$data->driver_mobile}}</p>
                        </td>
                        <td>
                            <p>
                                @if ($data->booking_status == '0')
                                Enquiry
                                @elseif ($data->booking_status == '1')
                                New Booking
                                @elseif ($data->booking_status == '2')
                                Ongoing
                                @elseif ($data->booking_status == '3')
                                Invoice
                                @elseif ($data->booking_status == '4')
                                Completed
                                @elseif ($data->booking_status == '5')
                                Canceled
                                @elseif ($data->booking_status == '6')
                                Future
                                @else
                                @endif
                            </p>
                        </td>
                        <td>
                            <input type="text" wire:model.debounce.500ms="remarkText.{{$data->booking_id}}" wire:key="{{$data->remark_id }}" value="{{$data->remark_text ?? null}}" placeholder="Enter The Remark" class="text-center">
                            <input type="hidden" wire:model="bookingId.{{$data->booking_id}}" value="{{$data->booking_id}}" class="text-center">

                            <br />
                            <p class="m-0 mt-2">
                                Remark Text:
                               ( {{$data->remark_text}} )
                            </p>
                            <p class="m-0 mt-2">
                                Commented:
                                {{$data->admin_name}}
                            </p>
                            <p class="m-0">
                                @if ($data->booking_user_id === $adminData->id)
                                Lead: {{$adminData->admin_name}}
                                @endif
                            </p>
                        </td>
                        <td class="action__btn lbtn-group">
                        <button class="btn-primary" wire:click="saveRemark({{ $data->booking_id }})"><i class="fa fa-edit"></i></button>
                            <button class="btn-success"><i class="fa fa-eye"></i></button>
                            <!-- <button wire:confirm="Are you sure you want to delete this Booking?" wire:click="#" class="btn-danger"><i class="fa fa-trash"></i></button> -->
                        </td>
                    </tr>
                    @php
                    $srno++
                    @endphp
                    @endforeach
                    @endif
                </table>
                <div class="custom__pagination mt-2 text-right pt-1 card-footer__ clearfix">
                    {!! $bookingData->links() !!}
                </div>
            </div>

        </div>
        <div class="container">
            <div class="row" wire:loading wire:target="selectedDate,driverVerificationStatus,filterCondition" wire:key="selectedDate,Onduty,Offduty">
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
    @endif 
    @if(!empty($airAmbulanceData))
    <div class="card ">
        <div class="card-header custom__filter__select ">

            <div class="row">
                <div class="col-6 col-sm-auto col-md-2">
                    <div class="form-group">
                        <label class="custom__label" for="fromDate">From </label>
                        <input wire:model.live="selectedFromDate" {{ !$isCustom ? 'disabled' : '' }} type="date" class="custom__input__field rounded-0 form-control form-control-sm" id="fromDate" placeholder="Enter from date">
                    </div>
                </div>
                <div class="col-6 col-sm-auto col-md-2">
                    <div class="form-group">
                        <label class="custom__label" for="toDate">To</label>
                        <input wire:model.live="selectedToDate" type="date" max="<?=date('Y-m-d')?>" {{ !$isCustom ? 'disabled' : '' }} class="custom__input__field rounded-0 form-control form-control-sm" id="toDate" placeholder="Enter to date">
                    </div>
                </div>
                <div class="col-6 col-sm-auto col-md-2">
                    <div class="form-group">
                        <label class="custom__label">Date</label>
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
                <div class="col-6 col-sm-auto col-md-3">
                    <div class="form-group">
                        <label class="custom__label">Booking Status</label>
                        <select wire:model.live.debounce.150ms="selectedbookingStatus" wire:mode.live="selectedbookingStatus" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="exampleSelectRounded0">
                            <option selected value="All">All</option>
                            <option value="Enquiry">Enquiry</option>
                            <option value="New">New</option>
                            <option value="Ongoing">Ongoing</option>
                            <option value="Invoice">Invoice</option>
                            <option  value="Complete">Complete</option>
                            <option value="Cancel">Cancel</option>
                        </select>
                    </div>
                </div>
             
                <div class="col-6 col-sm-auto col-md-3 ">
                    <div class="form-group">
                        <label class="custom__label" for="toDate">Search</label>
                        <input type="search" wire:model.live.debounce.150ms="search" class="custom__input__field form-control rounded-0 form-control-sm float-right" placeholder="Search">
                    </div>
                </div>
            </div>
            <div wire:loading.remove wire:target="filterCondition" class="card-body p-2 overflow-auto">
                <table class="table custom__table table-bordered table-sm ">
                <tr>
					<th>Sr. No.</th>
					<th>ID</th>
					<th>Scheduled At</th>
					<th>Source</th>
					<th>Consumer Name.</th>
					<th>Patients Name.</th>
					<th>Air Enquiry Booking Type</th>
					<th>Booking Category</th>
					<th>Pickup Loction</th>
					<th>Drop Loction</th>
                    <th>Remark Details</th>
					<th>Booking Status</th>
					<th>Action</th>
				</tr>
                    @php
                    $srno = 1;
                    @endphp

                    @foreach($airAmbulanceData as $key)
                    <tr>
                        <td>{{$srno}}</td>
                        <td>{{$key->air_booking_view_id}}</td>                          
                            <td>@if($key->air_booking_schedule_time)
							 {{$key->air_booking_schedule_time}}
								@else  @endif
                            </td>
                            <td>{{$key->air_booking_source}}</td>                          
                        <td>
                            <p class="m-0 mt-2">{{$key->air_booking_con_name}}</p>
                            <p class="m-0">{{$key->air_booking_con_mobile}}</p>
                        </td>
                        <td>
                            <p class="m-0 mt-2">{{$key->patient_name}}</p>
                            <p class="m-0">{{$key->patient_mobile_no}}</p>
                            <p class="m-0">{{$key->patient_gender}}</p>
                        </td>
                        <td>
                            @if($key->air_booking_type =='4')
                            <p class="m-0">Air Ambulance Booking</p>                           
                            @else
                            <p class="m-0">Other Booking</p>
                            @endif

                        </td>
                        <td>{{$key->air_booking_category_name}}</td>
                        <td>{!!wordwrap($key->air_booking_pickup,25,"<br>\n")!!}</td>
                        <td>{!!wordwrap($key->air_booking_drop,25,"<br>\n")!!}</td>
                        <td>
                            @if(($key->remark_id))
                            <input type="text" value="{{$key->remark_text}}" class="text-center">
                            <p class="m-0 mt-2">
                                Commented:
                                {{$key->admin_name}}
                            </p>
                            @else
                            <input type="text" placeholder="Enter The Remark" class="text-center">
                            @endif
                           
                        </td>
                        <td>
                            <p>
                                @if ($key->air_booking_status == '0')
                                Enquiry
                                @elseif ($key->air_booking_status == '1')
                                New Booking
                                @elseif ($key->air_booking_status == '2')
                                Ongoing
                                @elseif ($key->air_booking_status == '3')
                                Invoice
                                @elseif ($key->air_booking_status == '4')
                                Completed
                                @elseif ($key->air_booking_status == '5')
                                Canceled
                                @else
                                @endif
                            </p>
                        </td>
                        <td class="action__btn lbtn-group">
                            <button class="btn-primary"><i class="fa fa-edit"></i></button>
                            <button class="btn-success"><i class="fa fa-eye"></i></button>
                            <!-- <button wire:confirm="Are you sure you want to delete this Booking?" wire:click="#" class="btn-danger"><i class="fa fa-trash"></i></button> -->
                        </td>
                    </tr>
                    @php
                    $srno++
                    @endphp
                    @endforeach
                </table>
                <div class="custom__pagination mt-2 text-right pt-1 card-footer__ clearfix">
                    {!! $airAmbulanceData->links() !!}
                </div>
            </div>

        </div>
        <div class="container">
            <div class="row" wire:loading wire:target="selectedDate,driverVerificationStatus,filterCondition" wire:key="selectedDate,Onduty,Offduty">
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
    @endif 
  
</div>
