<div class="content mt-2">
 
    <div class="container-fluid">
        <div class="card custom__filter__responsive"> 
        <div class="card-body p-2 overflow-auto row p-0">
                <div class="col-12 col-md-6 px-0">
                    <div class=" pl-3 py-2">
                        <table class="table m-0 custom__table table-bordered">
                            <tr>
                                <td><b>Booking Id</b></td> 
                                <td>{{$data['booking_list']->booking_id ?? 'N/A'}}
                                     @if(isset($data['booking_list']->booking_status))
                                     <span class="text-success text-bold">  
                                         @switch($data['booking_list']->booking_status)
                                            @case(0)
                                                (Enquiry)
                                                @break
                                            @case(1)
                                                (Booking Done)
                                                @break
                                            @case(2)
                                                (Driver assigned)
                                                @break
                                             @case(2)
                                               (Driver assigned)
                                                @break
                                            @case(3)
                                                (Invoice created)
                                                @break
                                            @case(4)
                                                (Completed)
                                                @break
                                            @case(5)
                                                (Canceled)
                                                @break
                                        @endswitch
                                    </span>
                                @endif

                                </td>
                            </tr>
                            <tr>
                                <td><b>Booking Lead Source</b></td>
                                <td>{{$data['booking_list']->booking_source ?? 'N/A'}}</td>
                            </tr>
                            <tr>
                                <td><b>Booking type</b></td>
                                <td>
                                @if(isset($data['booking_list']->booking_type))
                                    @switch($data['booking_list']->booking_type)
                                        @case(0)
                                            Regular
                                            @break
                                        @case(1)
                                            Rental
                                            @break
                                        @case(2)
                                            Bulk
                                            @break
                                    @endswitch
                                @endif
                                </td>

                            </tr>
                            <tr>
                                <td><b>Consumer Name</b></td>
                                <td>{{$data['booking_list']->booking_con_name ?? 'N/A'}}</td>
                            </tr>
                            <tr>
                                <td><b>Consumer Number</b></td>
                                <td>{{$data['booking_list']->booking_con_mobile ?? 'N/A'}}</td>
                            </tr>
                            <tr>
                                <td><b>Time Scheduled</b></td>
                                <td>{{$data['booking_list']->booking_schedule_time_v1 ?? 'N/A'}}</td>
                                
                            </tr>
                            <tr>
                                <td><b>Pickup Address</b></td>
                                <td>{{$data['booking_list']->booking_pickup ?? 'N/A'}}</td>
                            </tr>
                            <tr>
                                <td><b>Pickup city</b></td>
                                <td>{{$data['booking_list']->booking_pickup_city ?? 'N/A'}}</td>
                            </tr>
                            <tr>
                                <td><b>Drop Address</b></td>
                                <td>{{$data['booking_list']->booking_drop ?? 'N/A'}}</td>
                            </tr>
                            <tr>
                                <td><b>Drop city</b></td>
                                <td>{{$data['booking_list']->booking_drop_city ?? 'N/A'}}</td>
                            </tr>
                            <tr>
                                <td><b>Driver Name</b></td>
                                <td>{{$data['booking_list']->driver_name ?? 'N/A'}}</td>
                            </tr>
                            <tr>
                                <td><b>Driver mobile</b></td>
                                <td>{{$data['booking_list']->driver_mobile ?? 'N/A'}}</td>
                            </tr>
                            <tr>
                                <td>
                                @if($data['booking_list']->booking_id && $data['booking_list']->booking_status == 1 || $data['booking_list']->booking_status == 2) 
                                <a wire:click="cancelBooking({{ $data['booking_list']->booking_id }})" class="btn btn-warning btn-sm">
                                Cancel Booking
                                </a>
                                @endif
                            </td>
                                <td>
                                @if($data['booking_list']->booking_status == 2 && $data['booking_list']->booking_view_status_otp == 1) 
                                     <a wire:click="bookingOtpMatch({{ $data['booking_list']->booking_id }})"  class="btn {{ $data['booking_list']->booking_view_status_otp == 0 ? 'btn-success' : 'btn-warning' }} btn-sm"> OTP match </a>
                                @endif

                                @if($data['booking_list']->booking_status == 4 && $data['booking_list']->booking_view_status_otp == 0)
                                <a class="btn btn-primary btn-sm" >Complete ride</a>

                                @endif
                                
                                </td>
                            </tr>
                            
                             
                        </table>
                    </div>
                </div>
                <div class="col-12 col-md-6 px-0">
                    <div class=" pr-3 py-2">
                        <table class="table m-0 custom__table table-bordered">
                            
                            <tr>
                                <td><b>Amount Total</b></td>
                                <td>{{$data['booking_list']->booking_total_amount ?? 'N/A'}}</td>
                            </tr>
                            <tr>
                                <td><b>Advance amount</b></td>
                                <td>{{$data['booking_list']->booking_adv_amount ?? 'N/A'}}</td>
                            </tr>
                            <tr>
                                <td><b>Extra km ({{$data['booking_list']->booking_view_per_ext_km_rate ?? 'N/A'}})</b></td>
                                <td>{{$data['booking_list']->bi_ext_km ?? 'N/A'}}</td>
                            </tr>
                            <tr>
                                <td><b>Extra time</b></td>
                                <td>{{$data['booking_list']->bi_ext_time ?? 'N/A'}}</td>
                            </tr>
                            <tr>
                                <td><b>Booking Category</b></td>
                                <td>{{$data['booking_list']->booking_view_category_name ?? 'N/A'}}</td>
                            </tr>
                            <tr>
                                <td><b>Booking Status</b></td>
                                <td>
                                @if(isset($data['booking_list']->booking_status))
                                    @switch($data['booking_list']->booking_status)
                                        @case(0)
                                            Enquiry
                                            @break
                                        @case(1)
                                            Rental
                                            @break
                                        @case(2)
                                            Bulk
                                            @break
                                        @case(3)
                                            Bulk
                                            @break
                                        @case(4)
                                            Complete
                                            @break
                                    @endswitch
                                @endif
 
                                </td>
                            </tr>
                            <tr>
                                <td><b>Payment type</b></td>
                                <td>
                                @if(isset($data['booking_list']->booking_payment_type))
                                    @switch($data['booking_list']->booking_payment_type)
                                        @case(1)
                                            Full payment
                                            @break
                                        @case(2)
                                            Advance payment
                                            @break
                                        @case(3)
                                            Zero payment                          
                                            @break
                                    @endswitch
                                @endif
                            </tr> 
                            <tr>
                                <td><b>Payment method</b></td>
                                <td>
                                @if(isset($data['booking_list']->booking_payment_method))
                                    @switch($data['booking_list']->booking_payment_method)
                                        @case(1)
                                            Cash payment
                                            @break
                                        @case(2)
                                            Online payment
                                            @break
                                    @endswitch
                                @endif
                                </td>
                            </tr>
                            <tr>
                                <td><b>Booking accept time</b></td>
                                <td>{{$data['booking_list']->booking_acpt_time ?? 'N/A'}}
                               
                                </td>
                            </tr>
                            <tr>
                                <td><b>Booking time taken to pickup</b></td>
                                <td>{{$data['booking_list']->booking_ap_duration ?? 'N/A'}}
                               
                                </td>
                            </tr>
                            <tr>
                                <td><b>Driver distance to pickup</b></td>
                                <td>{{$data['booking_list']->booking_ap_duration ?? 'N/A'}}
                               
                                </td>
                            </tr>
                            <tr>
                                <td><b>OTP</b></td>
                                <td>{{$data['booking_list']->booking_view_otp ?? 'N/A'}}
                               
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <b>OTP status</b>
                                </td>
                                <td>    
                                      {{$data['booking_list']->booking_view_status_otp == 0 ? 'Matched' : 'Not matched'}}
                                 </td>
                            </tr>
                        </table>
                        
                    </div>
                    
                </div>
            </div>
        </div>
           
        <div class="pb-3 card custom__filter__responsive"> 
                            <div class="pr-3 py-2">
                                <table class="table m-0 custom__table table-bordered">
                                <div id="bookingDetailMap"> </div>
                            </div>
                 </div>
            
        <div class="card custom__filter__responsive"> 
                <div class="col">
                            <div class="pr-3 py-2">
                                <table class="table m-0 custom__table table-bordered">
                                <td><b>Transaction Details</b></td>
                                <tr>
                                <th>Sr no.</th>
                                <th>Transaction Id</th>
                                <th>Source</th>
                                <th>Order Id</th>
                                <th>Amount</th>
                                <th>Time</th>
                                <th> Status</th>
                                </tr>
                                <tr>
                                        @if(!empty($booking_trans))
                                                <?php $sr=1;?>
                                                @foreach($booking_trans as $key)
                                                    <td>{{$sr++}}</td>
                                                        <td><a href="#" class="text-primary">{{$key->transaction_id}}</a></td>
                                                        <td>
                                                            @if (!empty($key->payment_source))
                                                                {{$key->payment_source}}
                                                            @endif
                                                        </td>
                                                        <td>{{$key->order_id ?? 'N/A'}}</td>
                                                        <td>{{$key->amount}}</td>
                                                    <td>
                                                        @if (!empty($key->booking_transaction_time))
                                                        {{-- {{ date('j F Y h:i A', $key->booking_transaction_time) }} --}}

                                                        @else
                                                        @endif
                                                    </td>
                                                        <td>@if($key->booking_payments_trans_status=='0')
                                                        success @elseif($key->booking_payments_trans_status=='1') Incomplete @else Refund @endif</td>
                                                @endforeach
                                            @endif
                                            </tr>
                                
                                </table>
                                </div>
                            </div>
                </div>
                <!-- available driver list start-->
                 @if ($isCancelBookingOpen)
                <div class="modal" tabindex="-1" role="dialog" style="display: block; background: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cancel booking</h5>
                <button wire:click="closeModal"  class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="cancelBookingProcessing">
                                      
                                            
                    <!-- mm mmmm mmmm mmm mm -->
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label data-toggle="tooltip" data-placement="top" title="Booking lead source">Canceled By</label>
                                                            <select wire:model.live="canceled_by" class="custom-select rounded-0 form-control form-control-sm" id="exampleSelectRounded0">
                                                                <option value="">Select</option>
                                                                <option value="DRIVER">Driver</option>
                                                                <option value="CONSUMER">Consumer</option> 
                                                            </select>
                                                            @error('canceled_by') <span class="text-danger">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                    @if($this->canceled_by == 'DRIVER')
                                                    <div class="col-6">
                                                                <div class="form-group">
                                                                    <label>Penalty</label>
                                                                    <select wire:model="is_penalty" class="custom-select rounded-0 form-control form-control-sm" id="exampleSelectRounded0">
                                                                    <option value="YES">yes</option>
                                                                    <option value="No">no</option>
                                                                    </select>
                                                                </div>
                                                    </div>
                                                    @endif
                                                    </div>
                                                    <div class="form-group">
                                                    <label for="name">Cancel reason</label>
                                                    <textarea rows="2" wire:model="cancelReason" type="text" class="form-control" id="cancelReason" placeholder="Enter Name"></textarea>
                                                    @error('cancelReason') <span class="text-danger">{{ $message }}</span> @enderror
                                                    <br>
                                                    <button  wire:target="cancelBookingProcessing" class="mt-2 btn btn-primary">Cancel</button>
                                                </div>
                                                </div>
                                                 
                     <!-- mm mmmm mmmm mmm mm -->

                                </form>
                            </div>
                        </div>
                    </div>
                </div>          
                 <div class="card custom__filter__responsive"> 
                    <div class="col">
                            <div class="pr-3 py-2">
                                <table class="table m-0 custom__table table-bordered">
                                <tr>
                                <th>Sr no.</th>
                                <th>Driver Name</th>
                                <th>Mobile</th>
                                <th>Driver distance to pickup</th>
                                <th>Driver Duty</th>
                                <th>Partner Name</th>
                                <th>City Name</th>
                                <th>Driver Image</th>
                                <th>Action</th>
                                </tr>
                                             
                                        <?php $sr=1;?>
                                            @foreach($notifiedDriversList as $driver)
                                             @if($driver->booking_assigned_td_status != 3)

                                                <tr class="action__btn">
                                                    <td>{{$sr++}}</td>
                                                        <td>
                                                        {{$driver->driver_name ?? 'N/A'}} {{$driver->driver_last_name ?? ''}}
                                                        </td>
                                                        <td>
                                                        {{$driver->driver_mobile ?? 'N/A'}}
                                                        </td>
                                                        <td>
                                                        {{$driver->formatted_distance ?? 'N/A'}}
                                                        </td>
                                                        <td>
                                                        {{$driver->driver_duty_status ?? 'N/A'}}
                                                        </td>
                                                    <td>
                                                     
                                                    @if($driver->driver_created_partner_id == 0)
                                                    By self
                                                    @else
                                                    {{$driver->partner_f_name}} {{$driver->partner_l_name}}
                                                    @endif
                                                    </td>
                                                    {{$driver->driver_duty_status ?? 'N/A'}}
                                                    <td>
                                                    {{$driver->city_name ?? 'N/A'}}
                                                    </td>
                                                    <td>
                                                    <img src={{env('Image_url').$driver->driver_profile_img ?? 'N/A'}}>
                                                    </td>
                                                    <td>
                                                    @switch($driver->booking_assigned_td_status)
                                                        @case(1)
                                                        <div class="btn-group">
                                                                <button type="button" class="btn  btn-danger btn-sm">Assign</button>
                                                            </div>
                                                            @break
                                                        @case(2)
                                                            
                                                            <div class="btn-group">
                                                                <button type="button" class="btn  btn-danger btn-sm">Rejected</button>
                                                            </div>
                                                            @break
                                                        @case(3)
                                                        <div class="btn-group">
                                                            <button class="btn btn-success btn-sm">
                                                            Accepted
                                                            </button>
                                                            <button wire:click="cancelBooking({{ $driver->booking_assigned_td_booking_id }})"  class="btn btn-warning btn-sm">
                                                            Cancel
                                                            
                                                            </button>
                                                        </button>
                                                            @break
                                                        @case(4)
                                                        <div class="btn-group">
                                                                <button type="button" class="btn  btn-danger btn-sm">Timeout</button>
                                                            </div>
                                                            @break
                                                    @endswitch
                                                    

                                                        </td>
                                                    </tr>
                                            @endif
                                                @endforeach
                                     </table>
                                </div>
                            </div>
                        </div>
                </div>
                @endif

                <!-- available driver list end -->

            </div>
        </div>
