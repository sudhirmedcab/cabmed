<div class="content">
  <style>
    .loader{
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
.loader .loader-inner{
    position: relative;
    display: inline-block;
    width: 50%;
    height: 50%;
}
.loader .loading{
    position: absolute;
    background: #dcdee5;
}
.loader .one{
    width: 100%;
    bottom: 0;
    height: 0;
    animation: loading-one 1s infinite;
}
.loader .two{
    width: 0;
    height: 100%;
    left: 0;
    animation: loading-two 1s infinite;
    animation-delay: 0.25s;
}
.loader .three{
    width: 0;
    height: 100%;
    right: 0;
    animation: loading-two 1s infinite;
    animation-delay: 0.75s;
}
.loader .four{
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
    @if ($isOpen)
            @include('livewire.partner-form')
        @endif
        
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
        
         <!-- @include('partner.partner_nav') -->  <!----------- It partner nav bar no needs currently Date: 02/02/2024 ---->
            
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
                    <div class="col __col-3">
                        <div class="form-group">
                          <label class="custom__label">Partner By Status</label>

                          <select wire:model.live.debounce.150ms="partnerVerificationStatus" wire:mode.live="partnerVerificationStatus" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="SelectUnderVerification">
                          <option selected value="AllVerification">All Partner</option>
                          <option  value="NewVerification">New Partner</option>
                          <option  value="ActiveVerification">Active Partner</option>
                         
                        </select>
                        </div>
                    </div>

                    <div class="col __col-2">
                      <div class="form-group">
                          <label class="custom__label" for="toDate">Search</label>
                          <input type="search" wire:model.live.debounce.150ms="search" class="custom__input__field form-control rounded-0 form-control-sm float-right" placeholder="Search">
                      </div>
                    </div>
                    <div class="col d-flex align-items-center w-100 h-100 p-2">
                      <div class="form-group w-75 h-100">
                          <a style="height:40px" class=" w-100 custom__label btn btn-primary float-right" wire:click="create()"><i class="fa fa-plus"></i> Add</a>

                      </div>
                    </div>
                </div>
                
              </div>
            
            <!-- <table class="table table-bordered table-sm table-responsive-sm mt-2"> -->
                <div  wire:loading.remove wire:target="filterCondition" class="card-body p-2">
                <table class="table custom__table table-bordered table-sm">
                <tr>
                   <th>Sr.</th>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Wallet</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Driver Details</th>
                    <th>Vehicle Details</th>
                    <th>Total Driver</th>
                    <th>Total Vehicle</th>
                    <td>Remark</td>
                    <th>City</th>
                    <th>State</th>
                    <th>Action</th>

                </tr>

                @php
                $srno = 1
                @endphp   @if(!empty($data['partner']))

                @foreach($data['partner'] as $key)
                <tr>
                <td>{{ $srno }}</td>
                <td>{{ $key['partner_id'] }}</td>
                <td>{{$key['partner_f_name']. ' '.$key['partner_l_name']}}</td>
                <td>{{$key['partner_mobile']}}</td>
                <td>{{$key['partner_wallet']}}.	&#8377</td>
                
                <td> @if ($key['partner_status'] == '0')
                    {{'New'}}
                    @elseif($key['partner_status'] == '1')
                    {{'Active'}}
                    @else
                    {{'Inactive'}}
                    @endif</td>

                    <td>
                    {{ date("j F, Y h:i A", strtotime($key['created_at']))}}
                </td>

                <td>
                    {{$key['active_driver_count']}}(A) ,{{$key['pending_driver_count']}}(P),{{$key['new_driver_count']}}(N)
                </td>
                <td> {{$key['active_vehicle_count']}}(A) ,{{$key['pending_vehicle_count']}}(P),{{$key['new_vehicle_count']}}(N) </td>
                <td>{{$key['total_driver']}}</td>
                <td>{{$key['total_vehicle']}}</td>
                <td>
                @if($key['remark_id']) {{$key['remark_text']}} @else N/A @endif

                </td>
                <td>{{$key['city_name']}} </td>
                <td>{{$key['state_name']}}</td>
                    <td class="action__btn lbtn-group">
                            <button class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></button>
                        <button wire:confirm="Are you sure you want to delete this Partner Data?"
                                wire:click="delete({{ $key['partner_id']  }})" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
                @php
                $srno++
                @endphp
                @endforeach
                @endif

            </table>
            <!-- <span wire:loadingf wire:target="filterCondition">Loading...</span> -->
            <div class="custom__pagination pt-1 card-footer__ clearfix">
            {{$partners->links()}}
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
             <!-- <div style="text-align:center !important; display:block !important" wire:loading wire:target="selectedDate,driverVerificationStatus,filterCondition" wire:key="selectedDate,Onduty,Offduty"><i class="fa fa-spinner fa-spin mt-2 ml-2"></i>Processing..</div> -->

    </div>
    </div>
</div>



