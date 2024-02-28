<div class="content">
   @if(($this->activeTab =='divisionWise'))
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
										{{ $list->state_name }} (total: {{ $list->division_count }})
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
                        <th>Division</th>
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
                        <td>{{$list->division_name}}</td>
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
   @if(($this->activeTab =='cityWise'))
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
										{{ $list->state_name }} (total: {{ $list->city_count }})
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
                        <th>City</th>
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
                        <td>{{$list->city_name}}</td>
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

   @if(($this->activeTab =='hospitalMap'))
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
                            <label class="custom__label">Select Hospital Name</label>
                            <select wire:model.live.debounce.150ms="HospitalId"  wire:loading.attr="disabled" wire:target="HospitalId" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="StateId">
                            <option selected>No Hospital</option>
                            @foreach ($hospitalData as $list)
									<option value="{{ $list->hospital_id }}"> {{ $list->hospital_name }}</option>
								@endforeach
                            </select>
                        </div>
                    </div>
                   
                    <div class="col __col-3">
                        <div class="form-group">
                            <label class="custom__label" for="toDate">Search</label>
                            <input type="search" wire:model.live.debounce.150ms="search" wire:loading.attr="disabled" wire:target="HospitalId" class="custom__input__field form-control rounded-0 form-control-sm float-right" placeholder="Search">
                        </div>
                    </div>
                </div>

            </div>
          
            <!-- <table class="table table-bordered table-sm table-responsive-sm mt-2"> -->
            <div wire:loading.remove wire:target="filterCondition" class="card-body p-2 overflow-auto">
                <table class="table custom__table table-bordered table-sm ">
                 

                  
                </table>
                <!-- <span wire:loadingf wire:target="filterCondition">Loading...</span> -->
                <div class="custom__pagination mt-2 text-right pt-1 card-footer__ clearfix">
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
