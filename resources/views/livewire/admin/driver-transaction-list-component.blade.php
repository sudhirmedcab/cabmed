
<?php

    $createdMapper['0'] = "Self";
    $createdMapper['1'] = "Partner";

    $transactionTypeMapper['1'] = "add-in wallet by Self(A)";
    $transactionTypeMapper['2'] = "cancelation charge(W)";
    $transactionTypeMapper['3'] = "Cash Collect(W)";
    $transactionTypeMapper['4'] = "online booking payment(A)";
    $transactionTypeMapper['5'] = "transfer to bank account (W)";
    $transactionTypeMapper['6'] = "fetched by Partner (W)";
    $transactionTypeMapper['7'] = "Incentive from Company(A)";
    $transactionTypeMapper['8'] = "add in wallet Recharge wallet by Partner(A)";
    $transactionTypeMapper['9'] = "for add in walletRecharge by partner's wallet transfer(A)";

    ?>

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
   
        
         <!--=========================== Driver Details Nav Bar Starts =================================================================--->
   @include('livewire.admin.driver_details_nav_bar')
    <!--=========================== Driver Details Nav Bar Ends =================================================================--->

        <div class="card mt-2 custom__filter__responsive">
            <div class="card-header custom__filter__select">

                <div class="row">
                    <div class="col __col-3">
                        <div class="form-group">
                            <label class="custom__label" for="fromDate">From </label>
                            <input wire:model.live="selectedFromDate" {{ !$isCustom ? 'disabled' : '' }} type="date" class="custom__input__field rounded-0 form-control form-control-sm" id="fromDate" placeholder="Enter from date">
                        </div>
                    </div>
                    <div class="col __col-3}}">
                        <div class="form-group">
                            <label class="custom__label" for="toDate">To</label>
                            <input wire:model.live="selectedToDate" type="date" max="<?=date('Y-m-d')?>" {{ !$isCustom ? 'disabled' : '' }} class="custom__input__field rounded-0 form-control form-control-sm" id="toDate" placeholder="Enter to date">
                        </div>
                    </div>
                    <div class="col -col-3">
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
                        <th>Transaction</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Total Wallet</th>
                        <th>Previous Amount</th>
                        <th>New Amount</th>
                        <th>Transaction Types</th>
                        <th>Transaction Notes</th>
                        <th>Action</th>

                    </tr>

                    @php
                    $srno = 1
                    @endphp @if(!empty($transactionDetails))

                    @foreach($transactionDetails as $list)
                    @if(!empty($list->driver_transection_id))
                    <tr>
                        <td>{{ $srno }}</td>
                        <td>{{ $list->driver_transection_id }}</td>
                        <td>{{ date("j F, Y h:i A", ($list->driver_transection_time_unix)) }}</td>
                        <td>{{$list->driver_name.' '.$list->driver_last_name}}({{$list->driver_id}})</td>
                        <td>{{$list->driver_mobile}}</td>
                        <td>{{$list->driver_wallet_amount}} &#8377</td>
                        <td>{{$list->driver_transection_wallet_previous_amount}} &#8377</td> 
                        <td>{{$list->driver_transection_wallet_new_amount}} &#8377</td> 
                        <td>{{$transactionTypeMapper[$list->driver_transection_type]}}</td>
                        <td>{{$list->driver_transection_note}}</td>

                        <td class="action__btn lbtn-group">
                            <button class="btn-primary"><i class="fa fa-edit"></i></button>
                            <button class="btn-success"><i class="fa fa-eye"></i></button>
                           
                        </td>
                    </tr>
                    @endif
                    @php
                    $srno++
                    @endphp
                    @endforeach
                    @endif

                </table>
                <!-- <span wire:loadingf wire:target="filterCondition">Loading...</span> -->
                <div class="custom__pagination mt-2 pt-1 card-footer__ clearfix">
                {!! $transactionDetails->links() !!}
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