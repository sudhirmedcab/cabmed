

<?php
    $createdMapper['0'] = "Self";
    $createdMapper['1'] = "Partner";

    $relationMapper['0'] = "Self";
    $relationMapper['1'] = "Spouse";
    $relationMapper['2'] = "Sister";
    $relationMapper['3'] = "Brother";
    $relationMapper['4'] = "Daughter";
    $relationMapper['5'] = "Other";

    ?>


<style>
        .modal-dialog-centered {
        display: flex;
        align-items: center;
        min-height: calc(100% - 1rem);
        }

        #fullImage {
        width: 100%;
        height: auto;
        }

 </style>

<div class="content">
    <div class="container-fluid">
    @if(!empty($hospitalDetails))
        <div class="card my-2  text-center">
            <div class="card-header custom__driver__filter">
                <ul class="nav nav-tabs custom__nav__tab  card-header-tabs">

                <li  class="nav-item {{ Request::is('hospital_details/*/details') ? 'active' : '' }}">
                    <a  wire:navigate href="{{route('hospital-details',['hospitalId' => Crypt::encrypt($hospitalDetails->hospital_id),'Details'=>'details'])}}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('partner_details')">
                    Hospital & Owner Details
                    </a>
                </li>

                <li class="nav-item {{ Request::is('hospital_details/*/mapDetails') ? 'active' : '' }}">
                    <a wire:navigate href="{{route('hospital-details',['hospitalId' => Crypt::encrypt($hospitalDetails->hospital_id),'Details'=>'mapDetails'])}}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('mapDetails')">
                        Hospital Location In Map
                    </a>
                </li>
                <li class="nav-item {{ Request::is('hospital_details/*/hospitalService') ? 'active' : '' }}">
                    <a wire:navigate href="{{route('hospital-details',['hospitalId' => Crypt::encrypt($hospitalDetails->hospital_id),'Details'=>'hospitalService'])}}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('hospitalService')">
                        Hospital Services
                    </a>
                </li>
           
            </ul>
            </div>
        </div>

        @if($isOpen)
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

        <div class="custom__driver__detail__section card px-3">
            <table class="table m-0 table-sm custom__table table-bordered mt-3 mb-2">
                <th>Verification</th>
                <th>@if(!empty($hospitalDetails->hospital_status==1))Active @elseif($hospitalDetails->hospital_status==0) New @elseif($hospitalDetails->hospital_status=='2') Inactive  @else @endif</th>
            </table>
            <div class="row p-0">
                <div class="col-12 col-md-12 px-0">
                    <div class=" pl-3 py-2">
                        <table class="table m-0 custom__table table-bordered">
                            <tr>
                                <td>Name</td>
                                <td>{{$hospitalDetails->hospital_name}}</td>
                            </tr>
                            <tr>
                                <td>Mobile Number</td>
                                <td>{{$hospitalDetails->hospital_contact_no}} </td>
                            </tr>
                            <tr>
                                <td>Logo</td>
                                <td><a class="thumbnail" src="{{env('HospitalUrl2')}}/{{$hospitalDetails->hospital_logo}}" alt="" style="height:100px;width:100px;">View Profile</td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td>@if(!empty($hospitalDetails->hospital_address)){{$hospitalDetails->hospital_address}} @else N/A @endif</td>

                            </tr>
                            <tr>
                                <td>Hospital Services 24*7 Available</td>
                                <td>{{ ($hospitalDetails->hospital_service_status == "0") ? "Yes" :"No" }}</td>
                            </tr>
                           
                            <tr>
                                <td>City, State</td>
                                <td>{{$hospitalDetails->city_name}}</td>
                            </tr>
                       
                           
                            <tr>
                                <td>user Name</td>
                                <td>{{$hospitalDetails->hospital_users_name}}</td>
                            </tr>
                            <tr>
                                <td>Mobile Number</td>
                                <td>{{$hospitalDetails->hospital_users_mobile}} </td>
                            </tr>
                            <tr>
                                <td>Profile Image</td>
                                <td><a class="thumbnail" src="{{env('HospitalUrl2')}}{{$hospitalDetails->hospital_users_profile_image}}" alt="" style="height:100px;width:100px;">View Profile</td>
                            </tr>
                            <tr>
                                <td>Adhar Font</td>
                                <td><a class="thumbnail" src="{{env('HospitalUrl2')}}{{$hospitalDetails->hospital_users_aadhar_front}}" alt="" style="height:100px;width:100px;">View Profile</td>
                            </tr>
                            <tr>
                                <td>Adhar Back</td>
                                <td><a class="thumbnail" src="{{env('HospitalUrl2')}}{{$hospitalDetails->hospital_users_aadhar_back}}" alt="" style="height:100px;width:100px;">View Profile</td>
                            </tr>
                            <tr>
                                <td>Adhar No</td>
                                <td>{{$hospitalDetails->hospital_users_aadhar_no}}</td>

                            </tr>
                            <tr>
                                <td>Activation Status</td>
                                <td>{{ ($hospitalDetails->hospital_users_status == "0") ? "Active" :"Inactive" }}</td>
                            </tr>
                           
                            <tr>
                                <td>Registred Date</td>
                                <td>{{date('j F Y,h:i A',$hospitalDetails->hospital_users_reg_time_unix)}}</td>
                            </tr>
                         
                          
                        </table>
                    </div>
                </div>
                <div class="col-12 col-md-12 px-0">
                  <div class=" pl-3 py-2 mb-4">
                   
                    </div>
                </div>
            </div>

 <!---- popup model  for images codes start--->
        <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                        <div class="modal-body">
                            <img id="fullImage" src="" alt="Full Image">
                        </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-danger" id="cancelButton">Cancel</button>
                        </div>
                        </div>
                    </div>
             </div>
              <!---- popup model  for images codes start--->
              
        </div>
        @endif

        @if(!empty($this->Details == 'hospitalService'))
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

        <div class="card my-2  text-center">
            <div class="card-header custom__driver__filter">
                <ul class="nav nav-tabs custom__nav__tab  card-header-tabs">

                <li  class="nav-item {{ Request::is('hospital_details/*/details') ? 'active' : '' }}">
                    <a  wire:navigate href="{{route('hospital-details',['hospitalId' => Crypt::encrypt($hospitalData->hospital_id),'Details'=>'details'])}}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('partner_details')">
                    Hospital & Owner Details
                    </a>
                </li>

                

            <li class="nav-item {{ Request::is('hospital_details/*/mapDetails') ? 'active' : '' }}">
                <a wire:navigate href="{{route('hospital-details',['hospitalId' => Crypt::encrypt($hospitalData->hospital_id),'Details'=>'mapDetails'])}}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('mapDetails')">
                    Hospital Location In Map
                </a>
            </li>
            <li class="nav-item {{ Request::is('hospital_details/*/hospitalService') ? 'active' : '' }}">
                <a wire:navigate href="{{route('hospital-details',['hospitalId' => Crypt::encrypt($hospitalData->hospital_id),'Details'=>'hospitalService'])}}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('hospitalService')">
                    Hospital Services
                </a>
            </li>
           
            </ul>
            </div>
        </div>

        <div class="card mt-2 custom__filter__responsive">
            <div class="card-header custom__filter__select">

            </div>

            <!-- <table class="table table-bordered table-sm table-responsive-sm mt-2"> -->
            <div wire:loading.remove wire:target="filterCondition" class="card-body p-2 overflow-auto">
                <table class="table custom__table table-bordered table-sm">
                    <tr>
                        <th>Sr.</th>
                        <th>Added</th>
                        <th>Category Name</th>
                        <th>Category Image</th>
                        <th>Total Availability</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>

                    @php
                    $srno = 1
                    @endphp @if(!empty($hospitalService))
                    @foreach($hospitalService as $list)
                    <tr>
                        <td>{{ $srno }}</td>
                        <td>{{date('j F Y,h:i A',$list->hospital_available_serv_added_time_unix)}}</td>
                        <td>{{$list->hospital_serv_cat_name}}</td>
                        <td><img src="{{env('HospitalUrl2')}}{{$list->hospital_serv_cat_icon}}" alt="{{$list->hospital_serv_cat_name}}" style="width:20px;height:20px;"></td>
                        <td>{{$list->hospital_available_serv_av_qt}}</td>
                        <td>{{ ($list->hospital_available_serv_av_status == "Av") ? "Available" :"Not Available" }}</td>

                         <td class="action__btn lbtn-group">
                             <button wire:navigate href="#" class="btn-success"><i class="fa fa-eye fa-sm"></i></button>
                            <button wire:confirm="Are you sure you want to delete this Consumer Enquiry ?" class="btn-danger"><i class="fa fa-trash fa-sm"></i></button>
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
                {{$hospitalService->links()}}
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
        @if(!empty($this->Details == 'mapDetails'))
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

        <div class="card my-2  text-center">
            <div class="card-header custom__driver__filter">
                <ul class="nav nav-tabs custom__nav__tab  card-header-tabs">

                <li  class="nav-item {{ Request::is('hospital_details/*/details') ? 'active' : '' }}">
                    <a  wire:navigate href="{{route('hospital-details',['hospitalId' => Crypt::encrypt($hospitalData->hospital_id),'Details'=>'details'])}}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('partner_details')">
                    Hospital & Owner Details
                    </a>
                </li>

                

            <li class="nav-item {{ Request::is('hospital_details/*/mapDetails') ? 'active' : '' }}">
                <a wire:navigate href="{{route('hospital-details',['hospitalId' => Crypt::encrypt($hospitalData->hospital_id),'Details'=>'mapDetails'])}}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('mapDetails')">
                    Hospital Location In Map
                </a>
            </li>
            <li class="nav-item {{ Request::is('hospital_details/*/hospitalService') ? 'active' : '' }}">
                <a wire:navigate href="{{route('hospital-details',['hospitalId' => Crypt::encrypt($hospitalData->hospital_id),'Details'=>'hospitalService'])}}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('hospitalService')">
                    Hospital Services
                </a>
            </li>
           
            </ul>
            </div>
        </div>

        <div class="card mt-2 custom__filter__responsive">
            <div class="card-header custom__filter__select">

            </div>

            <!-- <table class="table table-bordered table-sm table-responsive-sm mt-2"> -->
            <div wire:loading.remove wire:target="filterCondition" class="card-body p-2 overflow-auto">
                <table class="table custom__table table-bordered table-sm">
                <div class="container mt-5">
                                              <div id="map"></div><br>
                                      </div>

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
   
        
     @endif
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Initialize the plugin: -->
<script type="text/javascript">

    $('.thumbnail').click(function() {
        var src = $(this).attr('src');
        $('#fullImage').attr('src', src);
        $('#imageModal').modal('show');
    });

    $('#cancelButton').click(function() {
        $('#imageModal').modal('hide');
        // Additional actions to clear or reset the selection if needed
    });
</script>







