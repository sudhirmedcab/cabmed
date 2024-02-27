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
        
<!--=========================== Consumer Details Nav Bar Starts =================================================================--->
        @include('livewire.admin.consumer.consumer_details_nav_bar')
<!--=========================== Consumer Details Nav Bar Ends =================================================================--->

        <div class="custom__driver__detail__section card px-3">
            <table class="table m-0 table-sm custom__table table-bordered mt-3 mb-2">
            </table>
            <div class="row p-0">
                <div class="col-12 col-md-12 px-0">
                    <div class="pl-3 py-2">
                        <table class="table m-0 custom__table table-bordered">
                            <tr>
                                <td>Consumer Id</td>
                                <td>{{$consumerDetails->consumer_id }}</td>
                            </tr>
                            <tr>
                                <td>Name</td>
                                <td>{{$consumerDetails->consumer_name}}</td>
                            </tr>
                            <tr>
                                <td>Verification Status</td>
                                <td>@if(!empty($consumerDetails->consumer_status==1))Active @elseif($consumerDetails->consumer_status==0) New @elseif($consumerDetails->consumer_status=='4') Applied @else FRC @endif</td>
                            </tr>
                            <tr>
                                <td>Mobile Number</td>
                                <td>{{$consumerDetails->consumer_mobile_no}}</td>
                            </tr>
                           
                            <tr>
                                <td>Registered Date</td>
                                <td>{{date('j F, Y h:i A', $consumerDetails->consumer_registred_date)}}</td>
                            </tr>
                            <tr>
                                <td>Wallet</td>
                                <td>&#8377; .{{$consumerDetails->consumer_wallet_amount}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
              
            </div>
              
        </div>
    </div>
</div>




