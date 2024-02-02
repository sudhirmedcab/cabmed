<div class="content">
    <div class="container-fluid">
         @include('livewire.admin.driver-nav-component')
            
            <div class="card">
              <div class="card-header">
                <div class="row">
                @if($this->activeTab != 'division')
                    
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
                @endif
                @if($this->activeTab == 'division')
                <div class="col">
                  <div class="form-group">

                        <label class="custom__label" for="vehicle_rc_no">Export Datatest</label>
                      <button style="line-height:0" class="custom__input__field form-control btn btn-primary rounded-0 form-control-sm"> Export </button>
                    </div>
                  </div>
                <div class="col">
                  <div class="form-group">
                        <label class="custom__label" for="vehicle_rc_no">State</label>
                        <select wire:model.live.debounce.150ms="division_state" wire:loading.attr="disabled" wire:target="division_state" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="exampleSelectRounded0">
                            @forelse ($state as $list)
                                <option value="{{ $list->state_id }}">{{ $list->state_name }}</option>
                            @empty
                                <option value="" disabled>No state available</option>
                            @endforelse
                        </select>
                        @error('driver_city') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                  </div>
                
                  @endif
                  @if($this->activeTab != 'division')
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
                    @endif
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
                    <th>Sr.NO.</th>
                    <th>Division Name </th>
                    <th>Total Driver ({{ $sumDriverCountsByDivision}})</th>
                    <th>On Duty Driver</th>
                    <th>OFF Duty Driver</th>
                    <th>State Name</th>
                </tr>
                @php
                    $srno = 1
                @endphp
                    <tr>
                         @foreach($results as $key)
                        <tr>
                            <td class="table-plus">{{$srno}}</td>
                            <td>{{$key->division_name}}</td>
                            <td>{{$key->total_driver_count}}</td>
                                <td>{{$key->on_duty_count}}</td>
                            <td>{{$key->off_duty_count}}</td>
                            <td>{{$key->state_name}}</td>
                        </tr>
                        @php
                        $srno++
                        @endphp
                        @endforeach
                   
                    </tr>
                   

            </table>
            <div style="text-align:center;" wire:loading wire:target="selectedDate" wire:key="selectedDate"><i class="fa fa-spinner fa-spin mt-2 ml-2"></i>loading</div>

            </div>
            </div>
          
          <div class="custom__pagination card-footer__ clearfix">
          {!! $results->links() !!}
            </div>
            
    </div>
    </div>
</div>

