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

    @if(!empty($driverWithdrawTransaction))

@php 

    $transactionTypeMapper['0'] = "Default Value Of Driver Transaction";
    $transactionTypeMapper['1'] = "Add-in wallet by Self(A)";
    $transactionTypeMapper['2'] = "Cancelation charge(W)";
    $transactionTypeMapper['3'] = "Cash Collect(W)";
    $transactionTypeMapper['4'] = "Online booking payment(A)";
    $transactionTypeMapper['5'] = "Transfer to bank account (W)";
    $transactionTypeMapper['6'] = "Fetched by Partner (W)";
    $transactionTypeMapper['7'] = "Incentive from Company(A)";
    $transactionTypeMapper['8'] = "Add in wallet Recharge wallet by Partner(A)";
    $transactionTypeMapper['9'] = "For add in walletRecharge by partner's wallet transfer(A)";

@endphp 

<div class="container-fluid">
        @if ($isOpen)
        @include('livewire.admin.transaction.driver_withdraw_payment')
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

           <!--=========================== Transaction Details Nav Bar Starts =================================================================--->
                   @include('livewire.admin.transaction.transaction_nav_bar')
           <!--=========================== Transaction Details Nav Bar Ends =================================================================--->

        <div class="card mt-2">
            <div class="card-header custom__filter__select">
                <div class="row">
                <div class="col __col-2">
                        <div class="form-group">
                            <label class="custom__label" for="fromDate">From </label>
                            <input wire:model.live="selectedFromDate" {{ !$isCustom ? 'disabled' : '' }} type="date" class="custom__input__field rounded-0 form-control form-control-sm" id="fromDate" placeholder="Enter from date">
                        </div>
                    </div>
                    <div class="col __col-2">
                        <div class="form-group">
                            <label class="custom__label" for="toDate">To</label>
                            <input wire:model.live="selectedToDate" type="date" max="<?=date('Y-m-d')?>" {{ !$isCustom ? 'disabled' : '' }} class="custom__input__field rounded-0 form-control form-control-sm" id="toDate" placeholder="Enter to date">
                        </div>
                    </div>
                    <div class="col __col-2">
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
                    <div class="col __col-2">
                        <div class="form-group">
                            <label class="custom__label">Payment By Status</label>
                            <select wire:model.live.debounce.150ms="PaymentServiceFiter" wire:mode.live="PaymentServiceFiter" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="SelectUnderVerification">
                                <option Selected value="All">All</option>
                                <option  value="Success">Success</option>
                                <option value="Failed">Pending Withdraw Request</option>
                             </select>

                        </div>
                    </div>

                    <div class="col __col-2">
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
                        <th>Sr.No.</th>
						<th>ID</th>
						<th>Pay ID</th>
						<th>Transaction By</th>
						<th>Transaction For</th>
						<th>Transaction Type</th>
						<th>Transaction Platform</th>
						<th>Driver Name</th>
						<th>Driver No</th>
						<th>Bank Details</th>
						<th>Transaction Amounts</th>
						<th>Transaction Note</th>
						<th>Transaction Prev.</th>
						<th>Transaction New.</th>
						<th>Payment Date</th>
						<th>Status</th>
					    <th>Action</th>
                    </tr>

                    @php
                    $srno = 1;
                    @endphp
                    @if(!empty($driverWithdrawTransaction))
                    @foreach ($driverWithdrawTransaction as $list)

                    <tr>
                        <td>{{ $srno }}</td>
                        <td>{{$list->driver_transection_id}}</td>
                        <td>{{$list->driver_transection_pay_id}}</td>
                        <td>{{ ($list->driver_transection_by_type == "0") ? "Direct Driver" : (($list->driver_transection_by_type == "1") ? "By Partner" : "By Company") }}</td>
                        <td>{{ ($list->driver_transection_by_type_pid == "0") ? "Driver" :"Partner" }}</td>
                        <td>{{$transactionTypeMapper[$list->driver_transection_type]}}</td>
                        <td>{{ ($list->driver_transection_by_partner_wallet_status == "0") ? "Online" : (($list->driver_transection_by_partner_wallet_status == "1") ? "Partner Wallet" : "Withdraw Amount") }}</td>
                        <td>{{$list->driver_name.' '.$list->driver_last_name }}</td>
                        <td>{{$list->driver_mobile }}</td>
                        <td>{{ ($list->driver_acc_dtl_d_id == "") ? "Not Available" :"Available" }}</td>
                        <td>&#8377;{{$list->driver_transection_amount}}</td>
                        <td>{{$list->driver_transection_note }}</td>
                        <td>&#8377;{{$list->driver_transection_wallet_previous_amount}}</td>
                        <td>&#8377;{{$list->driver_transection_wallet_new_amount}}</td>
                         <td>{{date('d-F-Y h:i A',$list->driver_transection_time_unix)}}</td> 
                         <td>{{ ($list->driver_transection_status == "0") ? "Success" :"Pending Withdraw Request" }}</td>
                        <td class="action__btn lbtn-group">
                            <button wire:navigate href="{{route('admin.driver-details-component',['driverId' => Crypt::encrypt($list->driver_id)])}}"  class="btn-success"><i class="fa fa-eye fa-sm"></i></button>
                            <button wire:confirm="Are you sure you want to delete this Consumer Enquiry ?" class="btn-danger"><i class="fa fa-trash fa-sm"></i></button>
                            @if(!empty($list->driver_transection_status=='1'))
                            <button class="btn-secondary" wire:click="payDriverWithdraw({{$list->driver_transection_id}})"><i class="fa fa-edit"></i></button> @endif
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
                    {{ $driverWithdrawTransaction->links() }}
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row" wire:loading wire:target="selectedDate,mainServiceFiter,filterCondition" wire:key="selectedDate,mainServiceFiter,filterCondition">
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
    @endif
</div>
