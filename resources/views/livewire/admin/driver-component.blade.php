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
         <div class="card text-center">
          <div class="card-header pt-1 pb-3">
            <ul class="nav nav-tabs custom__nav__tab  card-header-tabs">
              <li class="nav-item">
                <a class="nav-link fs-1 active" href="/driver" wire:navigate >All </a>
              </li>
              <li class="nav-item">
                <a class="nav-link fs-1" href="/manage-driver" wire:navigate class="nav-link" >Add</a>
              </li>
              <li class="nav-item">
                <a class="custom__nav__btn nav-link fs-1 {{$this->activeTab == 'division' ? 'btn-primary':''}}" wire:click="filterCondition('division')">
                Division
              </a>
              </li>
              <li class="nav-item">
                <a class="nav-link fs-1" href="#">District</a>
              </li>
              <li class="nav-item">
                <a class="nav-link fs-1" href="#">Under Reg.</a>
              </li>
              <li class="nav-item">
              <a class="custom__nav__btn nav-link fs-1 {{$this->activeTab == 'walletBalance' ? 'btn-primary':''}}" wire:click="filterCondition('walletBalance')">
               Wallet
              </a>
              </li>
              <li class="nav-item">
                <a class="custom__nav__btn nav-link fs-1 {{$this->activeTab == 'Active' ? 'btn-primary':''}}" wire:click="filterCondition('Active')">
                  Active
                </a>
              </li>
              <li class="nav-item">
              <a class="custom__nav__btn nav-link fs-1 {{$this->activeTab == 'Onduty' ? 'btn-primary':''}}" wire:click="filterCondition('Onduty')">
                  On Duty
              </a>
              </li>
              <li class="nav-item">
                <a class="custom__nav__btn nav-link fs-1 {{$this->activeTab == 'Offduty' ? 'btn-primary':''}}" wire:click="filterCondition('Offduty')">
                Off Duty
                </a>
              </li>
              <li class="nav-item">
              <a class="custom__nav__btn nav-link fs-1 {{$this->activeTab == 'UnderVerificationBySelf' ? 'btn-primary':''}}" wire:click="filterCondition('UnderVerificationBySelf')">
              Under Verification
              </a>
              </li>
