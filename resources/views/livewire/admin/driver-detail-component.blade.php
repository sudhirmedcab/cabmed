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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
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
        <div class="card my-2  text-center">
            <div class="card-header custom__driver__filter">
                <ul class="nav nav-tabs custom__nav__tab  card-header-tabs">

                <li  class="nav-item {{ Request::is('driver-detail/*') ? 'active' : '' }}">
                    <a  wire:navigate href="{{route('admin.driver-details-component',['driverId' => Crypt::encrypt($driver_details->driver_id)])}}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('driver_details')">
                    Details
                    </a>
                </li>
                <li  class="nav-item {{ Request::is('driver-booking-details/*/0') ? 'active' : '' }}">
                    <a wire:navigate href="{{route('admin.driver-booking-component',['driverId' => Crypt::encrypt($driver_details->driver_id),'booking_status'=> '0'])}}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('Enquiry')">
                    Enquiry
                    </a>
                </li>
                <li  class="nav-item {{ Request::is('driver-booking-details/*/1') ? 'active' : '' }}">
                    <a wire:navigate href="{{route('admin.driver-booking-component',['driverId' => Crypt::encrypt($driver_details->driver_id),'booking_status'=> '1'])}}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('New')">
                    New
                    </a>
                </li>
                <li  class="nav-item {{ Request::is('driver-booking-details/*/2') ? 'active' : '' }}">
                    <a wire:navigate href="{{route('admin.driver-booking-component',['driverId' => Crypt::encrypt($driver_details->driver_id),'booking_status'=> '2'])}}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('Ongoing')">
                    Ongoing
                    </a>
                </li>
                <li  class="nav-item {{ Request::is('driver-booking-details/*/3') ? 'active' : '' }}">
                    <a wire:navigate href="{{route('admin.driver-booking-component',['driverId' => Crypt::encrypt($driver_details->driver_id),'booking_status'=> '3'])}}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('Invoice')">
                    Invoice
                    </a>
                </li>
                <li  class="nav-item {{ Request::is('driver-booking-details/*/4') ? 'active' : '' }}">
                    <a wire:navigate href="{{route('admin.driver-booking-component',['driverId' => Crypt::encrypt($driver_details->driver_id),'booking_status'=> '4'])}}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('Complete')">
                    Complete
                    </a>
                </li>
                <li  class="nav-item {{ Request::is('driver-booking-details/*/5') ? 'active' : '' }}">
                    <a wire:navigate href="{{route('admin.driver-booking-component',['driverId' => Crypt::encrypt($driver_details->driver_id),'booking_status'=> '5'])}}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('Cancel')">
                    Cancel
                    </a>
                </li>
                <li class="nav-item {{ Request::is('driver-booking-details/*/transaction') ? 'active' : '' }}">
                    <a wire:navigate href="{{route('admin.driver-booking-component',['driverId' => Crypt::encrypt($driver_details->driver_id),'booking_status'=> 'transaction'])}}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('Transaction')">
                    Transaction
                    </a>
                </li>
                <li class="nav-item {{ Request::is('driver-booking-details/*/map') ? 'active' : '' }}">
                    <a wire:navigate href="{{route('admin.driver-booking-component',['driverId' => Crypt::encrypt($driver_details->driver_id),'booking_status'=> 'map'])}}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('Map')">
                    Map View
                    </a>
                </li>

                </ul>
            </div>
        </div>

        <div class="custom__driver__detail__section card px-3">
            <table class="table m-0 table-sm custom__table table-bordered mt-3 mb-2">
                <th>Type - {{$createdMapper[$driver_details->driver_created_by]}}</th>
                <th>Verification</th>
                <th>@if(!empty($driver_details->driver_status==1))Active @elseif($driver_details->driver_status==0) New @elseif($driver_details->driver_status=='4') Applied @else FRC @endif</th>
            </table>
            <div class="row p-0">
                <div class="col-12 col-md-6 px-0">
                    <div class=" pl-3 py-2">
                        <table class="table m-0 custom__table table-bordered">
                            <tr>
                                <td>Name</td>
                                <td>{{$driver_details->driver_name.' '.$driver_details->driver_last_name}}</td>
                            </tr>
                            <tr>
                                <td>Mobile Number</td>
                                <td>{{$driver_details->driver_mobile}} </td>
                            </tr>
                            <tr>
                                <td>Profile</td>
                                <td><a class="thumbnail" src="{{env('Image_url')}}/{{$driver_details->driver_profile_img}}" alt="" style="height:100px;width:100px;">View Profile</td>
                            </tr>
                            <tr>
                                <td>DOB</td>
                                <td>@if(!empty($driver_details->driver_dob)){{$driver_details->driver_dob}} @else N/A @endif</td>
                            </tr>
                            <tr>
                                <td>Gender</td>
                                <td>{{$driver_details->driver_gender}}</td>
                            </tr>
                            <tr>
                                <td>City, State</td>
                                <td>{{$driver_details->city_name.' ,'.$driver_details->state_name}}</td>
                            </tr>
                            <tr>
                                <td>Aadhaar Front</td>
                                <td><a class="thumbnail" src="{{env('Image_url')}}/{{$driver_details->driver_details_aadhar_front_img}}" alt="" style="height:100px;width:100px;">View Aadhaar Front Image</a></td>
                            </tr>
                            <tr>
                                <td>Aadhaar Back</td>
                                <td><a class="thumbnail" src="{{env('Image_url')}}/{{$driver_details->driver_details_aadhar_back_img}}" alt="" style="height:100px;width:100px;">View Aadhaar Back Image</a></td>
                            </tr>
                            <tr>
                                <td>Aadhaar Number</td>
                                <td>@if(!empty($driver_details->driver_details_aadhar_number)){{$driver_details->driver_details_aadhar_number}} @else N/A @endif</td>
                            </tr>
                            <tr>
                                <td>PAN Image</td>
                                <td><a class="thumbnail" src="{{env('Image_url')}}/{{$driver_details->driver_details_pan_card_front_img}}" alt="" style="height:100px;width:100px;">View PAN Image</a></td>
                            </tr>
                            <tr>
                                <td>PAN Number</td>
                                <td>@if(!empty($driver_details->driver_details_pan_card_number)){{$driver_details->driver_details_pan_card_number}} @else N/A @endif</td>
                              </tr>
                            <tr>
                                <td>Police Verification Image</td>
                                <td><a class="thumbnail" src="{{env('Image_url')}}/{{$driver_details->driver_details_police_verification_image}}" alt="" style="height:100px;width:100px;">View Police Verification</a></td>
                            </tr>
                            <tr>
                                <td>Police Verification Expiry</td>
                                <td>@if(!empty($driver_details->driver_details_police_verification_date)){{$driver_details->driver_details_police_verification_date}} @else N/A @endif</td>
                            </tr>
                            <tr>
                                <td>DL Front</td>
                                <td><a class="thumbnail" src="{{env('Image_url')}}/{{$driver_details->driver_details_dl_front_img}}" alt="" style="height:100px;width:100px;">View DL Font Image</a></td>
                            </tr>
                            <tr>
                                <td>DL Back</td>
                                <td><a class="thumbnail" src="{{env('Image_url')}}/{{$driver_details->driver_details_dl_back_image}}" alt="" style="height:100px;width:100px;">View DL Back Image</a></td>
                            </tr>
                            <tr>
                                <td>DL Number</td>
                                <td>@if(!empty($driver_details->driver_details_dl_number)){{$driver_details->driver_details_dl_number}} @else N/A @endif</td>

                            </tr>
                        </table>
                    </div>
                </div>
                <div class="col-12 col-md-6 px-0">
                    <div class=" pr-3 py-2">
                        <table class="table m-0 custom__table table-bordered">
                            <tr>
                                <td>DL Expiry</td>
                                <td>@if(!empty($driver_details->driver_details_dl_exp_date)){{$driver_details->driver_details_dl_exp_date}} @else N/A @endif</td>
                            </tr>
                            <tr>
                                <td>Ambulane Front</td>
                                <td><a class="thumbnail" src="{{env('Image_url')}}/{{$driver_details->vehicle_front_image}}" alt="" style="height:100px;width:100px;">View Ambulane Front Image</a></td>
                            </tr>
                            <tr>
                                <td>Ambulance Back</td>
                                <td><a class="thumbnail" src="{{env('Image_url')}}/{{$driver_details->vehicle_back_image}}" alt="" style="height:100px;width:100px;">View Ambulance Back Image</a></td>
                            </tr>
                            <tr>
                                <td>Category</td>
                                <td>@if(!empty($driver_details->ambulance_category_name)){{$driver_details->ambulance_category_name}} @else N/A @endif</td>
                            </tr>
                            <tr>
                                <td>Facilities</td>
                                <td>@if(!empty($driver_details->ambulance_category_type))
                                @php 
                                    $i='a';
                                 @endphp
                                    
                                    @foreach($ambulanceKit as $kit)

                                   ({{$i}})
                                    {{ nl2br(e($kit->ambulance_facilities_name)) }}
                                    @php $i++ @endphp
                                    @endforeach
                                    @else N/A @endif
                                </td>
                            </tr>
                            <tr>
                                <td>RC Image</td>
                                <td><a class="thumbnail" src="{{env('Image_url')}}/{{$driver_details->vehicle_rc_image}}" alt="" style="height:100px;width:100px;">View RC Image</a></td>
                            </tr>
                            <tr>
                                <td>RC Number</td>
                                <td>@if(!empty($driver_details->vehicle_rc_number)){{$driver_details->vehicle_rc_number}} @else N/A @endif</td>
                            </tr>
                            <tr>
                                <td>RC Expiry</td>
                                <td>@if(!empty($driver_details->vehicle_exp_date)){{$driver_details->vehicle_exp_date}} @else N/A @endif</td>
                            </tr>
                            <tr>
                                <td>Fitness Image</td>
                                <td><a class="thumbnail" src="{{env('Image_url')}}/{{$driver_details->vehicle_details_fitness_certi_img}}" alt="" style="height:100px;width:100px;">View Fitness Image</a></td>
                            </tr>
                            <tr>
                                <td>Fitness Expiry</td>
                                <td>@if(!empty($driver_details->vehicle_details_fitness_exp_date)){{$driver_details->vehicle_details_fitness_exp_date}} @else N/A @endif</td>
                            </tr>
                            <tr>
                                <td>Insurance Image</td>
                                <td><a class="thumbnail" src="{{env('Image_url')}}/{{$driver_details->vehicle_details_insurance_img}}" alt="" style="height:100px;width:100px;">View Insurance Image</a></td>
                            </tr>
                            <tr>
                                <td>Insurance Expiry</td>
                                <td>@if(!empty($driver_details->vehicle_details_insurance_exp_date)){{$driver_details->vehicle_details_insurance_exp_date}} @else N/A @endif</td>
                            </tr>
                            <tr>
                                <td>Insurance Holder Name</td>
                                <td>@if(!empty($driver_details->vehicle_details_insurance_holder_name)){{$driver_details->vehicle_details_insurance_holder_name}} @else N/A @endif</td>
                            </tr>
                            <tr>
                                <td>Pollution Image</td>
                                <td><a class="thumbnail" src="{{env('Image_url')}}/{{$driver_details->vehicle_details_pollution_img}}" alt="" style="height:100px;width:100px;">View Pollution Image</a></td>
                            </tr>
                            <tr>
                                <td>Pollution Expiry</td>
                                <td>@if(!empty($driver_details->vehicle_details_pollution_exp_date)){{$driver_details->vehicle_details_pollution_exp_date}} @else N/A @endif</td>
                            </tr>
                            <tr>
                                <td>Partner Name & Number</td>
                                <td>@if(!empty($driver_details->partner_f_name)){{$driver_details->partner_f_name.' '.$driver_details->partner_l_name.' ,'.$driver_details->partner_mobile}} @else N/A @endif</td>
                            </tr>
                        </table>
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


