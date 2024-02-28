
<?php

    $createdMapper['0'] = "Self";
    $createdMapper['1'] = "Partner";

    $transactionTypeMapper['1'] = "add-in wallet by Self(A)";
    $transactionTypeMapper['2'] = "cancelation charge(W)";
    $transactionTypeMapper['3'] = "Cash Collect(W)";
    $transactionTypeMapper['4'] = "online booking payment(A)";
    $transactionTypeMapper['5'] = "transfer to bank account (W)";
    $transactionTypeMapper['6'] = "fetched by Partner (W)";
    $transactionTypeMapper['7'] = "Incentive from Company(A)";
    $transactionTypeMapper['8'] = "add in wallet Recharge wallet by Partner(A)";
    $transactionTypeMapper['9'] = "for add in walletRecharge by partner's wallet transfer(A)";

    ?>

<style type="text/css">
        #map {
          height: 400px;
		width: 100%;
        }
    </style>

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
   
 <!--=========================== Driver Details Nav Bar Starts =================================================================--->
        @include('livewire.admin.driver_details_nav_bar')
    <!--=========================== Driver Details Nav Bar Ends =================================================================--->

          <div class="pd-20 card-box mb-30 p-3">
                            <div class="clearfix">
                                <div class="pull-left">
                                    <h4 class="text-danger h4 "> Driver  Location In Map</h4>          
                                </div>
                            </div>
                                    <div class="container mt-5">
                                    <div id="map"></div><br>
                                    Update Time : {{$buket_map_data[0]['time_diffrence']}}						
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

@php 
$mapKey = DB::table('aa_setting')->where('a_setting_id', 9)->first();
@endphp

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script type="text/javascript">
    function initMap() {
        const myLatLng = { lat: {{$buket_map_data[0]['driver_live_location_lat']}}, lng: {{$buket_map_data[0]['driver_live_location_long']}} };
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 13,
            center: myLatLng
        });

        new google.maps.Marker({
            position: myLatLng,
            map: map,
            title: 'Driver: {{$buket_map_data[0]['driver_name']}} {{$buket_map_data[0]['driver_last_name']}} {{$buket_map_data[0]['time_diffrence']}}',
            icon: '/assets/app_icon/large_car.png' // Ensure the correct path to the marker icon
        });
    }

    // Load Google Maps API asynchronously
    function loadGoogleMapsScript() {
        const script = document.createElement("script");
        script.src = "https://maps.googleapis.com/maps/api/js?key={{$mapKey->a_setting_value}}&callback=initMap";
        script.defer = true;
        script.async = true;
        document.head.appendChild(script);
    }

    // Call the function to load the Google Maps API
    loadGoogleMapsScript();
</script>