</div>
@php 
$mapKey = DB::table('aa_setting')->where('a_setting_id', 9)->first();
@endphp

<script>
    function initMap() {
        const myLatLng = { lat: {{$buket_map_data[0]['booking_pick_lat']}}, lng: {{$buket_map_data[0]['booking_pick_long']}} };
        const map = new google.maps.Map(document.getElementById("bookingDetailMap"), {
            zoom: 13,
            center: myLatLng
        });

        // Add marker for driver's location
        new google.maps.Marker({
            position: myLatLng,
            map: map,
            title: 'Driver: test driver',
            icon: '/assets/app_icon/large_car.png' // Ensure the correct path to the marker icon
        });

        // Request directions from driver's location to a fixed destination
        const directionsService = new google.maps.DirectionsService();
        const directionsRenderer = new google.maps.DirectionsRenderer({
            map: map,
            suppressMarkers: true // Prevents markers from being automatically placed by the renderer
        });

        const destinationLatLng = new google.maps.LatLng({{$buket_map_data[0]['booking_drop_lat']}}, {{$buket_map_data[0]['booking_drop_long']}});  
        const destinationLatLng1 = new google.maps.LatLng(26.7842, 80.9914);  

        const request = {
            origin: myLatLng,
            destination: destinationLatLng,
            travelMode: 'DRIVING'
        };

        directionsService.route(request, function(result, status) {
            if (status == 'OK') {
                directionsRenderer.setDirections(result);
            }
        });
        // const polyline1 = new google.maps.Polyline({
        //     path: [myLatLng, destinationLatLng1],
        //     geodesic: true,
        //     strokeColor: 'red',
        //     strokeOpacity: 1.0,
        //     strokeWeight: 2,
        //     map: map
        // });
    }

   
     function loadGoogleMapsScript() {
        const script = document.createElement("script");
        script.src = "https://maps.googleapis.com/maps/api/js?key={{$mapKey->a_setting_value}}&callback=initMap";
        script.defer = true;
        script.async = true;
        document.head.appendChild(script);
    }

     loadGoogleMapsScript();
 </script>