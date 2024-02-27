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

        <div class="card mt-2 custom__filter__responsive">
            <div class="card-header custom__filter__select">
                <div class="row">
                <div class="col __col-3">
                        <div class="form-group">
                            <label class="custom__label" for="fromDate">From </label>
                            <input wire:model.live="selectedFromDate" {{ !$isCustom ? 'disabled' : '' }} type="date" class="custom__input__field rounded-0 form-control form-control-sm" id="fromDate" placeholder="Enter from date">
                        </div>
                    </div>
                    <div class="col __col-3">
                        <div class="form-group">
                            <label class="custom__label" for="toDate">To</label>
                            <input wire:model.live="selectedToDate" type="date" max="<?=date('Y-m-d')?>" {{ !$isCustom ? 'disabled' : '' }} class="custom__input__field rounded-0 form-control form-control-sm" id="toDate" placeholder="Enter to date">
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
                            <label class="custom__label">HealthCard By Status</label>

                            <select wire:model.live.debounce.150ms="healthCardVerificationStatus" wire:mode.live="healthCardVerificationStatus" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="SelectUnderVerification">
                                <option selected value="AllVerification">All HealthCard</option>
                                <option value="NewVerification">New HealthCard</option>
                                <option value="ActiveVerification">Active HealthCard</option>
                                <option value="AppliedVerification">Applied HealthCard</option>
                                <option value="InactiveVerification">Block HealthCard</option>

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
						<th>Sr. No.</th>
						<th>Id</th>
				        <th>Create At</th>
					    <th>Consumer</th>
					    <th>Mobile</th>
						<th>Subscription</th>
                        <th>Number</th>
						<th>Gender</th>
						<th>Address</th>
						<th>Subscription No</th>
						<th>Subscription Duration</th>
						<th>Remark Details</th>
						<th>Subscription Status</th>
						<th>Action</th>
				</tr>

                    @if(!empty($healthcardData))
						<?php $sr=1;?>
                           @foreach($healthcardData as $key)
                                 <tr>
                                     <td class="table-plus"><?php echo $sr++; ?></td>
                                     <td>Subscription ID :{{$key->health_card_subscription_id}}</td>
									 <td>{{date('j F Y,h:i A',$key->health_card_subscription_added_time_unx)}} </td>
                                     <td>{{$key->consumer_name}}</td>
                                     <td>{{$key->consumer_mobile_no}}</td>
                                      <td>{{$key->health_card_subscription_name,' '.$key->health_card_subscription_last_name}}</td>
                                      <td>{{$key->health_card_subscription_mobile_no}}</td>
                                     <td>{{$key->health_card_subscription_gender}}</td>
                                     <td>{{$key->ua_address}}</td>
                                     <td> Card No. {{$key->health_card_subscription_card_no}}</td>
                                     <td>{{$key->health_card_plan_duration}}</td>
									<td>
                                    @if(($key->remark_id))
                                    <input type="text" value="{{$key->remark_text}}" class="text-center">
                                    @else
                                    <input type="text" placeholder="Enter The Remark" class="text-center">
                                    @endif
                                    <br />
                                   
									</td>
                                     <td>
                                       @if($key->health_card_subscription_status == '1')
										Applied Verification
                                         @elseif($key->health_card_subscription_status == '2')
                                          Active
                                         @elseif($key->health_card_subscription_status == '0')
                                          New
                                         @elseif($key->health_card_subscription_status == '#')
                                          Inactive
                                          @else
                                           
                                      @endif
                                      </td>
                                      <td class="action__btn lbtn-group">
                                            <button class="btn-primary"><i class="fa fa-edit fa-sm"></i></button>
                                            <button class="btn-success"><i class="fa fa-eye fa-sm"></i></button>
                                            <button wire:confirm="Are you sure you want to delete this Consumer?"  class="btn-danger"><i class="fa fa-trash fa-sm"></i></button>
                                        </td>
									        </tr>
                                  @endforeach
                      @endif

                </table>
                <!-- <span wire:loadingf wire:target="filterCondition">Loading...</span> -->
                <div class="custom__pagination mt-2 pt-1 card-footer__ clearfix">
               {{ $healthcardData->links(data: ['scrollTo' => '#paginated-posts']) }}
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