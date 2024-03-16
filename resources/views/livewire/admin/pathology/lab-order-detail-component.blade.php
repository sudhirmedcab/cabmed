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
        
<!--=========================== Lab order Details Nav Bar Starts =================================================================--->
           @include('livewire.admin.pathology.lab_order_details_nav')
<!--=========================== Lab order Details Nav Bar Ends =================================================================--->

     @if($this->filterData == 'Details')

        <div class="custom__driver__detail__section card px-3">
            <table class="table m-0 table-sm custom__table table-bordered mt-3 mb-2">
            </table>
            <div class="row p-0">
                <div class="col-12 col-md-12 px-0">
                    <div class="pl-3 py-2">
                        <p class="text-center"> @if($labtestData->clo_status == '1')
                                            New
                               @elseif($labtestData->clo_status == '2')
                                            Ongoing
                                 @elseif($labtestData->clo_status == '3')
                                            Cancel
                               @else
                                   Complete
                                  @endif
                         Lab Order Details Page</p>
                    
                        <table class="table m-0 custom__table table-bordered">
                            <tr>
                                <td>Consumer Name</td>
                                <td>{{$labtestData->clo_customer_name }}</td>
                            </tr>
                            <tr>
                                <td>Consumer Mobile</td>
                                <td>{{$labtestData->clo_contact_no}}</td>
                            </tr>
                            <tr>
                                <td>Lab Address</td>
                                <td>{{$labtestData->clo_address}} ,{{$labtestData->clo_address_pincode}}</td>
                            </tr>
                            <tr>
                                <td>Lab City Details</td>
                                <td>{{$labtestData->city_name.','.$labtestData->state_name}} </td>
                            </tr>
                           
                            <tr>
                                <td>Lab Address Type</td>
                                <td>@if ($labtestData->clo_address_type == '0')
                                     Collect At the Home
                                     @else
                                     Collect At the Address
                                  @endif</td>
                            </tr>
                            <tr>
                                <td>Registred Date</td>
                                <td>{{date('j F, Y h:i A', $labtestData->consumer_registred_date)}}</td>
                            </tr>
                            <tr>
                                <td>Order Date</td>
                                <td>{{date('j F, Y h:i A', $labtestData->clo_order_time)}}</td>
                            </tr>
                            <tr>
                                <td>No Of Test</td>
                                <td>{{$labtestData->clo_no_of_test}}</td>
                            </tr>
                            <tr>
                                <td>No Of Patients</td>
                                <td>{{$labtestData->clo_no_of_patient}}</td>
                            </tr>
                            <tr>
                                <td>Total Price Mrp</td>
                                <td>&#8377;{{$labtestData->clo_total_price_mrp}}</td>
                            </tr>
                           
                          
                            <tr>
                                <td>Total Price Discount Amount</td>
                                <td>&#8377;{{$labtestData->clo_total_price_discount}}</td>
                            </tr>
                            <tr>
                                <td>Total Price Saving Amount</td>
                                <td>&#8377;{{$labtestData->clo_total_price_total_saving}}</td>
                            </tr>
                            <tr>
                                <td>Total Price Collection Amount</td>
                                <td>{{$labtestData->clo_collection_charges}}</td>
                            </tr>
                            <tr>
                                <td>Total Price GST Amount</td>
                                <td>&#8377;{{$labtestData->clo_gst}}</td>
                            </tr>
                            <tr>
                                <td>Total Final Price Amount</td>
                                <td>&#8377;{{$labtestData->clo_final_price}}</td>
                            </tr>
                            <tr>
                                <td>Payment Status</td>
                                <td>@if($labtestData->clo_payment_status=='0') Pending @else Done @endif</td>
                            </tr>
                            <tr>
                                <td>Payment Type</td>
                                <td>&#8377;{{$labtestData->clo_payment_type}}</td>
                            </tr>
                            <tr>
                                <td>Collection Boy Name</td>
                                <td>{{($labtestData->clo_sample_collection_by_name) ? $labtestData->clo_sample_collection_by_name : "Not Assigned"}}</td>
                            </tr>
                            <tr>
                                <td>Collection Boy Mobile</td>
                                <td>{{($labtestData->clo_sample_collection_by_mobile) ? $labtestData->clo_sample_collection_by_mobile : "Not Availabe"}}</td>
                            </tr>
                        </table>

                    </div>
                </div>
              
            </div>
              
        </div>

        @elseif($this->filterData == 'orderDetails')
        <div class="custom__driver__detail__section card px-3">
            <table class="table m-0 table-sm custom__table table-bordered mt-3 mb-2">
            </table>
            <div class="row p-0">
                <div class="col-12 col-md-12 px-0">
                    <div class="pl-3 py-2">
                        <p class="text-center"> @if($labtestData->clo_status == '1')
                                            New
                               @elseif($labtestData->clo_status == '2')
                                            Ongoing
                                 @elseif($labtestData->clo_status == '3')
                                            Cancel
                               @else
                                   Complete
                                  @endif
                         Lab Order Details Page</p>
                    
                        <table class="table m-0 custom__table table-bordered">
                            <tr>
                                <td>User Name</td>
                                <td><a wire:navigate href="{{route('consumer-details',['consumerId' => Crypt::encrypt($labtestData->consumer_id)])}}"  class="text-primary">{{$labtestData->consumer_name}}  ({{$labtestData->consumer_id}})</a></td>
                            </tr>
                            <tr>
                                <td>User Mobile</td>
                                <td>{{$labtestData->consumer_mobile_no}}</td>
                            </tr>
                            <tr>
                                <td>User Wallet</td>
                                <td>&#8377;{{$labtestData->consumer_wallet_amount}}</td>
                            </tr>
                            <tr>
                                <td>Registred Date</td>
                                <td>{{date('j F, Y h:i A', $labtestData->consumer_registred_date)}}</td>
                            </tr>
                           
                            <tr>
                                <td>Lab Name</td>
                                <td>{{$labtestData->lab_name}} ({{$labtestData->lab_id}})</td>
                            </tr>
                            <tr>
                                <td>Lab Mobile</td>
                                <td>{{$labtestData->lab_contact_no}}</td>
                            </tr>
                            <tr>
                                <td>Lab Type</td>
                                <td>{{$labtestData->lab_type}}</td>
                            </tr>
                            <tr>
                                <td>Registred Date</td>
                                <td>@if(!empty($labtestData->lab_added_date)){{date('j F, Y h:i A', $labtestData->lab_added_date)}} @else Not Available @endif</td>
                            </tr>
                            <tr>
                                <td>Accepted Booking Date</td>
                                <td>@if(!empty($labtestData->clo_booking_verify_time)){{date('j F, Y h:i A', $labtestData->clo_booking_verify_time )}}  @else Not Available @endif</td>
                            </tr>
                          
                         
                        </table>

                    </div>
                </div>
              
            </div>
              
        </div>
        @elseif($this->filterData == 'testDetails')
        <div class="custom__driver__detail__section card px-3">
            <table class="table m-0 table-sm custom__table table-bordered mt-3 mb-2">
                    <tr>
                    <th>Sr.No.</th>
					<th>Test ID</th>
                     <th>Lab Order Id</th>
					<th>Test Name</th>
					<th>Price</th>
					<th>Offer Price</th>
					<th>Category </th>
					<th>Category Icon</th>
					<th>Status</th>
                </tr>
                     @if(!empty($ordertestDetails))
							    <?php $sr=1;?>
                          @foreach($ordertestDetails as $key)
                                 <tr>
                                    <td >{{$sr++}}</td>
								    <td> {{$key->clot_test_id}}</td>
									<td> {{$key->clot_order_id}}</td>
                                     <td>{{$key->lt_test_name}}</td>
                                     <td>&#8377;{{$key->clot_price}}</td>
                                     <td>&#8377;{{$key->clot_offer_price}}</td>
                                     <td>@if($key->lc_category_name){{$key->lc_category_name}} @else No Category @endif</td>
                                     <td><img  src="https://dev.cabmed.in/{{$key->lc_category_image}}" style="width:20px;height:20px;"></td>
                                     <td>@if($key->clot_status=='0') Active @elseif($key->clot_status=='1') Inactive @else  @endif</td>

							  </tr>
                      @endforeach
                   @endif
            </table>
            <div class="custom__pagination mt-2 text-right pt-1 card-footer__ clearfix">

                {!! $ordertestDetails->links() !!}

                </div>
        </div>
        @elseif($this->filterData == 'timeDetails')
        <div class="custom__driver__detail__section card px-3">
            <table class="table m-0 table-sm custom__table table-bordered mt-3 mb-2">
                    <tr>
                       <th>Sr.No.</th>
					   <th>Patients Id</th>
						<th>Lab Order Id</th>
						<th>Patients Name</th>
						<th>Patients Age</th>
						<th>Patients Gender</th>
						<th>Report Card Status</th>
						<th>Download Report</th>
						<th>Status</th>
                </tr>
                @if(!empty($labtestPatients))
				   <?php $sr=1;?>
                 @foreach($labtestPatients as $key)
                      <tr> 
                         <td class="table-plus">{{$sr++}}</td>
							<td> {{$key->customer_lab_patient_id }}</td>
							<td> {{$key->clp_lab_order_id }}</td>
                           <td>{{$key->clp_patient_name}}</td>
                           <td>{{$key->clp_patient_age}}</td>
                          <td>@if($key->clp_patient_gender=='0') Male @elseif($key->clp_patient_gender=='1') Female @else Others @endif</td>
                           <td>@if($key->clp_pt_report_status=='0') Sample not Colleted @elseif($key->clp_pt_report_status=='1') Sample Colleted @else Report Generated @endif</td>
                            <td>
                             @if(!empty($key->clp_pt_upload_report_link))
                          <a href="{{ env('Partner_url') . '/' . $key->clp_pt_upload_report_link }}" target="_blank" title="" class="text-danger">Download/View PDF</a>
                              @else
                                 Not Generated
                             @endif
                         </td>

                      <td>@if($key->clp_status=='0') Active @elseif($key->clp_status=='1') Inactive @else  @endif</td>
						   </tr>
                           @endforeach
                      @endif
            </table>
            <div class="custom__pagination mt-2 text-right pt-1 card-footer__ clearfix">

                {!! $labtestPatients->links() !!}

                </div>
        </div>
        @elseif($this->filterData == 'labDetails')
        <div class="custom__driver__detail__section card px-3">

             
            <table class="table m-0 table-sm custom__table table-bordered mt-3 mb-2">
                    <tr>
                         <th>Sr.No.</th>
						 <th>Name</th>
						 <th>Mobile</th>
						 <th>Lab Owner Name</th>
						 <th>Lab Owner Mobile</th>
						 <th>City Details</th>
						<th>Lab Status</th>
                    </tr>
                @if(!empty($labListData))
				   <?php $sr=1;?>
                 @foreach($labListData as $key)
                 @if($labtestData->clo_status=='1')

                 <tr>  
                    <td class="table-plus">{{$sr++}}</td>
					  <td> {{$key->lab_name }} ({{$key->lab_id}})</td>
                      <td>({{$key->lab_contact_no}})</td>
					 <td>@if(!empty($key->lab_owner_id))<a wire:navigate href="{{route('lab_details',['LabOwnerId' => Crypt::encrypt($key->lab_owner_id),'Details'=>'Details'])}}"
					class="text-primary"> {{($key->lab_owner_name) }} ({{$key->lab_owner_id }})</a> @else Not Availabe @endif</td>
                    <td>{{($key->lab_owner_mobile_number)? $key->lab_owner_mobile_number : "Not Availabe"}}</td>
                        <td>{{$key->city_name.','.$key->state_name}}</td>
                        <td>@if($key->lab_status=='0') Active @elseif($key->lab_status=='1') Inactive @else  @endif</td>
					 </tr>
                           @else   No Any Records Found @endif

                           @endforeach

                      @endif
            </table>

            @if($labtestData->clo_status=='1')
            <div class="custom__pagination mt-2 text-right pt-1 card-footer__ clearfix">
                {!! $labListData->links() !!}
                </div>
                @endif
        </div>
        @endif
    </div>
</div>






