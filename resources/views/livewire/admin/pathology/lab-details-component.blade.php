

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
    @if(!empty($lab_data))
        <div class="card my-2  text-center">
            <div class="card-header custom__driver__filter">
                <ul class="nav nav-tabs custom__nav__tab  card-header-tabs">

                <li  class="nav-item {{ Request::is('lab_module/*/Details') || ($Details !=='Transaction') ? 'active' : '' }}">
                    <a  wire:navigate href="{{route('lab_details',['LabOwnerId' => Crypt::encrypt($lab_data->lab_owner_id),'Details'=>'details'])}}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('partner_details')">
                    Lab & Owner Details
                    </a>
                </li>

                <li class="nav-item {{ Request::is('lab_module/*/Transaction') || ($Details=='Transaction') ? 'active' : '' }}">
                    <a wire:navigate href="{{route('lab_details',['LabOwnerId' => Crypt::encrypt($lab_data->lab_owner_id),'Details'=>'Transaction'])}}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('hospitalService')">
                        Lab Transaction
                    </a>
                </li>
           
            </ul>
            </div>
        </div>

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
                <th>@if(!empty($lab_data->lab_owner_status== 6)) Verified @elseif($lab_data->lab_owner_status==5) Unverified @elseif($lab_data->lab_owner_status=='3' || '4') New  @else @endif</th>
            </table>
            <div class="row p-0">
                <div class="col-12 col-md-12 px-0">
                    <div class=" pl-3 py-2">
                        <table class="table m-0 custom__table table-bordered">
                            <tr>
                                <td>Name</td>
                                <td>{{$lab_data->lab_owner_name}}</td>
                            </tr>
                            <tr>
                                <td>Mobile Number</td>
                                <td>{{$lab_data->lab_owner_mobile_number}} </td>
                            </tr>
                            <tr>
                                <td>Logo</td>
                                <td><a class="thumbnail" src="{{env('pathology_url')}}/{{$lab_data->lab_owener_profile}}" alt="" style="height:100px;width:100px;">View Profile</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>@if(!empty($lab_data->lab_owner_email)){{$lab_data->lab_owner_email}} @else N/A @endif</td>

                            </tr>
                            <tr>
                                <td>Owner Registred date</td>
                                <td>{{date('j F Y,h:i A',$lab_data->lab_owner_added_time)}}</td>
                            </tr>
                           
                            <tr>
                                <td>City, State</td>
                                <td>{{$lab_data->city_name.' '.$lab_data->state_name}}</td>
                            </tr>
                       
                           
                            <tr>
                                <td>lab Name</td>
                                <td>{{$lab_data->lab_name}}</td>
                            </tr>
                            <tr>
                                <td>Mobile Number</td>
                                <td>{{$lab_data->lab_contact_no}} </td>
                            </tr>
                            <tr>
                                <td>Lab Logo</td>
                                <td><a class="thumbnail" src="{{env('pathology_url')}}{{$lab_data->lab_image}}" alt="" style="height:100px;width:100px;">View Profile</td>
                            </tr>
                          
                            <tr>
                                <td>Lab Services 24*7 Available</td>
                                <td>{{($lab_data->lab_service_status==0) ? "Yes" : "No"}}</td>

                            </tr>
                            <tr>
                                <td> Address</td>
                                <td>{{ $lab_data->lab_address}}</td>
                            </tr>
                           
                            <tr>
                                <td>Registred Date</td>
                                <td>{{date('j F Y,h:i A',$lab_data->lab_added_date)}}</td>
                            </tr>
                         
                            <tr>
                                <td>lab Pathologist</td>
                                <td>{{$lab_data->pathologist_name}}</td>
                            </tr>
                          
                            <tr>
                                <td>Licenece Image</td>
                                <td><a class="thumbnail" src="{{env('pathology_url')}}{{$lab_data->lab_licence_certificate_photo}}" alt="" style="height:100px;width:100px;">View Profile</td>
                            </tr>
                            <tr>
                                <td>MSI Image</td>
                                <td><a class="thumbnail" src="{{env('pathology_url')}}{{$lab_data->mci_certicate_photo}}" alt="" style="height:100px;width:100px;">View Profile</td>
                            </tr>
                          
                            <tr>
                                <td>Licence number</td>
                                <td>{{$lab_data->lab_licence_no}}</td>
                            </tr>
                            <tr>
                                <td>Lab Account number</td>
                                <td>{{$lab_data->account_no}} </td>
                            </tr>
                            <tr>
                                <td>Cancel Check</td>
                                <td><a class="thumbnail" src="{{env('pathology_url')}}{{$lab_data->cancel_check_image}}" alt="" style="height:100px;width:100px;">View Profile</td>
                            </tr>
                          
                            <tr>
                                <td>Account Holder Name</td>
                                <td>{{$lab_data->account_holder_name}} </td>
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

        @if(!empty($this->Details == 'Transaction'))
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

        <div class="card my-2  text-center">
            <div class="card-header custom__driver__filter">
                <ul class="nav nav-tabs custom__nav__tab  card-header-tabs">

                <li  class="nav-item {{ Request::is('lab_module/*/Details') || ($Details !=='Transaction') ? 'active' : '' }}">
                    <a  wire:navigate href="{{route('lab_details',['LabOwnerId' => Crypt::encrypt($getlabId->lab_owner_by),'Details'=>'details'])}}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('partner_details')">
                    Lab & Owner Details
                    </a>
                </li>

                <li class="nav-item {{ Request::is('lab_module/*/Transaction') || ($Details=='Transaction') ? 'active' : '' }}">
                    <a wire:navigate href="{{route('lab_details',['LabOwnerId' => Crypt::encrypt($getlabId->lab_owner_by),'Details'=>'Transaction'])}}" class="custom__nav__btn nav-link fs-1" wire:click="filterCondition('hospitalService')">
                        Lab Transaction
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
                              <th>Sr.NO.</th>
							  <th>Transaction ID</th>
							  <th>Order ID</th>
							  <th>Transaction date</th>
							  <th>Customer & Test Name</th>
							  <th>Transaction Type</th>
                              <th>Transaction Status</th>
                              <th>Transaction Amount</th>
                              <th>Transaction Percentage</th>
							  <th>Transaction Company Amount</th>
							  <th>Lab Amount</th>
							  <th>Lab Old Amount</th>
							  <th>Lab New Amount</th>
                              <th>Action</th>
						</tr>

                        @php
                        $srno = 1
                        @endphp @if(!empty($labTransaction))
                        @foreach($labTransaction as $key)
                    <tr>
                        <td>{{ $srno }}</td>
                            <td>
								{{ $key->lab_transaction_id }}
							</td>
                            <td> {{$key->lab_transaction_order_id}}</td>
                            <td>{{ date('j F, Y h:i A', $key->lab_transaction_time) }}</td>
                             <td>
								@isset($lab_test_data[$key->lab_transaction_order_id])
								@foreach ($lab_test_data[$key->lab_transaction_order_id] as $index => $test)
								<p>({{ $index + 1 }}). {{ $test->consumer_name }}  {{ $test->consumer_mobile_no }}</p>
                                <p>({{ $index + 1 }}). {{$test->lt_test_name}} ( {{$test->lab_test_p_o_i=='1' ? 'Individual Test' :'Package Test'}} )</p>
								@endforeach
								@endisset
							</td>
                            <td>{{ ($key->lab_transaction_type == "0") ? "COD" : (($key->lab_transaction_type == '1')  ? "ONLINE" : (($key->lab_transaction_type == '2')  ? "LAB PAID TO COMPANY" : "COMPANY PAID TO LAB"))}} </td>
                            <td>{{$key->lab_transaction_status=='0' ? 'Success' :'Pending'}}</td>
                            <td><b>₹</b> {{number_format($key->lab_transaction_amount,2)}}</td>
                            <td>{{number_format($key->lab_transaction_percentage, 2)}} %</td>
                            <td><b>₹</b> {{number_format($key->lab_transaction_company_amount,2)}}</td>
                            <td><b>₹</b> {{number_format($key->lab_transaction_lab_amount,2)}} </td>
                            <td><b>₹</b>{{number_format($key->lab_transaction_old_balance,2)}} </td>
                            <td><b>₹</b> {{number_format($key->lab_transaction_new_balance,2)}}</td>

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
                {{$labTransaction->links()}}
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







