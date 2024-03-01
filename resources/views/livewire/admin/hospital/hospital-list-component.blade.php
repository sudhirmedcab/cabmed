<div class="content">
    @if(!empty($hospital_list))
    <div class="container-fluid">
        @if (session()->has('message') && session()->has('type') == 'delete')
        <div class="alert alert-danger">{{ session('message') }}</div>
        @elseif (session()->has('message') && session()->has('type') == 'store')
        <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        @include('livewire.admin.hospital.hospital_nav_bar')

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
                            <input wire:model.live="selectedToDate" {{ !$isCustom ? 'disabled' : '' }} max="<?= date('Y-m-d') ?>" type="date"  class="custom__input__field rounded-0 form-control form-control-sm" id="toDate" placeholder="Enter to date">
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
                            <label class="custom__label"> Status</label>
                            <select wire:model.live.debounce.150ms="HospitalStatusFilter" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="HospitalStatusFilter">
                                <option value="All">All Hospital</option>
                                <option value="Verified">Verified Hospital</option>
                                <option value="Unverified">Unverified Hospital</option>
                                <option value="New">New Hospital</option>
                            </select>
                        </div>
                    </div>
                    <div class="col __col-3">
                        <div class="form-group">
                            <label class="custom__label"> City Name</label>
                            <select wire:model.live.debounce.150ms="cityId" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="cityId">
                            <option selected>No City</option>
                            @foreach ($cities as $city)
									<option value="{{ $city->hospital_city_name }}">
										{{ $city->city_name }} (total: {{ $city->total_hospital }})
									</option>
								@endforeach
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
                        <th>Owner</th>
                        <th>Mobile</th>
                        <th>Refferal Name</th>
                        <th>Refferal Mobile</th>
                        <th>Location Update</th>
                        <th>Hospital</th>
                        <th>Mobile</th>
                        <th>Verification</th>
                        <th>Remark</th>
                        <th>Live Location</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>Action</th>
                    </tr>
                    @php
                    $srno = 1;
                    @endphp
                    @if(!empty($hospital_list))
                    @foreach($hospital_list as $list)
                    <tr>
                        <td class="table-plus"><?php echo $srno; ?></td>
                        <td>{{$list->hospital_id}}</td>
                        <td>{{date('j F Y,h:i A',$list->hospital_added_timestamp)}}</td>
                        <td>{!!wordwrap($list->hospital_users_name,25,"<br>\n")!!}
                       <p>Total added Service: ({{$buckethlist[$list->hospital_id]}})</p>
                </td>
                    <td>{{$list->hospital_users_mobile}}</td>
                            <td>
                            @if ($list->hospital_users_referral_code)
                                 {{ ($list->tele_caller_name) ? $list->tele_caller_name:"No Name" }}
                            @else
                                {{"Not Any Referral"}}
                            @endif</td>
                        <td> @if ($list->hospital_users_referral_code)
                             {{ ($list->tele_caller_mobile_no) ? $list->tele_caller_mobile_no : "No Number" }} @endif</td>
                        <td>@if ($list->verify_date && $list->verify_by)
                                {{ "Lat and Long Updated By Admin"}}
                            @else
                                <p>Not Updated</p>
                            @endif</td>

                        <td>{!!wordwrap($list->hospital_name,25,"<br>\n")!!}</td>
                        <td> {{$list->hospital_contact_no}}</td>
                        <td> @if($list->hospital_verify_status == '1') <span class="badge badge-success">Verified @elseif($list->hospital_verify_status=='0') <span class="badge badge-primary">UnVerified </span> @else N/A @endif</td>
                        <td>
                            <input type="text" wire:model="remarkText" wire:key="{{$list->hospital_id}}" value="{{$list->remark_text ?? null}}" placeholder="Enter The Remark" class="text-center">
                            <input type="hidden" wire:model="hospitalId" value="{{$list->hospital_id}}" class="text-center">

                            <br />
                            <p class="m-0 mt-2">
                                Remark Text:
                               ( {{$list->remark_text}} )
                            </p>
                             
                           
                        </td>
                            @if(!empty(($list->hospital_lat && $list->hospital_long)))  
                            <td><p>Location Available</p></td>    
                            @elseif(($list->hospital_lat && $list->hospital_lat) =='0')
                                <td><p>Not Available</p></td>       
                            @elseif(($list->hospital_lat && $list->hospital_long) =='NULL')
                                <td><p>Not Available</p></td>       
                            @else
                                <td><p>Not Available</p></td>
                            @endif			    

                            @if(!empty($list->hospital_address))  
                            <td>{!!wordwrap($list->hospital_address,25,"<br>\n")!!}</td>    
                            @else
                                <td>No Address</td>        
                            @endif
                            <td>{{$list->city_name}}</td>
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
                <!-- <span wire:loadingf wire:target="filterCondition">Loading...</span> -->
                <div class="custom__pagination mt-2 text-right pt-1 card-footer__ clearfix">
                {{$hospital_list->links()}}
                  </div>
            </div>
        </div>

        <div class="container h-100 w-100">
           <div class="row w-100 h-100 align-items-center justify-content-center" wire:loading wire:target="selectedDate,HospitalStatusFilter,filterCondition,cityId" wire:key="selectedDate,HospitalStatusFilter,filterCondition,cityId">
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
    @endif

  <!----=======================================  Hospital Owner =================================================----->

    @if(($this->activeTab =='HospitalOwner'))       
    <div class="container-fluid">
        @if (session()->has('message') && session()->has('type') == 'delete')
        <div class="alert alert-danger">{{ session('message') }}</div>
        @elseif (session()->has('message') && session()->has('type') == 'store')
        <div class="alert alert-success">{{ session('message') }}</div>
        @endif
        @include('livewire.admin.hospital.hospital_nav_bar')

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
                            <input wire:model.live="selectedToDate" {{ !$isCustom ? 'disabled' : '' }} max="<?= date('Y-m-d') ?>" type="date"  class="custom__input__field rounded-0 form-control form-control-sm" id="toDate" placeholder="Enter to date">
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
                            <label class="custom__label"> Status</label>
                            <select wire:model.live.debounce.150ms="HospitalStatusFilter" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="HospitalStatusFilter">
                                <option value="All">All Hospital</option>
                                <option value="Verified">Verified Hospital</option>
                                <option value="Unverified">Unverified Hospital</option>
                                <option value="New">New Hospital</option>
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
                        <th>Owner</th>
                        <th>Mobile</th>
                        <th>Image</th>
                        <th>Refferal Name</th>
                        <th>Refferal Mobile</th>
                        <th>Hospital</th>
                        <th>Mobile</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>Action</th>
                    </tr>
                    @php
                    $srno = 1;
                    @endphp
                    @if(!empty($hospital_user))
                    @foreach($hospital_user as $list)
                    <tr>
                        <td class="table-plus"><?php echo $srno; ?></td>
                        <td>{{$list->hospital_id}}</td>
                        <td>{{date('j F Y,h:i A',$list->hospital_added_timestamp)}}</td>
                        <td>{!!wordwrap($list->hospital_users_name,25,"<br>\n")!!}
                </td>
                <td>  <img src="{{ $list->hospital_users_profile_image ? env('HospitalUrl') . $list->hospital_users_profile_image : asset('assets/app_icon/default.png') }}" alt="{{$list->hospital_users_name}}" style="width:20px;height:20px;"></td>
                    <td>{{$list->hospital_users_mobile}}</td>
                            <td>
                            @if ($list->hospital_users_referral_code)
                                 {{ ($list->tele_caller_name) ? $list->tele_caller_name:"No Name" }}
                            @else
                                {{"Not Any Referral"}}
                            @endif</td>
                        <td> @if ($list->hospital_users_referral_code)
                             {{ ($list->tele_caller_mobile_no) ? $list->tele_caller_mobile_no : "No Number" }} @endif</td>

                        <td>{!!wordwrap($list->hospital_name,25,"<br>\n")!!}</td>
                        <td> {{$list->hospital_contact_no}}</td>		    

                            @if(!empty($list->hospital_address))  
                            <td>{!!wordwrap($list->hospital_address,25,"<br>\n")!!}</td>    
                            @else
                                <td>No Address</td>        
                            @endif
                            <td>{{$list->city_name}}</td>
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
                <!-- <span wire:loadingf wire:target="filterCondition">Loading...</span> -->
                <div class="custom__pagination mt-2 text-right pt-1 card-footer__ clearfix">
                {{$hospital_user->links()}}
                  </div>
            </div>
        </div>

        <div class="container h-100 w-100">
            <div class="row w-100 h-100 align-items-center justify-content-center" wire:loading wire:target="selectedDate,HospitalStatusFilter,filterCondition" wire:key="selectedDate,HospitalStatusFilter,filterCondition">
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
    @endif

