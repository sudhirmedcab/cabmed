<div class="content">
    <div class="container-fluid">
        @if ($isOpen)
        @include('livewire.employee-form')
        @endif
        @if (session()->has('message') && session()->has('type') == 'delete')
        <div class="alert alert-danger">{{ session('message') }}</div>
        @elseif (session()->has('message') && session()->has('type') == 'store')
        <div class="alert alert-success">{{ session('message') }}</div>
        @endif
        @include('livewire.admin.driver-nav-component')

        <div class="card custom__filter__responsive">
            <div class="card-header custom__filter__select ">

                <div class="row">
                    
                    <div class="col __col-{{$this->activeTab == 'UnderVerificationBySelf' || $this->activeTab == 'walletBalance' ? 2:3}}">
                        <div class="form-group">
                            <label class="custom__label" for="fromDate">From </label>
                            <input wire:model.live="selectedFromDate" type="date" class="custom__input__field rounded-0 form-control form-control-sm" id="fromDate" placeholder="Enter from date">
                        </div>
                    </div>
                    <div class="col __col-{{$this->activeTab == 'UnderVerificationBySelf' || $this->activeTab == 'walletBalance' ? 2:3}}">
                        <div class="form-group">
                            <label class="custom__label" for="toDate">To</label>
                            <input wire:model.live="selectedToDate" type="date" class="custom__input__field rounded-0 form-control form-control-sm" id="toDate" placeholder="Enter to date">
                        </div>
                    </div>
                    @if($this->activeTab !== 'documentExpiry')

                    <div class="col -{{$this->activeTab == 'UnderVerificationBySelf' || $this->activeTab == 'walletBalance' ? 2:3}}">
                        <div class="form-group">
                            <label class="custom__label">Select</label>
                            <select wire:model.live.debounce.150ms="selectedDate" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="exampleSelectRounded0">
                                <option selected value="all">All</option>
                                <option value="today">Today</option>
                                <option value="yesterday">Yesterday</option>
                                <option value="thisWeek">This Week</option>
                                <option value="thisMonth">This Month</option>
                            </select>
                        </div>
                    </div>
                    @endif
                    @if($this->activeTab == 'documentExpiry')
                    <div class="col">
                        <div class="form-group">
                          <label class="custom__label">Select</label>
                            <select wire:model.live.debounce.150ms="selectDocumentExpiry" wire:model.live="selectDocumentExpiry" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="selectDocumentExpiry">
                                <option selected value="dl">DL</option>
                                <option value="rcno">RC NO.</option>
                                <option value="vehicleInsuarance">Vehicle Insuarance</option>
                                <option value="vehiclePolution">Vehicle Polution</option>
                                <option value="vehicleFitness">Vehicle Fitness</option>
                            </select>
                        </div>
                    </div>
                    @endif
                    @if($this->activeTab == 'UnderVerificationBySelf')
                    <div class="col __col-3">
                        <div class="form-group">
                            <label class="custom__label">Driver By Status</label>
                            <select wire:model.live.debounce.150ms="driverVerificationStatus" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="SelectUnderVerification">
                                <option selected value="">Select Verification status</option>
                                <option value="UnderVerification">Under Verification(All)</option>
                                <option value="UnderVerificationBySelf">Under Verification(By Self)</option>
                                <option value="UnderVerificationByPartner">Under Verification(By Partner)</option>

                            </select>
                        </div>
                    </div>
                    @endif

                    @if($this->activeTab == 'walletBalance')
                    <div class="col __col-3">
                        <div class="form-group">
                            <label class="custom__label">Wallet Balance</label>
                            <select wire:model.live.debounce.150ms="walletBalanceFilter" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="SelectUnderVerification">
                                <option value="positiveBalance">Positive Balance</option>
                                <option value="zeroBalance">Zero Balance</option>
                                <option value="negativeBalance">Negative Balance</option>
                            </select>
                        </div>
                    </div>
                    @endif

                    <div class="col __col-3">
                        <div class="form-group">
                            <label class="custom__label" for="toDate">Search</label>
                            <input type="search" wire:model.live.debounce.150ms="search" class="custom__input__field form-control rounded-0 form-control-sm float-right" placeholder="Search">
                        </div>
                    </div>
                </div>

            </div>
            <div class="row d-none card-header">
                <div class="col-3">
                    <div class="form-group">
                        <label class="custom__label">Wallet Balance</label>
                        <select wire:model.live.debounce.150ms="walletBalanceFilter" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="SelectUnderVerification">
                            <option value="positiveBalance">Positive Balance</option>
                            <option value="zeroBalance">Zero Balance</option>
                            <option value="negativeBalance">Negative Balance</option>
                        </select>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label class="custom__label">Wallet Balance</label>
                        <select wire:model.live.debounce.150ms="walletBalanceFilter" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="SelectUnderVerification">
                            <option value="positiveBalance">Positive Balance</option>
                            <option value="zeroBalance">Zero Balance</option>
                            <option value="negativeBalance">Negative Balance</option>
                        </select>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label class="custom__label">Wallet Balance</label>
                        <select wire:model.live.debounce.150ms="walletBalanceFilter" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="SelectUnderVerification">
                            <option value="positiveBalance">Positive Balance</option>
                            <option value="zeroBalance">Zero Balance</option>
                            <option value="negativeBalance">Negative Balance</option>
                        </select>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label class="custom__label">Wallet Balance</label>
                        <select class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="SelectUnderVerification">
                            <option value="positiveBalance">Positive Balance</option>
                            <option value="zeroBalance">Zero Balance</option>
                            <option value="negativeBalance">Negative Balance</option>
                        </select>
                    </div>
                </div>
            </div>
            <!-- <table class="table table-bordered table-sm table-responsive-sm mt-2"> -->
            <div wire:loading.remove wire:target="filterCondition" class="card-body p-2 overflow-auto">
                <table class="table custom__table table-bordered table-sm ">
                    <tr>
                        <th>Sr.</th>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Wallet</th>
                        @if($this->activeTab !== 'documentExpiry')
                        <th>Created At</th>
                        @endif
                        @if($this->activeTab !== 'documentExpiry')
                        <th>Created By</th>
                        @endif
                        <th>Bonus</th>
                        <th>Duty</th>
                        <th>Booking</th>
                        <!-- <th>Remark Details</th> -->
                        <th>City</th>
                        <th> State</th>
                        <th>RC No.</th>
                        <!-- <th>DL No.</th> -->
                        <th>Action</th>
                    </tr>
                    @php
                    $srno = 1
                    @endphp
                    @foreach ($drivers as $driver)
                    <tr>
                        <td>{{ $srno }}</td>
                        <td>{{ $driver->driver_id }}</td>
                        <td>{{ $driver->driver_name.' '.$driver->driver_last_name }}</td>
                        <td>{{ $driver->driver_mobile }}</td>
                        <td>{{ $driver->driver_wallet_amount }}</td>
                        @if($this->activeTab !== 'documentExpiry')
                        <td>{{ $driver->created_at }}</td>
                        @endif
                        @if($this->activeTab !== 'documentExpiry')
                        <td>
                            @if($driver->driver_created_by=='0')
                            Self
                            @else
                            Partner
                            @endif
                        </td>
                        @endif
                        <td>
                            {{ $driver->join_bonus_status ==1 ? 'Yes' : 'No' }}

                        </td>
                        <td>
                            {{ $driver->driver_duty_status }}
                            <!-- Booking Status: {{ $driver->driver_on_booking_status == 0 ? 'Free' : 'In Booking' }} -->
                        </td>

                        <td>{{ $driver->driver_on_booking_status == 0 ? 'Free' : 'Ongoing' }}</td>
                        <td>{{ $driver->city_name }}</td>
                        <td>{{ $driver->state_name }}</td>
                        <td>{{ $driver->vehicle_rc_number }}</td>
                        <td class="action__btn lbtn-group">
                            <button wire:click="edit({{ $driver->driver_id }})" class="btn-primary"><i class="fa fa-edit fa-sm"></i></button>
                            <button  wire:navigate href="{{route('admin.driver-details-component',['driverId' => Crypt::encrypt($driver->driver_id)])}}" class="btn-success"><i class="fa fa-eye fa-sm"></i></button>
                            <button wire:confirm="Are you sure you want to delete this post?" wire:click="delete({{ $driver->driver_id }})" class="btn-danger"><i class="fa fa-trash fa-sm"></i></button>
                        </td>
                    </tr>
                    @php
                    $srno++
                    @endphp
                    @endforeach

                </table>
                <!-- <span wire:loadingf wire:target="filterCondition">Loading...</span> -->
                <div class="custom__pagination mt-2 text-right pt-1 card-footer__ clearfix">
                    {!! $drivers->links() !!}
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