<!-- 
              <li class="nav-item">
              <a class="custom__nav__btn nav-link fs-1 {{$this->activeTab == 'UnderVerificationByPartner' ? 'btn-primary':''}}" wire:click="filterCondition('UnderVerificationByPartner')">
              Under Verification (ByPartner)
              </a>              </li> -->
            </ul>
          </div>
        
        </div>
            
            <div class="card">
              <div class="card-header">
               
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
                    <div class="col -{{$this->activeTab == 'UnderVerificationBySelf' || $this->activeTab == 'walletBalance' ? 2:3}}">
                        <div class="form-group">
                          <label class="custom__label">Select</label>
                          <select wire:model.live.debounce.150ms="selectedDate" wire:mode.live="selectedDate" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="exampleSelectRounded0">
                          <option selected value="all">All</option>
                          <option value="today">Today</option>
                          <option value="yesterday">Yesterday</option>
                          <option value="thisWeek">This Week</option>
                          <option value="thisMonth">This Month</option>
                        </select>
                        </div>
                    </div>
                    @if($this->activeTab == 'UnderVerificationBySelf')
                    <div class="col __col-3">
                        <div class="form-group">
                          <label class="custom__label">Driver By Status</label>
                          <select wire:model.live.debounce.150ms="driverVerificationStatus" wire:mode.live="driverVerificationStatus" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="SelectUnderVerification">
                          <option selected value="UnderVerification">Under Verification(All)</option>
                          <option  value="UnderVerificationBySelf">Under Verification(By Self)</option>
                          <option  value="UnderVerificationByPartner">Under Verification(By Partner)</option>
                         
                        </select>
                        </div>
                    </div>
                    @endif

                    @if($this->activeTab == 'walletBalance')
                    <div class="col __col-3">
                        <div class="form-group">
                          <label class="custom__label">Wallet Balance</label>
                          <select wire:model.live.debounce.150ms="walletBalanceFilter" wire:mode.live="walletBalanceFilter" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="SelectUnderVerification">
                          <option  value="positiveBalance">Positive Balance</option>
                          <option  value="zeroBalance">Zero Balance</option>
                          <option  value="negativeBalance">Negative Balance</option>
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
                            <select wire:model.live.debounce.150ms="walletBalanceFilter" wire:mode.live="walletBalanceFilter" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="SelectUnderVerification">
                            <option  value="positiveBalance">Positive Balance</option>
                            <option  value="zeroBalance">Zero Balance</option>
                            <option  value="negativeBalance">Negative Balance</option>
                          </select>
                          </div>
                      </div>
                      <div class="col-3">
                          <div class="form-group">
                            <label class="custom__label">Wallet Balance</label>
                            <select wire:model.live.debounce.150ms="walletBalanceFilter" wire:mode.live="walletBalanceFilter" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="SelectUnderVerification">
                            <option  value="positiveBalance">Positive Balance</option>
                            <option  value="zeroBalance">Zero Balance</option>
                            <option  value="negativeBalance">Negative Balance</option>
                          </select>
                          </div>
                      </div>
                      <div class="col-3">
                          <div class="form-group">
                            <label class="custom__label">Wallet Balance</label>
                            <select wire:model.live.debounce.150ms="walletBalanceFilter" wire:mode.live="walletBalanceFilter" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="SelectUnderVerification">
                            <option  value="positiveBalance">Positive Balance</option>
                            <option  value="zeroBalance">Zero Balance</option>
                            <option  value="negativeBalance">Negative Balance</option>
                          </select>
                          </div>
                      </div>
                      <div class="col-3">
                          <div class="form-group">
                            <label class="custom__label">Wallet Balance</label>
                            <select  class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="SelectUnderVerification">
                            <option  value="positiveBalance">Positive Balance</option>
                            <option  value="zeroBalance">Zero Balance</option>
                            <option  value="negativeBalance">Negative Balance</option>
                          </select>
                          </div>
                      </div>
              </div>
            <!-- <table class="table table-bordered table-sm table-responsive-sm mt-2"> -->
                <div class="card-body p-0">
                <table class="table custom__table table-bordered table-sm">
                <tr>
                    <th>Sr.</th>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Wallet</th>
                    <th>Created At</th>
                    <th>Created By</th>
                    <th>Bonus</th>
                    <th>Duty</th>
                    <th>Booking</th>
                    <!-- <th>Remark Details</th> -->
                    <th>City</th>
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

                        <td>{{ $driver->created_at }}</td>
                        <td>
                        @if($driver->driver_created_by=='0')
												 Self
												 @else
												 Partner
                        @endif
                        </td>
                        <td>
                        {{ $driver->join_bonus_status ==1 ? 'Yes' : 'No' }}

                        </td>
                        <td>
                          {{ $driver->driver_duty_status }}
                          <!-- Booking Status: {{ $driver->driver_on_booking_status == 0 ? 'Free' : 'In Booking' }} -->
                        </td>
                        
                        <td>{{ $driver->driver_on_booking_status == 0 ? 'Free' : 'Ongoing' }}</td>
                        <td>{{ $driver->city_name }}</td>
                        <td>{{ $driver->vehicle_rc_number }}</td>
                        <!-- <td>{{ $driver->driver_mobile }}</td>
                        <td>{{ $driver->driver_mobile }}</td>
                        <td>{{ $driver->driver_mobile }}</td>
                        <td>{{ $driver->driver_mobile }}</td> -->
                        <td class="action__btn lbtn-group">
                            <button wire:click="edit({{ $driver->driver_id }})" class="pt-0 pl-2 pr-2 pb-1 btn btn-sm btn-primary"><i class="fa fa-edit"></i></button>
                            <button wire:confirm="Are you sure you want to delete this post?"
                                wire:click="delete({{ $driver->driver_id }})" class="pt-0 pl-2 pr-2 pb-1 btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                    @php
                    $srno++
                    @endphp
                @endforeach

            </table>
            <div style="text-align:center;" wire:loading wire:target="selectedDate" wire:key="selectedDate"><i class="fa fa-spinner fa-spin mt-2 ml-2"></i>loading</div>

            </div>
            </div>
          
          <div class="custom__pagination card-footer__ clearfix">
                        {!! $drivers->links() !!}
            </div>
            
    </div>
    </div>
</div>



