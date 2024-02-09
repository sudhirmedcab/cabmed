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

                <li  class="nav-item {{ Request::is('partner-detail/*') ? 'active' : '' }}">
                    <a  wire:navigate href="{{route('partner-details-component',['partnerId' => Crypt::encrypt($partner->partner_id)])}}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('partner_details')">
                    Partner Details
                    </a>
                </li>

            <li class="nav-item {{ Request::is('partner-details/*/driver') ? 'active' : '' }}">
                <a wire:navigate href="{{ route('partner-details-list-component', ['partnerId' => Crypt::encrypt($partner->partner_id), 'detailList' => 'driver']) }}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('driver')">
                    Driver Details
                </a>
            </li>
                <li class="nav-item {{ Request::is('partner-details/*/vehicle') ? 'active' : '' }}">
                <a wire:navigate href="{{ route('partner-details-list-component', ['partnerId' => Crypt::encrypt($partner->partner_id), 'detailList' => 'vehicle']) }}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('vehicle')">
                    Vehicle Details
                </a>
            </li>
                <li class="nav-item {{ Request::is('partner-details/*/transaction') ? 'active' : '' }}">
                <a wire:navigate href="{{ route('partner-details-list-component', ['partnerId' => Crypt::encrypt($partner->partner_id), 'detailList' => 'transaction']) }}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('transaction')">
                    Transaction Details
                </a>
            </li>
                <li class="nav-item {{ Request::is('partner-details/*/assign') ? 'active' : '' }}">
                <a wire:navigate href="{{ route('partner-details-list-component', ['partnerId' => Crypt::encrypt($partner->partner_id), 'detailList' => 'assign']) }}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('assign')">
                    Assign Page
                </a>
            </li>
                <li class="nav-item {{ Request::is('partner-details/*/refferal') ? 'active' : '' }}">
                <a wire:navigate href="{{ route('partner-details-list-component', ['partnerId' => Crypt::encrypt($partner->partner_id), 'detailList' => 'refferal']) }}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('refferal')">
                    Refferal Details
                </a>
            </li>

            </ul>
            </div>
        </div>

        <div class="custom__driver__detail__section card px-3">
            <table class="table m-0 table-sm custom__table table-bordered mt-3 mb-2">
                <th>Verification</th>
                <th>@if(!empty($partner->partner_status==1))Active @elseif($partner->partner_status==0) New @elseif($partner->partner_status=='2') Inactive  @else @endif</th>
            </table>
            <div class="row p-0">
                <div class="col-12 col-md-12 px-0">
                    <div class=" pl-3 py-2">
                        <table class="table m-0 custom__table table-bordered">
                            <tr>
                                <td>Name</td>
                                <td>{{$partner->partner_f_name.' '.$partner->partner_l_name}}</td>
                            </tr>
                            <tr>
                                <td>Mobile Number</td>
                                <td>{{$partner->partner_mobile}} </td>
                            </tr>
                            <tr>
                                <td>Profile</td>
                                <td><a class="thumbnail" src="{{env('Image_url')}}/{{$partner->partner_profile_img}}" alt="" style="height:100px;width:100px;">View Profile</td>
                            </tr>
                            <tr>
                                <td>DOB</td>
                                <td>@if(!empty($partner->partner_dob)){{$partner->partner_dob}} @else N/A @endif</td>
                            </tr>
                            <tr>
                                <td>Gender</td>
                                <td>{{$partner->partner_gender}}</td>
                            </tr>
                            <tr>
                                <td>City, State</td>
                                <td>{{$partner->city_name.' ,'.$partner->state_name}}</td>
                            </tr>
                            <tr>
                                <td>Aadhaar Front</td>
                                <td><a class="thumbnail" src="{{env('Image_url')}}/{{$partner->partner_aadhar_front}}" alt="" style="height:100px;width:100px;">View Aadhaar Front Image</a></td>
                            </tr>
                            <tr>
                                <td>Aadhaar Back</td>
                                <td><a class="thumbnail" src="{{env('Image_url')}}/{{$partner->partner_aadhar_back}}" alt="" style="height:100px;width:100px;">View Aadhaar Back Image</a></td>
                            </tr>
                            <tr>
                                <td>Aadhaar Number</td>
                                <td>@if(!empty($partner->partner_aadhar_no)){{$partner->partner_aadhar_no}} @else N/A @endif</td>
                            </tr>
                            <tr>
                                <td>Refferal</td>
                                <td>@if(!empty($partner->partner_referral)){{$partner->partner_referral}} @else N/A @endif</td>
                            </tr>
                            <tr>
                                <td>Refferal By</td>
                                <td>@if(!empty($partner->referral_referral_by)){{$partner->referral_referral_by}} @else N/A @endif</td>
                            </tr>
                            <tr>
                                <td>Created At</td>
                                <td>@if(!empty($partner->created_at))  {{ date("j F, Y h:i A", strtotime($partner->created_at))}} @else N/A @endif</td>
                            </tr>
                          
                        </table>
                    </div>
                </div>
                <div class="col-12 col-md-6 px-0">
                    <div class=" pr-3 py-2">
                       
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

