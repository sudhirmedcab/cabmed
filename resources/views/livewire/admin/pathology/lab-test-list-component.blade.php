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
                            <label class="custom__label">Lab Test List By Status</label>
                            <select wire:model.live.debounce.150ms="labTestVerificationStatus" wire:mode.live="labTestVerificationStatus" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="labTestVerificationStatus">
                                <option selected value="individualTest">Individual Test</option>
                                <option value="packageTest">Package Test</option>
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
                        <th>Test Name</th>
                        <th>Verification Status</th>
                        <th>Verification By</th>
                        <th>Samplet Collection Type</th>
                        <th>Category</th>
                        <th>Category Image</th>
                        <th>Test Image</th>
                        <th>Price</th>
                        <th>Offer Price</th>
                        <th>Rating</th>
                        <th>Action</th>
                    </tr>

                    @php
                    $srno = 1;

                    $statusMapper['3'] = "New";
                    $statusMapper['4'] = "New";
                    $statusMapper['5'] = "Inactive";
                    $statusMapper['6'] = "Verified";
                 
                    @endphp

                    @if(!empty($lab_test_data))

                    @foreach ($lab_test_data as $lablist)

                    <tr>
                        <td>{{ $srno }}</td>
                        <td>{{$lablist->lab_test_id}}</td>
                        <td>{{ date("j F, Y h:i A",strtotime($lablist->createdAt)) }}</td>
                        <td>{!!wordwrap($lablist->lt_test_name, 25, '<br />', true)!!}</td>
						<td>
						@isset($lablist->lt_verify_status)
							@if($lablist->lt_verify_status == '0')
									Unverified
									@else
							Verified
											@endif
										</span>
									@endisset
								</td>
                                <td>{{($lablist->admin_name)? $lablist->admin_name : "N/A"}}</td>
									<td>
										@isset($lablist->lt_lab_test_type)
											@if($lablist->lt_lab_test_type == '0')
												He Will collect at the door
											@elseif($lablist->lt_lab_test_type == '1')
												He Will come to the Address
											@endif
										@endisset
									</td>
									<td>
										@isset($lab_test_category[$lablist->lab_test_id])
											@foreach($lab_test_category[$lablist->lab_test_id] as $category)
												<p>{{ $category->lc_category_name }}</p>
											@endforeach
										@endisset
									</td>
									<td>
										@isset($lab_test_category[$lablist->lab_test_id])
											@foreach($lab_test_category[$lablist->lab_test_id] as $category)
												<img src="{{ env('Image_url') }}/{{ $category->lc_category_image }}" style="width:20px;height:20px;"><br><br>
											@endforeach
										@endisset
									</td>
									<td>
										<img src="{{ env('Image_url') }}/{{ $lablist->lab_test_img }}" style="width:20px;height:20px;">
									</td>
									<td>
										@isset($lab_test_prices[$lablist->lab_test_id])
											@foreach($lab_test_prices[$lablist->lab_test_id] as $price)
												<p>₹ {{ $price->lt_price }}</p>
											@endforeach
										@endisset
									</td>
									<td>
										@isset($lab_test_prices[$lablist->lab_test_id])
											@foreach($lab_test_prices[$lablist->lab_test_id] as $price)
												<p>₹ {{ $price->lt_offer_price }}</p>
											@endforeach
										@endisset
									</td>
									<td>{{$lablist->lt_lab_test_rating}} ★</td>

                        <td class="action__btn lbtn-group">
                            <button wire:navigate href="{{route('labTestDetail',['testId' => Crypt::encrypt($lablist->lab_test_id)])}}" class="btn-success"><i class="fa fa-eye fa-sm"></i></button>
                            <button wire:confirm="Are you sure you want to delete this Test Data ?" class="btn-danger"><i class="fa fa-trash fa-sm"></i></button>
                            <button wire:navigate href="#" class="btn-primary"><i class="fa fa-edit"></i></button>

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
                   {{ $lab_test_data->links(data: ['scrollTo' => '#paginated-posts']) }}
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