
<?php
    $createdMapper['0'] = "Self";
    $createdMapper['1'] = "Partner";

    $statusMapper['0'] = "Enquiry";
    $statusMapper['1'] = "New";
    $statusMapper['2'] = "Ongoing";
    $statusMapper['3'] = "Invoice";
    $statusMapper['4'] = "Complete";
    $statusMapper['5'] = "Cancel";

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
    
        @if (session()->has('message') && session()->has('type') == 'delete')

        <div class="alert alert-danger alert-dismissible" role="alert">
            <span type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></span>
            <strong>{{ session('message') }}!</strong>
        </div>

        @elseif (session()->has('message') && session()->has('type') == 'store')

        <div class="alert alert-success alert-dismissible" role="alert">
            <span type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></span>
            <strong>{{ session('message') }}!</strong>
        </div>
        @endif    

   <!--=========================== Consumer Details Nav Bar Starts =================================================================--->
   @include('livewire.admin.consumer.consumer_details_nav_bar')
    <!--=========================== Consumer Details Nav Bar Ends =================================================================--->
    @if(!empty($transactionDetails))
        <div class="card mt-2 custom__filter__responsive">
            <div class="card-header custom__filter__select">

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

            <!-- <table class="table table-bordered table-sm table-responsive-sm mt-2"> -->
            <div wire:loading.remove wire:target="filterCondition" class="card-body p-2 overflow-auto">
                <table class="table custom__table table-bordered table-sm">
                    <tr>
                        <th>Sr.No.</th>
                        <th>Transaction ID</th>
                        <th>BOOKING ID</th>
						<th>Transaction Amount</th>
						<th>Transaction Currency</th>
						<th>Transaction Time</th>
                        <th>Action</th>
                    </tr>

                    @php
                    $srno = 1;
                    @endphp @if(!empty($transactionDetails))

                    @foreach($transactionDetails as $list)
                    @if(!empty($list->transaction_id))
                    <tr>
                         <td>{{ $srno }}</td>
                         <td>{{$list->transaction_id}}</td>
                         <td>{{$list->booking_id}}</td>
                          <td>&#8377;{{$list->amount}}</td>
                          <td>{{$list->currency}}</td>    
                         <td>{{date('d-F-Y h:i A',$list->booking_transaction_time)}}</td>  

                        <td class="action__btn lbtn-group">
                            <button class="btn-success"><i class="fa fa-eye"></i></button>
                           
                        </td>
                    </tr>
                    @endif
                    @php
                    $srno++
                    @endphp
                    @endforeach
                    @endif

                </table>
                <!-- <span wire:loadingf wire:target="filterCondition">Loading...</span> -->
                <div class="custom__pagination mt-2 pt-1 card-footer__ clearfix">
                {!! $transactionDetails->links() !!}
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
   @elseif((!empty($consumerTransaction)))
   <div class="card mt-2 custom__filter__responsive">
            <div class="card-header custom__filter__select">

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

            <!-- <table class="table table-bordered table-sm table-responsive-sm mt-2"> -->
            <div wire:loading.remove wire:target="filterCondition" class="card-body p-2 overflow-auto">
                <table class="table custom__table table-bordered table-sm">
                <tr>
                    <th>Sr.No.</th>
                    <th>Transaction ID</th>
					<th>Transaction Amount</th>
					<th>Transaction PaymentId</th>
					<th>Transaction Note</th>
					<th>Transaction Time</th>
					<th>Action</th>
				</tr>

                    @php
                    $srno = 1;
                    @endphp @if(!empty($consumerTransaction))

                    @foreach($consumerTransaction as $list)
                    @if(!empty($list->consumer_transection_id))
                    <tr>
                        <td>{{$srno}}</td>
                        <td>{{$list->consumer_transection_id}}</td>
                        <td>&#8377;{{$list->consumer_transection_amount}}</td>
                        <td>{{$list->consumer_transection_payment_id}}</td>    
                         <td>{{$list->consumer_transection_note}}</td> 
                        <td>{{date('j F, Y h:m A', $list->consumer_transection_time)}}</td>   

                        <td class="action__btn lbtn-group">
                            <button class="btn-success"><i class="fa fa-eye"></i></button>
                           
                        </td>
                    </tr>
                    @endif
                    @php
                    $srno++
                    @endphp
                    @endforeach
                    @endif

                </table>
                <!-- <span wire:loadingf wire:target="filterCondition">Loading...</span> -->
                <div class="custom__pagination mt-2 pt-1 card-footer__ clearfix">
                {!! $consumerTransaction->links() !!}
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
   @elseif((!empty($bookingDetails)))
        <div class="card mt-2 custom__filter__responsive">
            <div class="card-header custom__filter__select">

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
                    <div class="col -col-3">
                        <div class="form-group">
                            <label class="custom__label">Select Booking</label>
                            <select wire:model.live.debounce.150ms="selectBookingStatus" wire:model="check_for" wire:mode.live="selectBookingStatus" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="selectBookingStatus">

                                <option selected value="New">New</option>
                                <option value="Enquiry">Enquiry</option>
                                <option value="Ongoing">Ongoing</option>
                                <option value="Invoice">Invoice</option>
                                <option value="Complete">Complete</option>
                                <option value="Cancel">Cancel</option>
                                <option value="All">All</option>
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
                <table class="table custom__table table-bordered table-sm">
                    <tr>
                        <th>Sr.</th>
                        <th>Id</th>
                        <th>Created at</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Pickup</th>
                        <th>Drop</th>
                        <th>Category</th>
                        <th>Amounts</th>
                        <th>Status</th>
                        <th>Action</th>

                    </tr>

                    @php
                    $srno = 1
                    @endphp @if(!empty($bookingDetails))

                    @foreach($bookingDetails as $list)
                    <tr>
                        <td>{{ $srno }}</td>
                        <td>{{ $list->booking_id }}</td>
                        <td>{{ date("j F, Y h:i A", strtotime($list->booking_created_at)) }}</td>
                        <td>{{$list->booking_con_name}}</td>
                        <td>{{$list->booking_con_mobile}}</td>
                        <td>{!!wordwrap($list->booking_pickup,40,"<br>\n")!!}</td>
                        <td>{!!wordwrap($list->booking_drop,40,"<br>\n")!!}</td>
                        <td>{{$list->booking_view_category_name}}</td>
                        <td> &#8377;{{$list->booking_view_total_fare}}</td> 
                        <td>{{$statusMapper[$list->booking_status]}}</td>

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
                {!! $bookingDetails->links() !!}
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row" wire:loading wire:target="selectedDate,selectBookingStatus,filterCondition" wire:key="selectedDate,selectBookingStatus,filterCondition">
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
        <!-- <div style="text-align:center !important; display:block !important" wire:loading wire:target="selectedDate,driverVerificationStatus,filterCondition" wire:key="selectedDate,Onduty,Offduty"><i class="fa fa-spinner fa-spin mt-2 ml-2"></i>Processing..</div> -->
   @elseif((!empty($pathologybookingDetails)))
        <div class="card mt-2 custom__filter__responsive">
            <div class="card-header custom__filter__select">

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
                    <div class="col -col-3">
                        <div class="form-group">
                            <label class="custom__label">Select Booking</label>
                            <select wire:model.live.debounce.150ms="selectPathologyBookingStatus" wire:model.live="selectPathologyBookingStatus" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="selectBookingStatus">

                                <option selected value="New">New</option>
                                <option value="Ongoing">Ongoing</option>
                                <option value="Complete">Complete</option>
                                <option value="Cancel">Cancel</option>
                                <option value="All">All</option>
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
                <table class="table custom__table table-bordered table-sm">
                    <tr>
                       <th>Sr.</th>
                        <th>Id</th>
                        <th>Created</th>
                        <th>Consumer</th>
                        <th>Lab Address</th>
                        <th>Lab Test City</th>
                        <th>Tests</th>
                        <th>Patient</th>
                        <th>Lab Status</th>
                        <th>Payment type</th>
                        <th>Final Price</th>
                        <th>Payment</th>
                        <th>Action</th>

                    </tr>
                    @php
                    $srno = 1
                    @endphp
                    @if (!empty($pathologybookingDetails))

                    @foreach ($pathologybookingDetails as $key)
                    <tr>
                        <td>{{ $srno }}</td>
                        <td>{{ $key->customer_lab_order_id }}</td>
                        <td>
                            {{ date("j F, Y h:i A",($key->clo_order_time)) }}
                         </td>
                         <td>{{ $key->clo_customer_name }} <br/> {{ $key->clo_contact_no }} </td>
                        <td>{!! wordwrap($key->clo_address, 25, "<br>\n") !!} , {{$key->clo_address_pincode}}</td>
                        <td>{{ $key->city_name }}<br/> {{ $key->state_name }}</td>

							<td>{{ $key->clo_no_of_test }}</td>
							<td>{{ $key->clo_no_of_patient }}</td>
							<td>
									@if ($key->clo_status == '1')
										New 
									@elseif ($key->clo_status == '2')
											Ongoing 
									@elseif ($key->clo_status == '3')
											Cancel 
									@elseif ($key->clo_status == '4')
											Complete 
									@elseif ($key->clo_status == '0')
											Enquiry 
									@else
												<!-- Handle the "else" case here -->
									@endif 
									</p>
								</td>
                                <td>{{$key->clo_payment_type}}</td>
                                <td> &#8377;{{ $key->clo_final_price }}</td>
                                <td>@if ($key->clo_payment_status == '0')
								      Pending
									@elseif ($key->clo_payment_status == '1')
								    Done
									@else
										<!-- Handle the "else" case here -->
									@endif</td>
                     
                        <td class="action__btn lbtn-group">
                        <button wire:navigate href="{{route('labOrderDetails',['orderId' => Crypt::encrypt($key->customer_lab_order_id),'filterData'=> 'Details'])}}" class="btn-success"><i class="fa fa-eye fa-sm"></i></button>
                            <button wire:confirm="Are you sure you want to delete this Consumer Enquiry ?" class="btn-danger"><i class="fa fa-trash fa-sm"></i></button>
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
                {!! $pathologybookingDetails->links() !!}
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row" wire:loading wire:target="selectedDate,selectPathologyBookingStatus,filterCondition" wire:key="selectedDate,selectPathologyBookingStatus,filterCondition">
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
        <!-- <div style="text-align:center !important; display:block !important" wire:loading wire:target="selectedDate,driverVerificationStatus,filterCondition" wire:key="selectedDate,Onduty,Offduty"><i class="fa fa-spinner fa-spin mt-2 ml-2"></i>Processing..</div> -->

   @elseif((!empty($healthcardData)))
        <div class="card mt-2 custom__filter__responsive">
            <div class="card-header custom__filter__select">

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
                            <label class="custom__label">HealthCard By Status</label>

                            <select wire:model.live.debounce.150ms="healthCardVerificationStatus" wire:mode.live="healthCardVerificationStatus" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="SelectUnderVerification">
                                <option selected value="AllVerification">All HealthCard</option>
                                <option value="NewVerification">New HealthCard</option>
                                <option value="ActiveVerification">Active HealthCard</option>
                                <option value="AppliedVerification">Applied HealthCard</option>
                                <option value="InactiveVerification">Block HealthCard</option>

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
                <table class="table custom__table table-bordered table-sm">
                     <tr>
						<th>Sr. No.</th>
						<th>Id</th>
				        <th>Create At</th>
					    <th>Consumer</th>
					    <th>Mobile</th>
						<th>Subscription</th>
                        <th>Number</th>
						<th>Gender</th>
						<th>Address</th>
						<th>Card No</th>
						<th>Duration</th>
						<th>Remark Details</th>
						<th>Subscription Status</th>
						<th>Action</th>
				</tr>
                @if(!empty($healthcardData))
						<?php $sr=1;?>
                           @foreach($healthcardData as $key)
                                 <tr>
                                     <td class="table-plus"><?php echo $sr++; ?></td>
                                     <td>{{$key->health_card_subscription_id}}</td>
									 <td>{{date('j F Y,h:i A',$key->health_card_subscription_added_time_unx)}} </td>
                                     <td>{{$key->consumer_name}}</td>
                                     <td>{{$key->consumer_mobile_no}}</td>
                                      <td>{{$key->health_card_subscription_name,' '.$key->health_card_subscription_last_name}}</td>
                                      <td>{{$key->health_card_subscription_mobile_no}}</td>
                                     <td>{{$key->health_card_subscription_gender}}</td>
                                     <td>{{$key->ua_address}}</td>
                                     <td>{{$key->health_card_subscription_card_no}}</td>
                                     <td>{{$key->health_card_plan_duration}}</td>
									<td>
                                    @if(($key->remark_id))
                                    <input type="text" value="{{$key->remark_text}}" class="text-center">
                                    @else
                                    <input type="text" placeholder="Enter The Remark" class="text-center">
                                    @endif
                                    <br />
                                   
									</td>
                                     <td>
                                       @if($key->health_card_subscription_status == '1')
										Applied Verification
                                         @elseif($key->health_card_subscription_status == '2')
                                          Active
                                         @elseif($key->health_card_subscription_status == '0')
                                          New
                                         @elseif($key->health_card_subscription_status == '#')
                                          Inactive
                                          @else
                                           
                                      @endif
                                      </td>
                                      <td class="action__btn lbtn-group">
                                            <button class="btn-primary"><i class="fa fa-edit fa-sm"></i></button>
                                            <button class="btn-success"><i class="fa fa-eye fa-sm"></i></button>
                                            <!-- <button wire:confirm="Are you sure you want to delete this Consumer?"  class="btn-danger"><i class="fa fa-trash fa-sm"></i></button> -->
                                        </td>
									        </tr>
                                  @endforeach
                      @endif

                </table>
                <!-- <span wire:loadingf wire:target="filterCondition">Loading...</span> -->
                <div class="custom__pagination mt-2 pt-1 card-footer__ clearfix">
                {!! $healthcardData->links() !!}
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row" wire:loading wire:target="selectedDate,healthCardVerificationStatus,filterCondition" wire:key="selectedDate,healthCardVerificationStatus,filterCondition">
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
        <!-- <div style="text-align:center !important; display:block !important" wire:loading wire:target="selectedDate,driverVerificationStatus,filterCondition" wire:key="selectedDate,Onduty,Offduty"><i class="fa fa-spinner fa-spin mt-2 ml-2"></i>Processing..</div> -->
@endif
    </div>
</div>
</div>