<!----======================= Hospital District =================================================----->

    @if(($this->activeTab =='districtWise'))
    <div class="container-fluid">
        @if (session()->has('message') && session()->has('type') == 'delete')
        <div class="alert alert-danger">{{ session('message') }}</div>
        @elseif (session()->has('message') && session()->has('type') == 'store')
        <div class="alert alert-success">{{ session('message') }}</div>
        @endif
        @include('livewire.admin.hospital.hospital_nav_bar')

        <div class="card custom__filter__responsive">
            <div class="card-header custom__filter__select ">

                <div class="row">
                    
               
                <div class="col __col-3">
                        <div class="form-group">
                            <label class="custom__label"> State Name</label>
                            <select wire:model.live.debounce.150ms="StateId"  wire:loading.attr="disabled" wire:target="StateId" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="StateId">
                            <option selected>No State</option>
                            @foreach ($stateData as $list)
									<option value="{{ $list->state_id }}">
										{{ $list->state_name }} (total: {{ $list->district_count }})
									</option>
								@endforeach
                            </select>
                        </div>
                    </div>
                   
                    <div class="col __col-3">
                        <div class="form-group">
                            <label class="custom__label" for="toDate">Search</label>
                            <input type="search" wire:model.live.debounce.150ms="search" wire:loading.attr="disabled" wire:target="StateId" class="custom__input__field form-control rounded-0 form-control-sm float-right" placeholder="Search">
                        </div>
                    </div>
                </div>

            </div>
          
            <!-- <table class="table table-bordered table-sm table-responsive-sm mt-2"> -->
            <div wire:loading.remove wire:target="filterCondition" class="card-body p-2 overflow-auto">
                <table class="table custom__table table-bordered table-sm ">
                    <tr>
                        <th>Sr.</th>
                        <th>District</th>
                        <th>State</th>
                        <th>Total Hospital</th>
                        <th>Action</th>
                    </tr>  

                    @php
                    $srno = 1;
                    @endphp
                    @if(!empty($hospitalData))
                    @foreach($hospitalData as $list)
                    <tr>
                        <td class="table-plus"><?php echo $srno; ?></td>
                        <td>{{$list->district_name}}</td>
                        <td>{{$list->state_name}}</td>
                        <td>{{$list->hospital_count}} </td>
            
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
                <!-- <span wire:loadingf wire:target="filterCondition">Loading...</span> -->
                <div class="custom__pagination mt-2 text-right pt-1 card-footer__ clearfix">
                {{$hospitalData->links()}}
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
    @endif
</div>
</div>

  <!-- /.card -->
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script>
    $(document).ready(function () {
        $('.select2-dropdown').select2();
        $('.select2-dropdown').on('change', function (e) {
            var data = $('.select2-dropdown').select2("val");
            @this.set('ottPlatform', data);
        });
    });
</script>
  <!-- /.row -->
