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

        <div class="card mt-2 custom__filter__responsive">
            <div class="card-header custom__filter__select">
                <div class="row">
                <div class="col __col-3">
                        <div class="form-group">
                            <label class="custom__label" for="fromDate">From </label>
                            <input wire:model.live="selectedFromDate"  {{ !$isCustom ? 'disabled' : '' }} type="date" class="custom__input__field rounded-0 form-control form-control-sm" id="fromDate" placeholder="Enter from date">
                        </div>
                    </div>
                    <div class="col __col-3">
                        <div class="form-group">
                            <label class="custom__label" for="toDate">To</label>
                            <input wire:model.live="selectedToDate" {{ !$isCustom ? 'disabled' : '' }} type="date" max="<?=date('Y-m-d')?>" class="custom__input__field rounded-0 form-control form-control-sm" id="toDate" placeholder="Enter to date">
                        </div>
                    </div>
                    <div class="col __col-3">
                    <div class="form-group">
                            <label class="custom__label">Select</label>
                            <select wire:model.live.debounce.150ms="selectedDate" wire:model="check_for" wire:mode.live="selectedDate" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="exampleSelectRounded0">
                                <option selected value="" disabled>Select Filters</option>
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
                            <label class="custom__label">Lab List By Status</label>

                            <select wire:model.live.debounce.150ms="labVerificationStatus" wire:mode.live="labVerificationStatus" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="SelectUnderVerification">
                                <option selected value="AllVerification">All Lab</option>
                                <option value="NewVerification">New Lab</option>
                                <option value="ActiveVerification">Active Lab</option>
                                <option value="InactiveVerification">Block Lab</option>

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
                        <th>Owner Name</th>
                        <th>Mobile</th>
                        <th>Lab</th>
                        <th>Wallet</th>
                        <th>Lab logo</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>

                    @php
                    $srno = 1;

                    $statusMapper['3'] = "New";
                    $statusMapper['4'] = "New";
                    $statusMapper['5'] = "Inactive";
                    $statusMapper['6'] = "Verified";
                 
                    @endphp

                    @if(!empty($lablistData))

                    @foreach ($lablistData as $lablist)

                    <tr>
                        <td>{{ $srno }}</td>
                        <td>{{$lablist->lab_owner_id }}</td>
                        <td>{{date('j F, Y h:i A', $lablist->lab_owner_added_time)}}</td>
                        <td>{{$lablist->lab_owner_name}}</td>
                        <td>{{$lablist->lab_owner_mobile_number}}</td>
                        <td>{{$lablist->lab_name}}</td>
                        <td>{{$lablist->lab_wallet}}.&#8377</td>
                        <td><img src="{{env('pathology_url') ? env('pathology_url'):url($lablist->lab_image) }}{{$lablist->lab_image}}" alt="{{$lablist->lab_name}}" style="width:20px;height:20px;"></td>
                        <td>{{$statusMapper[$lablist->lab_owner_status]}}</td>
                        <td class="action__btn lbtn-group">
                            <button class="btn-primary"><i class="fa fa-edit fa-sm"></i></button>
                            @if($lablist->lab_owner_status == '6')
                            <button wire:confirm="Are You Sure You Want to Inactive This Lab Owner Data ?" wire:click="deleteLabList({{ $lablist->lab_owner_id  }})" class="btn-primary"><i class="fa fa-check"></i></button>
                            @elseif($lablist->lab_owner_status == '5')
                            <button wire:confirm="Are You Sure You Want to Active This Lab Owner Data ?" wire:click="deleteLabList({{ $lablist->lab_owner_id  }})" class="btn-danger"><i class="fa fa-times" aria-hidden="true"></i></button>
                            @else 

                            @endif
                            
                            @if(!empty($lablist->lab_owner_id))
                            <button wire:navigate href="{{route('lab_details',['LabOwnerId' => Crypt::encrypt($lablist->lab_owner_id),'Details'=>'Details'])}}" class="btn-success"><i class="fa fa-eye fa-sm"></i></button>
                            @endif

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
                   {{ $lablistData->links(data: ['scrollTo' => '#paginated-posts']) }}
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row" wire:loading wire:target="selectedDate,labVerificationStatus,filterCondition" wire:key="selectedDate,labVerificationStatus,filterCondition">
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