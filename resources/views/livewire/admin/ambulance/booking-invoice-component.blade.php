<div class="container-fluid">

@if (session()->has('message'))
    <div class="alert alert-success alert-dismissible" role="alert">
        <span type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></span>
        <strong>{{ session('message') }}!</strong>
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
                        <option selected value="Invoice">Invoice</option>
                        <option value="Enquiry">Enquiry</option>
                            <option value="New">New</option>
                            <option value="Ongoing">Ongoing</option>
                            <option  value="Complete">Complete</option>
                            <option value="Cancel">Cancel</option>
                        </select>
                    </div>
                </div>
                <div class="col-6 col-sm-auto col-md-2">
                    <div class="form-group">
                        <label class="custom__label">Executive Name</label>
                        <select wire:model.live.debounce.150ms="executiveId" wire:mode.live="executiveId" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="exampleSelectRounded0">
                        <option selected value="All">All</option>
                        @foreach($customerSupport as $support)
                        <option value="{{$support->id}}">{{$support->admin_name}}</option>
                           @endforeach
                        </select>
                    </div>
                </div>
             
                <div class="col-6 col-sm-auto col-md-2">
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
					<th>Invoice No.</th>
					<th>Booking Date</th>
					<th>Scheduled At</th>
					<th>Client Details</th>
					<th>Pickup Address</th>
					<th>Drop Address</th>
					<th>State</th>
					<th>Booking Category</th>
					<th>Booking Type</th>
                    <th>Executive Name</th>
					<th>Remark</th>
					<th>Amount Total</th>
					<th>Company Amount</th>
					<th>Driver Details</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
                    @php
                    $srno = 1;
                    $executiveData = DB::table('admin')->get();
                    @endphp

                    @if(!empty($bookingInvoiceData))

                    @foreach($bookingInvoiceData as $list)
                    <tr>
                        <td>{{$srno}}</td>
                        <td>{{$list->booking_id}}</td>                          
                            <td>@if($list->created_time)
							 {{$list->created_time}}
								@else  @endif
                            </td>
                            <td>{{$list->booking_schedule_time}}</td>
                            <td>
                              <p class="m-0 mt-2">{{$list->booking_con_name}}</p>
                              <p class="m-0">{{$list->booking_con_mobile}}</p> 
                            </td> 
                            <td>{!!wordwrap($list->booking_pickup,25,"<br>\n")!!}</td>
                            <td>{!!wordwrap($list->booking_drop,25,"<br>\n")!!}</td>
                             <td>{{$list->state_name ?? 'N/A'}}</td>
                             <td>{{$list->booking_view_category_name}}</td>
                             <td> @if($list->booking_type =='0')
                                <p class="m-0">Regular Booking</p>
                                @elseif($list->booking_type =='1')
                                <p class="m-0">Rental Booking</p>
                                @elseif($list->booking_type =='2')
                                <p class="m-0">Bulk Booking</p>
                                @elseif($list->booking_type =='3')
                                <p class="m-0">Hospital Booking</p>
                                @elseif($list->booking_type =='4')
                                <p class="m-0">Pink</p>
                                @elseif($list->booking_type =='6')
                                <p class="m-0">Animal</p>
                                @else
                                <p class="m-0"></p>
                                @endif</td>
                              <td>{{($list->booking_user_id != '0') ? $leadbookingData : "N/A"}}</td>
                              <td> @if(($list->remark_id))
                            <input type="text" value="{{$list->remark_text}}" class="text-center">
                            <p class="m-0 mt-2">
                                Commented:
                                {{$list->admin_name}}
                            </p>
                            @else
                            <input type="text" placeholder="Enter The Remark" class="text-center">
                            @endif</td>
                              <td>&#8377;{{$list->booking_amount}}</td>
                              <td>&#8377;{{$list->booking_adv_amount}}</td>
                              <td>
                              <p class="m-0 mt-2">{{$list->driver_name.' '.$list->driver_last_name}}</p>
                              <p class="m-0">{{$list->driver_mobile}}</p> 
                            </td> 
                              <td> <p>
                                @if ($list->booking_status == '0')
                                Enquiry
                                @elseif ($list->booking_status == '1')
                                New Booking
                                @elseif ($list->booking_status == '2')
                                Ongoing
                                @elseif ($list->booking_status == '3')
                                Invoice
                                @elseif ($list->booking_status == '4')
                                Completed
                                @elseif ($list->booking_status == '5')
                                Canceled
                                @elseif ($list->booking_status == '6')
                                Future
                                @else
                                @endif
                            </p></td>

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
                    @endif
                </table>
                <div class="custom__pagination mt-2 text-right pt-1 card-footer__ clearfix">
                    {!! $bookingInvoiceData->links() !!}
                </div>
            </div>

        </div>
        <div class="row" wire:loading wire:target="selectedDate,fromDate,toDate,selectedbookingStatus,executiveId,search" wire:key="selectedDate,fromDate,toDate,selectedbookingStatus,executiveId,search">                <div class="col">
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
</div>
