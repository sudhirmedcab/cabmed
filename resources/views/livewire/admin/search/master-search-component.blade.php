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

        <div class="card mt-2 custom__filter__responsive">
            <div class="card-header custom__filter__select">

                <div class="row">
                   
                    <div class="col-4">
                        <div class="form-group">
                            <label class="custom__label" for="toDate">Candidate Name</label>
                            <input type="search" wire:model.live.debounce.150ms="candidateName" class="custom__input__field form-control rounded-0 form-control-sm float-right" placeholder="Enter The Candidate Name......">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="custom__label" for="toDate">Candidate Number</label>
                            <input type="search" wire:model.live.debounce.150ms="candidateNumber" class="custom__input__field form-control rounded-0 form-control-sm float-right" placeholder="Enter The Candidate Number...">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="custom__label" for="toDate">Candidate Rc No</label>
                            <input type="search" wire:model.live.debounce.150ms="vehiclercNumber" class="custom__input__field form-control rounded-0 form-control-sm float-right" placeholder="Enter The Vehicle Rc Number....">
                        </div>
                    </div>
                 

                </div>

            </div>

            @php 

            $driverStatusMapper['0'] = "New Driver";
            $driverStatusMapper['1'] = "Active Driver";
            $driverStatusMapper['2'] = "Inactive Driver";
            $driverStatusMapper['3'] = "Deleted Driver";
            $driverStatusMapper['4'] = "Applied Driver";

            $consumerStatusMapper['0'] = "New Consumer";
            $consumerStatusMapper['1'] = "Active Consumer";
            $consumerStatusMapper['2'] = "Inactive Consumer";
            $consumerStatusMapper['3'] = "Deleted Consumer";
            $consumerStatusMapper['4'] = "Applied Consumer";

            $partnerStatusMapper['0'] = "New Partner";
            $partnerStatusMapper['1'] = "Active Partner";
            $partnerStatusMapper['2'] = "Inactive Partner";
            $partnerStatusMapper['3'] = "Deleted Partner";
            $partnerStatusMapper['4'] = "Applied Partner";

            $vehicleStatusMapper['0'] = "New Vehicle";
            $vehicleStatusMapper['1'] = "Active Vehicle";
            $vehicleStatusMapper['2'] = "Inactive Vehicle";
            $vehicleStatusMapper['3'] = "Deleted Vehicle";
            $vehicleStatusMapper['4'] = "Applied Vehicle";

            $hospitalStatusMapper['1'] = "Verified";
            $hospitalStatusMapper['0'] = "Unverified";

            $hospitalOwnerStatusMapper['1'] = "Unverified";
            $hospitalOwnerStatusMapper['0'] = "verified";

            $pathologyStatusMapper['3'] = "New Lab Owner";
            $pathologyStatusMapper['6'] = "Active Lab Owner";
            $pathologyStatusMapper['5'] = "Inactive Lab Owner";
            $pathologyStatusMapper['4'] = "New Lab Owner";

            $CollectionStatusMapper['1'] = "Inactive";
            $CollectionStatusMapper['0'] = "Active";

            @endphp

            <!-- <table class="table table-bordered table-sm table-responsive-sm mt-2"> -->
            <div wire:loading.remove wire:target="filterCondition" class="card-body p-2 overflow-auto">
                <table class="table custom__table table-bordered table-sm">
                    <tr>
                        <th>Sr.</th>
                        <th>Id</th>
                        <th>Candidate Name</th>
                        <th>Candidate Number</th>
                        <th>Candidate Services</th>
                        <th>Candidate Status</th>
                        <th>Action</th>
                    </tr>

                    @php
                    $srno = 1
                    @endphp
                    
                    @if(!empty($allData))

                    @foreach($allData['driverData'] as $driver)
                    <tr>
                        <td>{{ $srno }}</td>
                        <td>{{ $driver->driver_id }}</td>
                        <td>{{$driver->driver_name.' '.$driver->driver_last_name}}</td>
                        <td>{{$driver->driver_mobile}}</td>
                        <td>Driver</td>
                        <td>{{$driverStatusMapper[$driver->driver_status]}}</td>       
                         <td class="action__btn lbtn-group">
                           <button  wire:navigate href="{{route('admin.driver-details-component',['driverId' => Crypt::encrypt($driver->driver_id)])}}" class="btn-success"><i class="fa fa-eye"></i></button>
                        </td>
                    </tr>
                    @php
                    $srno++
                    @endphp
                    @endforeach

                    @foreach($allData['consumerData'] as $consumer)
                    <tr>
                        <td>{{ $srno }}</td>
                        <td>{{ $consumer->consumer_id }}</td>
                        <td>{{$consumer->consumer_name}}</td>
                        <td>{{$consumer->consumer_mobile_no}}</td>
                        <td>Consumer</td>
                        <td>{{$consumerStatusMapper[$consumer->consumer_status]}}</td>       
                         <td class="action__btn lbtn-group">
                           <button  wire:navigate href="{{route('consumer-details',['consumerId' => Crypt::encrypt($consumer->consumer_id)])}}" class="btn-success"><i class="fa fa-eye"></i></button>
                        </td>
                    </tr>
                    @php
                    $srno++
                    @endphp
                    @endforeach

                    @foreach($allData['partnerData'] as $partner)
                    <tr>
                        <td>{{ $srno }}</td>
                        <td>{{ $partner->partner_id }}</td>
                        <td>{{$partner->partner_f_name.' '.$partner->partner_l_name}}</td>
                        <td>{{$partner->partner_mobile}}</td>
                        <td> Partner</td>
                        <td>{{$partnerStatusMapper[$partner->partner_status]}}</td>       
                         <td class="action__btn lbtn-group">
                           <button  wire:navigate href="{{route('partner-details-component',['partnerId' => Crypt::encrypt($partner->partner_id)])}}" class="btn-success"><i class="fa fa-eye"></i></button>
                        </td>
                    </tr>
                    @php
                    $srno++
                    @endphp
                    @endforeach
                    
                    @foreach($allData['HospitalData'] as $hospital)
                    <tr>
                        <td>{{ $srno }}</td>
                        <td>{{ $hospital->hospital_id }}</td>
                        <td>{{$hospital->hospital_name}}</td>
                        <td>{{$hospital->hospital_contact_no}}</td>
                        <td>Hospital</td>
                        <td>{{$hospitalStatusMapper[$hospital->hospital_status]}}</td>       
                              
                         <td class="action__btn lbtn-group">
                           <button  wire:navigate href="{{route('hospital-details',['hospitalId' => Crypt::encrypt($hospital->hospital_id),'Details'=>'details'])}}" class="btn-success"><i class="fa fa-eye"></i></button>
                        </td>
                    </tr>
                    @php
                    $srno++
                    @endphp
                    @endforeach

                    @foreach($allData['HospitalUserData'] as $hospitalOwner)
                    <tr>
                        <td>{{ $srno }}</td>
                        <td>{{ $hospitalOwner->hospital_user_id }}</td>
                        <td>{{$hospitalOwner->hospital_users_name}}</td>
                        <td>{{$hospitalOwner->hospital_users_mobile}}</td>
                        <td>Hospital Owner</td>
                        <td>{{$hospitalOwnerStatusMapper[$hospitalOwner->hospital_users_status]}}</td>       
                         <td class="action__btn lbtn-group">
                           <button  wire:navigate href="{{route('hospital-details',['hospitalId' => Crypt::encrypt($hospitalOwner->hospital_id),'Details'=>'details'])}}" class="btn-success"><i class="fa fa-eye"></i></button>
                        </td>
                    </tr>
                    @php
                    $srno++
                    @endphp
                    @endforeach

                    @foreach($allData['VehicleData'] as $vehicle)
                    <tr>
                        <td>{{ $srno }}</td>
                        <td>{{ $vehicle->vehicle_id }}</td>
                        <td>{{$vehicle->ambulance_category_name}}</td>
                        <td>{{$vehicle->vehicle_rc_number}}</td>
                        <td>Vehicle</td>
                        <td>{{$vehicleStatusMapper[$vehicle->vehicle_status]}}</td>       
                         <td class="action__btn lbtn-group">
                            @if(!empty($vehicle->driver_id))
                           <button  wire:navigate href="{{route('admin.driver-details-component',['driverId' => Crypt::encrypt($vehicle->driver_id)])}}" class="btn-success"><i class="fa fa-eye"></i></button>
                           @else N/A @endif
                        </td>
                    </tr>
                    @php
                    $srno++
                    @endphp
                    @endforeach

                    @foreach($allData['PathologyData'] as $pathology)
                    <tr>
                        <td>{{ $srno }}</td>
                        <td>{{ $pathology->lab_owner_id }}</td>
                        <td>{{$pathology->lab_owner_name}}</td>
                        <td>{{$pathology->lab_owner_mobile_number}}</td>
                        <td>Pathology Owner</td>
                        <td>{{ ($pathology->lab_owner_status == '4' || $pathology->lab_owner_status == '3') ? 'New Lab Owner' : ($pathology->lab_owner_status == '5' ? 'Inactive' : 'Active') }}</td>      
                         <td class="action__btn lbtn-group">
                            @if(!empty($pathology->lab_owner_id))
                           <button  wire:navigate href="{{route('lab_details',['LabOwnerId' => Crypt::encrypt($pathology->lab_owner_id),'Details'=>'Details'])}}"  class="btn-success"><i class="fa fa-eye"></i></button>
                           @else N/A @endif
                        </td>
                    </tr>
                    @php
                    $srno++
                    @endphp
                    @endforeach

                    @foreach($allData['collectionBoyData'] as $collection)
                    <tr>
                        <td>{{ $srno }}</td>
                        <td>{{ $collection->collection_boy_id }}</td>
                        <td>{{$collection->collection_boy_name}}</td>
                        <td>{{$collection->collection_boy_number}}</td>
                        <td>Collection Boy</td>
                        <td>{{$CollectionStatusMapper[$collection->collection_boy_status]}}</td>       
                         <td class="action__btn lbtn-group">
                           <button  wire:navigate class="btn-success"><i class="fa fa-eye"></i></button>
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
    </div>
</div>