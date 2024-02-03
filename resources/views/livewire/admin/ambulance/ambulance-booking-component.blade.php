<div class="container-fluid">
    @include('livewire.admin.ambulance.booking-nav-component')

    <div class="card ">
        <div class="card-header custom__filter__select ">

            <div class="row">
                <div class="col-6 col-sm-auto col-md-2">
                    <div class="form-group">
                        <label class="custom__label" for="fromDate">From </label>
                        <input wire:model.live="selectedFromDate" type="date" class="custom__input__field rounded-0 form-control form-control-sm" id="fromDate" placeholder="Enter from date">
                    </div>
                </div>
                <div class="col-6 col-sm-auto col-md-2">
                    <div class="form-group">
                        <label class="custom__label" for="toDate">To</label>
                        <input wire:model.live="selectedToDate" type="date" class="custom__input__field rounded-0 form-control form-control-sm" id="toDate" placeholder="Enter to date">
                    </div>
                </div>
                <div class="col-6 col-sm-auto col-md-2">
                    <div class="form-group">
                        <label class="custom__label">Date</label>
                        <select wire:model.live.debounce.150ms="selectedDate" wire:mode.live="selectedDate" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="exampleSelectRounded0">
                            <option selected value="all">All</option>
                            <option value="today">Today</option>
                            <option value="yesterday">Yesterday</option>
                            <option value="thisWeek">This Week</option>
                            <option value="thisMonth">This Month</option>
                        </select>
                    </div>
                </div>
                <div class="col-6 col-sm-auto col-md-2">
                    <div class="form-group">
                        <label class="custom__label">Type</label>
                        <select wire:model.live.debounce.150ms="selectedDate" wire:mode.live="selectedDate" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="exampleSelectRounded0">
                            <option selected value="all">All</option>
                            <option value="enquiry">Enquiry</option>
                            <option value="new">New</option>
                            <option value="ongoing">Ongoing</option>
                            <option value="invoice">Invoice</option>
                            <option value="complete">Complete</option>
                            <option value="cancel">Cancel</option>
                            <option value="future">Future</option>
                            <option value="assigned">Assigned</option>
                            <option value="history">History</option>
                        </select>
                    </div>
                </div>
                <div class="col-6 col-sm-auto col-md-2">
                    <div class="form-group">
                        <label class="custom__label">Category</label>
                        <select wire:model.live.debounce.150ms="selectedDate" wire:mode.live="selectedDate" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="exampleSelectRounded0">
                            <option selected value="road">Road</option>
                            <option value="rent">Rent</option>
                            <option value="bulk">Bulk</option>
                            <option value="animal">Animal</option>
                            <option value="pink">Pink</option>
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
                        <th>Date</th>
                        <th>Consumer</th>
                        <th>Category</th>
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
                            @else
                            <p class="m-0"></p>
                            @endif

                            <p class="m-0">{{$data->booking_view_category_name}}</p>
                        </td>
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
                                Booked
                                @elseif ($data->booking_status == '2')
                                Assigned
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
                            @if(($data->remark_id))
                            <input type="text" value="{{$data->remark_text}}" class="text-center">
                            @else
                            <input type="text" value="Enter Remark" class="text-center">
                            @endif
                            <br />
                            <p class="m-0 mt-2">
                                Commented:
                                {{$data->admin_name}}
                            </p>
                            <p class="m-0">
                                Lead:
                                @if ($data->booking_user_id = $adminData->id)
                                {{$adminData->admin_name}}
                                @endif
                            </p>
                        </td>
                        <td class="action__btn lbtn-group">
                            <button class="btn-primary"><i class="fa fa-edit"></i></button>
                            <button class="btn-success"><i class="fa fa-eye"></i></button>
                            <button wire:confirm="Are you sure you want to delete this Booking?" wire:click="delete({{ $data->booking_id }})" class="btn-danger"><i class="fa fa-trash"></i></button>
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
    </div>
</div>