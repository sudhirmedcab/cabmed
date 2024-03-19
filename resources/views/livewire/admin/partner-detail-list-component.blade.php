
<?php

    $driverdutystatusMapper['ON'] = "ON DUTY";
    $driverdutystatusMapper['OFF'] = "OFF DUTY";

    $driverstatusMapper['0'] = "NEW ";
    $driverstatusMapper['1'] = "ACTIVE";
    $driverstatusMapper['2'] = "INACTIVE";
    $driverstatusMapper['3'] = "DELETED";
    $driverstatusMapper['4'] = "APPLIED";

    $vehiclestatusMapper['0'] = "NEW ";
    $vehiclestatusMapper['1'] = "ACTIVE";
    $vehiclestatusMapper['2'] = "INACTIVE";
    $vehiclestatusMapper['3'] = "DELETED";
    $vehiclestatusMapper['4'] = "APPLIED";

    
    $bookingstatusMapper['0'] = "FREE";
    $bookingstatusMapper['1'] = "BOOKING";

    $transactionTypeMapper['1'] = " for add-in wallet(A)";
    $transactionTypeMapper['2'] = "for transfer to bank account (W)";
    $transactionTypeMapper['3'] = "fetch Amount from driver wallet (A)";
  
    ?>

<div class="content">
    <style>
        .loader {
            width: 150px;
            height: 150px;
            margin: 40px auto;
            transform: rotate(-45deg);
            font-size: 0;
            line-height: 0;
            animation: rotate-loader 5s infinite;
            padding: 25px;
            border: 1px solid #8a474d1f;
        }

        .loader .loader-inner {
            position: relative;
            display: inline-block;
            width: 50%;
            height: 50%;
        }

        .loader .loading {
            position: absolute;
            background: #dcdee5;
        }

        .loader .one {
            width: 100%;
            bottom: 0;
            height: 0;
            animation: loading-one 1s infinite;
        }

        .loader .two {
            width: 0;
            height: 100%;
            left: 0;
            animation: loading-two 1s infinite;
            animation-delay: 0.25s;
        }

        .loader .three {
            width: 0;
            height: 100%;
            right: 0;
            animation: loading-two 1s infinite;
            animation-delay: 0.75s;
        }

        .loader .four {
            width: 100%;
            top: 0;
            height: 0;
            animation: loading-one 1s infinite;
            animation-delay: 0.5s;
        }

        @keyframes loading-one {
            0% {
                height: 0;
                opacity: 1;
            }

            12.5% {
                height: 100%;
                opacity: 1;
            }

            50% {
                opacity: 1;
            }

            100% {
                height: 100%;
                opacity: 0;
            }
        }

        @keyframes loading-two {
            0% {
                width: 0;
                opacity: 1;
            }

            12.5% {
                width: 100%;
                opacity: 1;
            }

            50% {
                opacity: 1;
            }

            100% {
                width: 100%;
                opacity: 0;
            }
        }

        @keyframes rotate-loader {
            0% {
                transform: rotate(-45deg);
            }

            20% {
                transform: rotate(-45deg);
            }

            25% {
                transform: rotate(-135deg);
            }

            45% {
                transform: rotate(-135deg);
            }

            50% {
                transform: rotate(-225deg);
            }

            70% {
                transform: rotate(-225deg);
            }

            75% {
                transform: rotate(-315deg);
            }

            95% {
                transform: rotate(-315deg);
            }

            100% {
                transform: rotate(-405deg);
            }
        }
    </style>
    <div class="container-fluid">
    
    @if (session()->has('message') && session()->get('type') == 'delete')
    <div class="alert alert-danger alert-dismissible" role="alert">
        <span type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></span>
        <strong>{{ session('message') }}!</strong>
            </div>
        @elseif (session()->has('message') && session()->get('type') == 'store')
            <div class="alert alert-success alert-dismissible" role="alert">
                <span type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></span>
                <strong>{{ session('message') }}!</strong>
            </div>
        @endif
        <div class="card my-2  text-center">
            <div class="card-header custom__driver__filter">
                <ul class="nav nav-tabs custom__nav__tab  card-header-tabs">

             
                <li  class="nav-item {{ Request::is('partner-detail/*') || $this->activeTab == 'partner_details' ? 'active' : '' }}">
                    <a  wire:navigate href="{{route('partner-details-component',['partnerId' => Crypt::encrypt($decryptpartnerId)])}}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('partner_details')">
                  Partner Details
                    </a>
                </li>

            <li class="nav-item {{ Request::is('partner-details/*/driver') || $this->activeTab == 'driver' ? 'active' : '' }}">
                <a wire:navigate href="{{ route('partner-details-list-component', ['partnerId' => Crypt::encrypt($decryptpartnerId), 'detailList' => 'driver']) }}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('driver')">
                    Driver Details
                </a>
            </li>
                <li class="nav-item {{ Request::is('partner-details/*/vehicle') ? 'active' : '' }}">
                <a wire:navigate href="{{ route('partner-details-list-component', ['partnerId' => Crypt::encrypt($decryptpartnerId), 'detailList' => 'vehicle']) }}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('vehicle')">
                    Vehicle Details
                </a>
            </li>
                <li class="nav-item {{ Request::is('partner-details/*/transaction') ? 'active' : '' }}">
                <a wire:navigate href="{{ route('partner-details-list-component', ['partnerId' => Crypt::encrypt($decryptpartnerId), 'detailList' => 'transaction']) }}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('transaction')">
                    Transaction Details
                </a>
            </li>

            </li>
                <li class="nav-item {{ Request::is('partner-details/*/assign') ? 'active' : '' }}">
                <a wire:navigate href="{{ route('partner-details-list-component', ['partnerId' => Crypt::encrypt($decryptpartnerId), 'detailList' => 'assign']) }}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('assign')">
                    Assign Page
                </a>
            </li>
                <li class="nav-item {{ Request::is('partner-details/*/refferal') ? 'active' : '' }}">
                <a wire:navigate href="{{ route('partner-details-list-component', ['partnerId' => Crypt::encrypt($decryptpartnerId), 'detailList' => 'refferal']) }}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('refferal')">
                    Refferal Details
                </a>
            </li>

                </ul>
            </div>
        </div>

        <div class="card mt-2 custom__filter__responsive">
            <div class="card-header custom__filter__select">

            @if(!(Request::is('partner-details/*/refferal')))

            <div class="row">
                    <div class="col __col-3">
                        <div class="form-group">
                            <label class="custom__label" for="fromDate">From </label>
                            <input wire:model.live="selectedFromDate" {{ !$isCustom ? 'disabled' : '' }} type="date" class="custom__input__field rounded-0 form-control form-control-sm" id="fromDate" placeholder="Enter from date">
                        </div>
                    </div>
                    <div class="col __col-3}}">
                        <div class="form-group">
                            <label class="custom__label" for="toDate">To</label>
                            <input wire:model.live="selectedToDate" type="date" max="<?=date('Y-m-d')?>" {{ !$isCustom ? 'disabled' : '' }} class="custom__input__field rounded-0 form-control form-control-sm" id="toDate" placeholder="Enter to date">
                        </div>
                    </div>
                    <div class="col -col-3">
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
            @endif

            <!-- <table class="table table-bordered table-sm table-responsive-sm mt-2"> -->
            @if(!empty($driver_details))
            <div wire:loading.remove wire:target="filterCondition" class="card-body p-2 overflow-auto">
                <table class="table custom__table table-bordered table-sm">
                    <tr>
                        <th>Sr.</th>
                        <th>Id</th>
                        <th>Created at</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>DL</th>
                        <th>Booking</th>
                        <th>Status</th>
                        <th>Duty Status</th>
                        <th>Action</th>

                    </tr>

                    @php
                    $srno = 1
                    @endphp @if(!empty($driver_details))

                    @foreach($driver_details as $driver)
                    <tr>
                        <td>{{ $srno }}</td>
                        <td>{{ $driver->driver_id }}</td>
                        <td>{{ date("j F, Y h:i A", strtotime($driver->created_at)) }}</td>
                        <td>{{$driver->driver_name.' '.$driver->driver_last_name}}</td>
                        <td>{{$driver->driver_mobile}}</td>
                        <td>{{$driver->driver_details_dl_number}}</td>
                        <td>{{$bookingstatusMapper[$driver->driver_on_booking_status]}}</td>
                        <td>{{$driverstatusMapper[$driver->driver_status]}}</td>
                        <td>{{$driverdutystatusMapper[$driver->driver_duty_status]}}</td>
                 
                        <td class="action__btn lbtn-group">
                            <!-- <button class="btn-primary"><i class="fa fa-edit"></i></button> -->
                            <button  wire:navigate href="{{route('admin.driver-details-component',['driverId' => Crypt::encrypt($driver->driver_id)])}}" class="btn-success"><i class="fa fa-eye fa-sm"></i></button>
                        </td>
                    </tr>
                    @php
                    $srno++
                    @endphp
                    @endforeach
                    @endif

                </table>
                <!-- <span wire:loadingf wire:target="filterCondition">Loading...</span> -->
                <div class="custom__pagination mt-2 pt-1 card-footer__ clearfix">
                {{ $driver_details->links(data: ['scrollTo' => '#paginated-posts']) }}
                </div>
            </div>
            @elseif(!empty($Vehicles))
            <div wire:loading.remove wire:target="filterCondition" class="card-body p-2 overflow-auto">
                <table class="table custom__table table-bordered table-sm">
                    <tr>
                        <th>Sr.</th>
                        <th>Id</th>
                        <th>Created at</th>
                        <th>RC</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Action</th>

                    </tr>

                    @php
                    $srno = 1
                    @endphp @if(!empty($Vehicles))

                    @foreach($Vehicles as $vehicle)
                    <tr>
                        <td>{{ $srno }}</td>
                        <td>{{ $vehicle->vehicle_id }}</td>
                        <td>{{ date("j F, Y h:i A", strtotime($vehicle->created_at)) }}</td>
                        <td>{{$vehicle->vehicle_rc_number}}</td>
                        <td>{{$vehicle->ambulance_category_name}}</td>
                        <td>{{$vehiclestatusMapper[$vehicle->vehicle_status]}}</td>
                 
                        <td class="action__btn lbtn-group">
                            <!-- <button class="btn-primary"><i class="fa fa-edit"></i></button> -->
                            <button class="btn-success"><i class="fa fa-eye"></i></button>
                        </td>
                    </tr>
                    @php
                    $srno++
                    @endphp
                    @endforeach
                    @endif

                </table>
                <!-- <span wire:loadingf wire:target="filterCondition">Loading...</span> -->
                <div class="custom__pagination mt-2 pt-1 card-footer__ clearfix">
                {{ $Vehicles->links(data: ['scrollTo' => '#paginated-posts']) }}
                </div>
            </div>
            @elseif(!empty($transaction))
            <div wire:loading.remove wire:target="filterCondition" class="card-body p-2 overflow-auto">
                <table class="table custom__table table-bordered table-sm">
                    <tr>
                        <th>Sr.</th>
                        <th>Id</th>
                        <th>Created at</th>
                        <th>Pay Id</th>
                        <th>Previous</th>
                        <th>New</th>
                        <th>Total</th>
                        <th>Transaction</th>
                        <th>Note</th>
                        <th>Action</th>

                    </tr>

                    @php
                    $srno = 1
                    @endphp @if(!empty($transaction))

                    @foreach($transaction as $list)
                    <tr>
                        @if(!empty($list->partner_transection_id))
                        <td>{{ $srno }}</td>
                        <td>{{ $list->partner_transection_id }}</td>
                        <td>{{ date("j F, Y h:i A", ($list->partner_transection_time_unix)) }}</td>
                        <td>{{$list->partner_transection_pay_id}}</td>
                        <td>{{$list->partner_transection_wallet_previous_amount	}} &#8377;</td>
                        <td>{{$list->partner_transection_wallet_new_amount}} &#8377;</td>
                        <td>{{$list->partner_transection_amount}} &#8377;</td>
                        <td>{{$transactionTypeMapper[$list->partner_transection_type]}}</td>
                        <td>{{$list->partner_transection_note}}</td>
                 
                        <td class="action__btn lbtn-group">
                            <!-- <button class="btn-primary"><i class="fa fa-edit"></i></button> -->
                            <button class="btn-success"><i class="fa fa-eye"></i></button>
                        </td>
                        @endif
                    </tr>
                    @php
                    $srno++
                    @endphp
                    @endforeach
                    @endif

                </table>
                <!-- <span wire:loadingf wire:target="filterCondition">Loading...</span> -->
                <div class="custom__pagination mt-2 pt-1 card-footer__ clearfix">
                {{ $transaction->links(data: ['scrollTo' => '#paginated-posts']) }}
                </div>
            </div>
            @elseif(!empty($assigndrivers))
            <div class="card-header custom__filter__select">
                <form wire:submit.prevent="AssignDriver">
                <div class="row align-items-end">
                    <div class="col-5">
                        <div class="form-group">
                            <label class="custom__label" for="vehicleId">Select Vehicle</label>
                            <select wire:model="vehicleId" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="vehicleId">
                                <option value="">Choose Your Vehicle</option>
                                @foreach ($assignvehicles as $list)
                                    <option value="{{ $list->vehicle_id }}">{{ $list->vehicle_rc_number . ' (' . $list->ambulance_category_name . ')' }}</option>
                                @endforeach
                            </select>
                            @error('vehicleId') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="form-group">
                            <label class="custom__label" for="driverId">Select Driver</label>
                            <select wire:model="driverId" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="driverId">
                                <option value="">Choose Your Driver</option>
                                @foreach ($assigndrivers as $list)
                                    <option value="{{ $list->driver_id }}">{{ $list->driver_name . ' ' . $list->driver_last_name . ' (' . $list->driver_mobile . ')' }}</option>
                                @endforeach
                            </select>
                            @error('driverId') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <button wire:loading.attr="disabled" class="rounded h-100 custom__label text-white form-control form-control-sm btn-primary">Save</button>
                        </div>
                    </div>
                </div>
                        </form>
            </div>
        <div wire:loading.remove wire:target="filterCondition" class="card-body p-2 overflow-auto">
                <table class="table custom__table table-bordered table-sm">
                    <tr>
                        <th>Sr.</th>
                        <th>Assigned at</th>
                        <th>RC</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Category</th>

                    </tr>

                    @php
                    $srno = 1
                    @endphp @if(!empty($assignhistoryData))

                    @foreach($assignhistoryData as $list)
                    <tr>
                        @if(!empty($list->vash_vehicle_id && $list->vash_driver_id))
                        <td>{{ $srno }}</td>
                        <td>{{ date("j F, Y h:i A", strtotime($list->created_at)) }}</td>
                        <td>{{$list->vehicle_rc_number}} ({{$list->vehicle_id}})</td>
                        <td>{{$list->driver_name.' '.$list->driver_last_name}} ({{$list->vash_driver_id}})</td>
                        <td>{{$list->driver_mobile}}</td>
                        <td>{{$list->ambulance_category_name}}</td>
              
                        @endif
                    </tr>
                    @php
                    $srno++
                    @endphp
                    @endforeach
                    @endif

                </table>
                <!-- <span wire:loadingf wire:target="filterCondition">Loading...</span> -->
                <div class="custom__pagination mt-2 pt-1 card-footer__ clearfix">@if(!empty($assignhistoryData))
                {{ $assignhistoryData->links(data: ['scrollTo' => '#paginated-posts']) }}
                @else @endif
                </div>
            </div>
                @elseif(!empty($refferalList))
                <div wire:loading.remove wire:target="filterCondition" class="card-body p-2 overflow-auto">
                <table class="table custom__table table-bordered table-sm">
                    <tr>
                        <th>Sr.</th>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>DOB</th>
                        <th>Refferal</th>

                    </tr>

                    @php
                    $srno = 1
                    @endphp @if(!empty($refferalList))

                    @foreach($refferalList as $list)
                    <tr>
                        @if(!empty($list['partner_id']))

                        <td>{{ $srno }}</td>
                        <td>{{ $list['partner_id'] }}</td>
                        <td>{{ $list['partner_f_name'].' '.$list['partner_l_name'] }}</td>
                        <td>{{$list['partner_mobile']}}</td>
                        <td>{{$list['partner_dob']}}</td>
                        <td>{{$list['partner_referral']}}</td>

                        @endif
                    </tr>
                    @php
                    $srno++
                    @endphp
                    @endforeach
                    @endif

                </table>
                <!-- <span wire:loadingf wire:target="filterCondition">Loading...</span> -->
                <div class="custom__pagination mt-2 pt-1 card-footer__ clearfix">
                {{ $refferal_data->links(data: ['scrollTo' => '#paginated-posts']) }}
                </div>
            </div>

                @else

            @endif
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
</div>
</div>