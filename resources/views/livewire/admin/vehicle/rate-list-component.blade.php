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

    @if(!empty($ambulanceFacility))
    <div class="container-fluid">
        @if ($isOpen)
        @include('livewire.admin.vehicle.add_ambulance_facility')
        @endif

        @if (session()->has('inactiveMessage'))

        <div class="alert alert-danger alert-dismissible" role="alert">
            <span type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></span>
            <strong>{{ session('inactiveMessage') }}!</strong>
        </div>

        @elseif (session()->has('activeMessage'))

        <div class="alert alert-success alert-dismissible" role="alert">
            <span type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></span>
            <strong>{{ session('activeMessage') }}!</strong>
        </div>
        @endif

        @include('livewire.admin.vehicle.rateList_navbar')

        <div class="card mt-2 custom__filter__responsive">
            <div class="card-header custom__filter__select">

                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="custom__label">Category</label>

                            <select wire:model.live.debounce.150ms="categoryId" wire:mode.live="categoryId" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="categoryVerificationStatus">
                                <option selected value="AllCategory">All Category</option>
                                @foreach($ambulanceCategoryData as $category)
                                <option value="{{$category->ambulance_category_id }}">{{$category->ambulance_category_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group">
                            <label class="custom__label" for="toDate">Search</label>
                            <input type="search" wire:model.live.debounce.150ms="search" class="custom__input__field form-control rounded-0 form-control-sm float-right" placeholder="Search">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="custom__label">Facility Add</label>
                            <button style="height:25px" class="w-100 mb-sm-2 mb-0 btn-primary btn rounded submit__btn d-flex align-items-center justify-content-center">
                                <a class="custom__label text-white" wire:click="createFacility()"><i class="fa fa-plus"></i> Add</a>
                            </button>
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
                        <th>Ambulance</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Category Type</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>

                    @php
                    $srno = 1
                    @endphp @if(!empty($ambulanceFacility))

                    @foreach($ambulanceFacility as $list)
                    <tr>
                        <td>{{ $srno }}</td>
                        <td>{{ $list->ambulance_facilities_id }}</td>
                        <td>{{$list->ambulance_facilities_name}}</td>
                        <td>{{$list->ambulance_category_name}}</td>
                        <td><img src="{{env('Image_url')}}{{$list->ambulance_facilities_image}}" alt="{{$list->ambulance_facilities_name}}" style="width:20px;height:20px;"></td>
                        <td>{{$list->ambulance_facilities_category_type}}</td>
                        <td>{{($list->ambulance_facilities_state =='1') ? 'Inacive' : 'Active';}}</td>
                        <td>{{date('d-F-Y h:i A', ($list->ambulance_facilities_created_time))}}</td>             
                         <td class="action__btn lbtn-group">
                           @if($list->ambulance_facilities_state=='0')
                            <button wire:confirm="Are you sure you want to Inactive this Category?" wire:click="deleteFacilityData({{ $list->ambulance_facilities_id  }})" class="btn-success"><i class="fa fa-check"></i></button>
                            @else
                            <button wire:confirm="Are you sure you want to Active this Category?" wire:click="deleteFacilityData({{ $list->ambulance_facilities_id }})" class="btn-danger" type="submit"><i class="fa fa-times" aria-hidden="true"></i></button>
                            @endif  
                            <button class="btn-primary" wire:click="editFacility({{ $list->ambulance_facilities_id }})"><i class="fa fa-edit"></i></button>
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
                {{$ambulanceFacility->links()}}
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row" wire:loading wire:target="selectedDate,categoryId,filterCondition" wire:key="selectedDate,categoryId,filterCondition">
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

    @if(!empty($this->activeTab == 'ambulanceAddOnce'))
    <div class="container-fluid">
        @if ($isOpen)
        @include('livewire.admin.vehicle.add_support_facility')
        @endif

        @if (session()->has('inactiveMessage'))

        <div class="alert alert-danger alert-dismissible" role="alert">
            <span type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></span>
            <strong>{{ session('inactiveMessage') }}!</strong>
        </div>

        @elseif (session()->has('activeMessage'))

        <div class="alert alert-success alert-dismissible" role="alert">
            <span type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></span>
            <strong>{{ session('activeMessage') }}!</strong>
        </div>
        @endif

        @include('livewire.admin.vehicle.rateList_navbar')

        <div class="card mt-2 custom__filter__responsive">
            <div class="card-header custom__filter__select">

                <div class="row">
                    <div class="col __col-6">
                        <div class="form-group">
                            <label class="custom__label">Status</label>

                            <select wire:model.live.debounce.150ms="categoryId" wire:mode.live="categoryId" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="categoryVerificationStatus">
                            <option selected value="AllCategory">All Category</option>
                                @foreach($ambulanceCategoryData as $category)
                                <option value="{{$category->ambulance_category_id }}">{{$category->ambulance_category_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col __col-6">
                        <div class="form-group">
                            <label class="custom__label" for="toDate">Search</label>
                            <input type="search" wire:model.live.debounce.150ms="search" class="custom__input__field form-control rounded-0 form-control-sm float-right" placeholder="Search">
                        </div>
                    </div>
                    <div class="col ">
                        <div class="form-group">
                            <label class="custom__label">Add On's Add</label>
                            <button style="height:25px" class="w-100 mb-sm-2 mb-0 btn-primary btn rounded submit__btn d-flex align-items-center justify-content-center">
                                <a class="custom__label text-white" wire:click="createCategory()"><i class="fa fa-plus"></i> Add</a>
                            </button>
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
                        <th>Category</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Category Type</th>
                        <th>Status</th>
                        <th>Amounts</th>
                        <th>Action</th>
                    </tr>

                    @php
                    $srno = 1
                    @endphp @if(!empty($ambulanceAddOnce))

                    @foreach($ambulanceAddOnce as $list)
                    <tr>
                        <td>{{ $srno }}</td>
                        <td>{{ $list->ambulance_support_specialists_id }}</td>
                        <td>{{ $list->ambulance_category_name }}</td>
                        <td>{{$list->ambulance_support_specialists_name}}</td>
                        <td><img src="{{env('Image_url')}}{{$list->ambulance_support_specialists_image_circle}}" alt="{{$list->ambulance_support_specialists_name}}" style="width:20px;height:20px;"></td>
                        <td>{{$list->ambulance_support_specialists_category_name}}</td>
                        <td>{{($list->ambulance_support_specialists_status =='50') ? 'Active' : 'Inactive';}}</td>
                        <td>&#8377; {{$list->ambulance_support_specialists_amount}}</td>             
                         <td class="action__btn lbtn-group">
                           @if($list->ambulance_support_specialists_status=='50')
                            <button wire:confirm="Are you sure you want to Inactive this Support Specialist ?" wire:click="deleteSpecialData({{ $list->ambulance_support_specialists_id   }})" class="btn-success"><i class="fa fa-check"></i></button>
                            @else
                            <button wire:confirm="Are you sure you want to Active this Support Specialist ?" wire:click="deleteSpecialData({{ $list->ambulance_support_specialists_id  }})" class="btn-danger" type="submit"><i class="fa fa-times" aria-hidden="true"></i></button>
                            @endif  
                            <button class="btn-primary"  wire:click="editSupportFacility({{ $list->ambulance_support_specialists_id }})"><i class="fa fa-edit"></i></button>
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
                {{$ambulanceAddOnce->links()}}
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row" wire:loading wire:target="selectedDate,categoryId,filterCondition" wire:key="selectedDate,filterCondition,categoryId">
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

    @if(!empty($ambulanceData))

    <div class="container-fluid">
        @if ($isOpen)
        @endif

        @if (session()->has('inactiveMessage'))

        <div class="alert alert-danger alert-dismissible" role="alert">
            <span type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></span>
            <strong>{{ session('inactiveMessage') }}!</strong>
        </div>

        @elseif (session()->has('activeMessage'))

        <div class="alert alert-success alert-dismissible" role="alert">
            <span type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></span>
            <strong>{{ session('activeMessage') }}!</strong>
        </div>
        @endif

        @include('livewire.admin.vehicle.rateList_navbar')

        <div class="card mt-2 custom__filter__responsive">
            <div class="card-header custom__filter__select">

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
                            <label class="custom__label">Status</label>

                            <select wire:model.live.debounce.150ms="categoryVerificationStatus" wire:mode.live="categoryVerificationStatus" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="categoryVerificationStatus">
                                <option selected value="AllCategory">All Category</option>
                                <option value="ActiveCategory">Active Category</option>
                                <option value="InactiveCategory">Inactive Category</option>

                            </select>
                        </div>
                    </div>

                    <div class="col __col-2">
                        <div class="form-group">
                            <label class="custom__label" for="toDate">Search</label>
                            <input type="search" wire:model.live.debounce.150ms="search" class="custom__input__field form-control rounded-0 form-control-sm float-right" placeholder="Search">
                        </div>
                    </div>
                    <div class="col ">
                        <div class="form-group">
                            <label class="custom__label">Rate Add</label>
                            <button style="height:25px" class="w-100 mb-sm-2 mb-0 btn-primary btn rounded submit__btn d-flex align-items-center justify-content-center">
                                <a class="custom__label text-white"><i class="fa fa-plus"></i> Add</a>
                            </button>
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
                        <th>Name</th>
                        <th>Image</th>
                        <th>Category Type</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>

                    @php
                    $srno = 1
                    @endphp @if(!empty($ambulanceData))

                    @foreach($ambulanceData as $list)
                    <tr>
                        <td>{{ $srno }}</td>
                        <td>{{ $list->ambulance_category_id  }}</td>
                        <td>{{$list->ambulance_category_name}}</td>
                        <td><img src="{{env('Image_url') ? env('Image_url'):url($list->ambulance_category_icon) }}{{$list->ambulance_category_icon}}" alt="{{$list->ambulance_category_name}}" style="width:20px;height:20px;"></td>
                        <td>{{$list->ambulance_category_type}}</td>
                        <td>{{($list->ambulance_category_status =='1') ? 'Inacive' : 'Active';}}</td>
                        <td>{{date('d-F-Y h:i A', strtotime($list->ambulance_category_added_date))}}</td>             
                         <td class="action__btn lbtn-group">
                           @if($list->ambulance_category_status=='0')
                            <button wire:confirm="Are you sure you want to Inactive this Category?" wire:click="deleteCategoryData({{ $list->ambulance_category_id  }})" class="btn-success"><i class="fa fa-check"></i></button>
                            @else
                            <button wire:confirm="Are you sure you want to Active this Category?" wire:click="deleteCategoryData({{ $list->ambulance_category_id }})" class="btn-danger" type="submit"><i class="fa fa-times" aria-hidden="true"></i></button>
                            @endif  
                            <button class="btn-primary"><i class="fa fa-edit"></i></button>
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
                {{$ambulanceData->links()}}
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row" wire:loading wire:target="selectedDate,categoryVerificationStatus,filterCondition" wire:key="selectedDate,categoryVerificationStatus,filterCondition">
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