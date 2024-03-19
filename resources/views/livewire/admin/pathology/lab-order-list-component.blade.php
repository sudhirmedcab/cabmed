<div class="content">
    <div class="container-fluid">
        @if (session()->has('message') && session()->has('type') == 'delete')
        <div class="alert alert-danger">{{ session('message') }}</div>
        @elseif (session()->has('message') && session()->has('type') == 'store')
        <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        <div class="card mt-2 custom__filter__responsive">
            <div class="card-header custom__filter__select ">

                <div class="row">
                    
                <div class="col __col-2">
                        <div class="form-group">
                            <label class="custom__label" for="fromDate">From </label>
                            <input wire:model.live="selectedFromDate"  {{ !$isCustom ? 'disabled' : '' }} type="date" class="custom__input__field rounded-0 form-control form-control-sm" id="fromDate" placeholder="Enter from date">
                        </div>
                    </div>
                    <div class="col __col-2">
                        <div class="form-group">
                            <label class="custom__label" for="toDate">To</label>
                            <input wire:model.live="selectedToDate"  {{ !$isCustom ? 'disabled' : '' }} max="<?= date('Y-m-d') ?>" type="date"  class="custom__input__field rounded-0 form-control form-control-sm" id="toDate" placeholder="Enter to date">
                        </div>
                    </div>
                    <div class="col __col-2">
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
                        <div class="form-group">
                            <label class="custom__label">Booking By Status</label>
                            <select wire:model.live.debounce.150ms="orderStatusFilter" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="orderStatusFilter">
                               <option  selected value="New">New</option>
                                <option value="Ongoing">Ongoing</option>
                                <option value="Completed">Completed</option>
                                <option value="Cancelled">Cancelled</option>
                                <option value="All">All</option>

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
                        <th>Sr.</th>
                        <th>Id</th>
                        <th>Created</th>
                        <th>Consumer</th>
                        <th>Lab Address</th>
                        <th>Lab Test City</th>
                        <th>Test Name</th>
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
                    @if (!empty($lab_order))

                    @foreach ($lab_order as $key)
                    <tr>
                        <td>{{ $srno }}</td>
                        <td>{{ $key->customer_lab_order_id }}</td>
                        <td>
                            {{ date("j F, Y h:i A",($key->clo_order_time)) }}
                         </td>
                         <td>{{ $key->clo_customer_name }} <br/> {{ $key->clo_contact_no }} </td>
                        <td>{!! wordwrap($key->clo_address, 25, "<br>\n") !!} , {{$key->clo_address_pincode}}</td>
                        <td>{{ $key->city_name }}<br/> {{ $key->state_name }}</td>

                        <td>
							@isset($lab_test_data[$key->customer_lab_order_id])
							@foreach ($lab_test_data[$key->customer_lab_order_id] as $index => $test)
							<p>{{ $index + 1 }}. {{ $test->lt_test_name }}</p>
							@endforeach

							@endisset
							</td>
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
                <div class="custom__pagination mt-2 text-right pt-1 card-footer__ clearfix">

                {!! $lab_order->links() !!}

                </div>
            </div>
        </div>

        <div class="container h-100 w-100">
            <div class="row w-100 h-100 align-items-center justify-content-center" wire:loading wire:target="selectedDate,vehicleStatusFilter,filterCondition" wire:key="selectedDate,vehicleStatusFilter,filterCondition">
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


