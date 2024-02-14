<div class="content">
    <div class="container-fluid">
        @if (session()->has('message') && session()->has('type') == 'delete')
        <div class="alert alert-danger">{{ session('message') }}</div>
        @elseif (session()->has('message') && session()->has('type') == 'store')
        <div class="alert alert-success">{{ session('message') }}</div>
        @endif
        @include('livewire.admin.vehicle.vehicle_nav_component')

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
                            <label class="custom__label">Vehicle By Status</label>
                            <select wire:model.live.debounce.150ms="vehicleStatusFilter" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="SelectUnderVerification">
                                <option value="All">All</option>
                                <option value="Active">Active</option>
                                <option value="New">New</option>
                                <option value="Partner">By Partner</option>
                                <option value="Driver"> By Driver</option>
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
                        <th>Sr.</th>
                        <th>Id</th>
                        <th>Created</th>
                        <th>Created By</th>
                        <th>Vehicle RC</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Remark Details</th>
                        <th>Action</th>
                    </tr>
                    @php
                    $srno = 1
                    @endphp
                    @if(!empty($data))
                    @foreach ($data as $key)     
                    <tr>
                        <td>{{ $srno }}</td>
                        <td>{{ $key['vehicle']->vehicle_id }}</td>
                        <td>
                        @if ($key['vehicle']->created_at)
                            {{ date("j F, Y h:i A", strtotime($key['vehicle']->created_at)) }}
                        @else
                            N/A
                        @endif
                    </td>
                        <td>
                            @if(!empty($key['vehicle']) && $key['vehicle']->vehicle_added_type == 1)
                                Partner
                            @elseif (!empty($key['vehicle']) && $key['vehicle']->vehicle_added_type == 0)
                                Driver
                            @endif
                        </td>
                        <td>{{ $key['vehicle']->vehicle_rc_number }}</td>
                        <td>{{ $key['vehicle']->ambulance_category_name }} ({{ $key['vehicle']->vehicle_category_type }})</td>
                        <td> @if(!empty($key['vehicle']->vehicle_status==1))Active @elseif($key['vehicle']->vehicle_status==0) New @elseif($key['vehicle']->vehicle_status=='4') Applied @else @endif</td>
                        <td>@if (!empty($key['active_drivers'][0]))
						{{ $key['active_drivers'][0]->driver_name }} {{ $key['active_drivers'][0]->driver_last_name }} ({{ $key['active_drivers'][0]->driver_id }}) @else Not Assigned @endif</td>
                         <td> @if (!empty($key['active_drivers'][0])) {{ $key['active_drivers'][0]->driver_mobile }} @else @endif</td>
                        <td>
                        @if($key['vehicle']->remark_id) {{$key['vehicle']->remark_text}} @else N/A @endif
                        </td>
                      
                        <td class="action__btn lbtn-group">
                            <button wire:click="#" class="btn-primary"><i class="fa fa-edit fa-sm"></i></button>
                            <button wire:confirm="Are you sure you want to delete this post?" wire:click="#" class="btn-danger"><i class="fa fa-trash fa-sm"></i></button>
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
                {{$vehicleDetails->links()}}
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
</div>
</div>
