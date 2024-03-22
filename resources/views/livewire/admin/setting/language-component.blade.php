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

        @if ($isOpen)
        @include('livewire.admin.setting.add_language')
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

        <div class="card mt-2 custom__filter__responsive">
            <div class="card-header custom__filter__select">
                <div class="row">
                    <div class="col __col-4">
                        <div class="form-group">
                            <label class="custom__label">Select Status</label>

                            <select wire:model.live.debounce.150ms="verificationStatus" wire:mode.live="verificationStatus" class="custom__input__field custom-select rounded-0 form-control form-control-sm" id="verificationStatus">
                                <option selected value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                                <option value="All">All</option>
                            </select>
                        </div>
                    </div>
                  
                    <div class="col __col-4">
                        <div class="form-group">
                            <label class="custom__label" for="toDate">Search</label>
                            <input type="search" wire:model.live.debounce.150ms="search" class="custom__input__field form-control rounded-0 form-control-sm float-right" placeholder="Search">
                        </div>
                    </div>
                    <div class="col __col-4">
                    <div class="form-group">
                            <label class="custom__label">Language</label>
                            <button style="height:25px" class="w-100 mb-sm-2 mb-0 btn-primary btn rounded submit__btn d-flex align-items-center justify-content-center">
                                <a class="custom__label text-white" wire:click="createLanguage()"><i class="fa fa-plus"></i> Add</a>
                            </button>
                        </div>
                    </div>
                </div>

            </div>

            <!-- <table class="table table-bordered table-sm table-responsive-sm mt-2"> -->
            <div wire:loading.remove wire:target="verificationStatus" class="card-body p-2 overflow-auto">
                <table class="table custom__table table-bordered table-sm">
                    <tr>
                        <th>Sr.</th>
                        <th>Id</th>
                        <th>Symbol</th>
                        <th>Name</th>
                        <th>Name (In English)</th>
                        <th>Logo</th>
                        <th>Status</th>
                    </tr>

                    @php
                    $srno = 1;
                 
                    @endphp

                    @if(!empty($languageList))

                    @foreach ($languageList as $list)

                    <tr>
                        <td>{{ $srno }}</td>
                        <td>{{$list->language_id }}</td>
                        <td>{{$list->language_symbol }}</td>
                        <td>{{$list->language_name}}</td>
                        <td>{{$list->language_name_en}}</td>
                        <td><img src="{{ env('Image_url') . $list->language_icons }}" alt="{{ $list->language_name_en }}" style="width:25px;height:25px;" /></td>
                        <td>{{$list->language_status == '1' ? "Inactive" : "Active" }}</td>
                      
                    </tr>
                    @php
                    $srno++
                    @endphp
                    @endforeach
                    @endif

                </table>
                <!-- <span wire:loadingf wire:target="filterCondition">Loading...</span> -->
                <div class="custom__pagination mt-2 pt-1 card-footer__ clearfix">
                   {{ $languageList->links(data: ['scrollTo' => '#paginated-posts']) }}
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row" wire:loading wire:target="selectedDate,verificationStatus,filterCondition" wire:key="selectedDate,verificationStatus,filterCondition">
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