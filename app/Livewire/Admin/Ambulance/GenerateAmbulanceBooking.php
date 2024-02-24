<?php

namespace App\Livewire\Admin\Ambulance;

use Livewire\Component;
use Illuminate\Support\Facades\DB; 
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Illuminate\Http\Response;
class GenerateAmbulanceBooking extends Component
{
    public $booking_type,$customer_name,$customer_mobile,$pickup_address,$drop_address,$pickup__address,$drop__address,
    $booking_source,$booking_con_name,$booking_con_mobile,$booking_schedule_time,$p_latitude,$p_longitude,
    $d_latitude,$d_longitude,$support_remark,$duty_status,$booking_by_cid,$booking_for,$duration,$booking_id,
    $selected_ambulance_category_type,$ambulanceCatList,$ambulance_category_type,$select_driver,$distance,$selectedRow,$advance_rate_service_charge,
    $select_booking_type,$select_booking_status,$booking_payment_method,$payment_source_type,$transactionId,$transaction_time,$transaction_amounts,
    $AmbulanceData,$ambulanceDetails=[],
    $id1;
    protected $listeners = ['locationUpdated'];

    public $selectedOption = 'H1'; // Set a default option

    public function ambulanceCategoryList(){
        $ambulanceCategory = DB::table('ambulance_category')
            ->orderByDesc('ambulance_category.ambulance_category_id')
            ->get();
            return $ambulanceCategory;
    }
    public function mount(){
        $this->ambulanceCatList = $this->ambulanceCategoryList();
      }
    public function render()
    { 
        // return view('livewire.admin.ambulance.generate-ambulance-booking')->with(['ambulanceCatList'=>$this->ambulanceCatList]);
        

         return view('livewire.admin.ambulance.generate-ambulance-booking');
    }
public function updated(){
    $this->validate([
        'selectedRow.base_rate' => 'numeric|required',
        'selectedRow.per_km_rate' => 'numeric|required',
        'selectedRow.per_ext_km_rate' => 'numeric|required',
    ], 
    [
    'selectedRow.base_rate.required' => 'Base rate is required',
    'selectedRow.base_rate.numeric' => 'Base rate must be numeric',
    'selectedRow.per_km_rate.required' => 'Per km rate is required',
    'selectedRow.baseper_km_rate_rate.numeric' => 'Per km rate must be numeric',
    'selectedRow.per_ext_km_rate.required' => 'Per km rate is required',
    'selectedRow.per_ext_km_rate.numeric' => 'Per km rate must be numeric'
    ]
    );

    // if(isset($this->selectedRow['base_rate']) && $this->selectedRow['base_rate'] != ''){
    //     $this->selectedRow['total_fare'] =  $this->selectedRow['base_rate']; 
    //     $this->selectedRow['rate_service_charge'] = ($this->selectedRow['base_rate'] * 10) / 100;
    // }
}
 
    public function generateBookingStep1Form(){
          $validatedData = $this->validate([
            'customer_name' => 'required',
            'customer_mobile' => 'required',
         ],[
            'customer_name.required' => 'Customer name required',
            'customer_mobile.required' => 'Customer mobile required',
         ]);
        try{
            DB::beginTransaction();
                    $consumer_data=DB::table('consumer')
                    ->where('consumer_mobile_no', $validatedData['customer_mobile'])
                    ->first();
                    if($consumer_data){
                        $this->booking_for = $consumer_data->consumer_name;
                        $this->booking_by_cid = $consumer_data->consumer_id;
                        $this->booking_con_mobile = $consumer_data->consumer_mobile_no;
                        session()->flash('message', 'consumer exist !!');
                        // dd($consumer_data->consumer_name);
                    }else{
                        $consumerData = [
                            'consumer_name' => $validatedData['customer_name'],
                            'consumer_mobile_no' => $validatedData['customer_mobile'],
                            'consumer_registred_date' => Carbon::now()->timestamp,
                            'created_at' => Carbon::now()
                         ];
                        $customer_id = DB::table('consumer')->insertGetId($consumerData);
                        $this->booking_by_cid = $customer_id;
                        $this->booking_for = $validatedData['customer_name'];
                         session()->flash('message', 'generateBookingStep1 consumer registrationForm successfull !!');
                    }
                    DB::commit();
        }
        catch (\Exception $e) {
            session()->flash('message', 'generateBookingStep1Form something went wrong!!'.$e->getMessage());
            DB::rollback();
            \Log::error('Error occurred while processing generateBookingStep1Form: ' . $e->getMessage());
        }
    }

    public function generateBookingStep2Form(){
        // dd($this);
        // dd('kl',$this->pickup__address['formatted_address']);

         $validatedData = $this->validate([
            'booking_source' => 'required',
            'pickup__address' => 'required',
            'drop__address' => 'required',
            'booking_by_cid' => 'required',
            'duty_status' => 'required',
            'booking_con_mobile' => 'required',
            'booking_schedule_time' => 'required',
         ],[
            'booking_source.required' => 'Booking source required',
            'pickup__address.required' => 'Pickup address required',
            'drop__address.required' => 'Drop address required',
            'duty_status.required' => 'Duty status required',
            'booking_schedule_time.required' => 'Schedule time required',
            'booking_by_cid.required' => 'Please fill consumer details',
         ]);
        //  dd($this);
         try{
            DB::beginTransaction();

       

            $generateBookingStep2FormData = [
                            'booking_source' => $validatedData['booking_source'],
                            'booking_pickup' => $this->pickup__address['formatted_address'],
                            'booking_drop' => $this->drop__address['formatted_address'],
                            'booking_pick_lat' => $this->p_latitude,
                            'booking_pick_long' => $this->p_longitude,
                            'booking_drop_lat' => $this->d_latitude,
                            'booking_drop_long' => $this->d_longitude,
                            'booking_con_name' => $this->booking_for,
                            'booking_con_mobile' => $this->booking_con_mobile,
                            'booking_schedule_time' => $validatedData['booking_schedule_time'],
                            'booking_by_cid' => $this->booking_by_cid,
                            'booking_schedule_time_v1' => $validatedData['booking_schedule_time'],
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ];
                        // dd($generateBookingStep2FormData);
                        

                        $apiKey = env('GOOGLE_MAP_KEY'); // This will retrieve the value of the GOOGLE_MAP_KEY environment variable
                        $pickupapiUrl = "https://maps.googleapis.com/maps/api/geocode/json?latlng={$generateBookingStep2FormData['booking_pick_lat']},{$generateBookingStep2FormData['booking_pick_long']}&key=$apiKey";
                        // Use cURL to make the API request
                        $chpickup = curl_init($pickupapiUrl);
                        curl_setopt($chpickup, CURLOPT_RETURNTRANSFER, true);
                
                        $responsePickup = curl_exec($chpickup);
                        curl_close($chpickup);
                
                        // Decode the JSON response
                        $pickupdata = json_decode($responsePickup, true);
                
                        // Check if the request was successful
                        if ($pickupdata['status'] === 'OK') {
                            // Extract the city name from the response
                            $pickupCity =$this->getCityName($pickupdata['results'][0]['address_components']);
                            $generateBookingStep2FormData['booking_pickup_city'] = $pickupCity;
                        } else {
                            // Handle the API error, log it, or return an appropriate response
                            return null;
                        }

                        $dropapiUrl = "https://maps.googleapis.com/maps/api/geocode/json?latlng={$generateBookingStep2FormData['booking_drop_lat']},{$generateBookingStep2FormData['booking_drop_long']}&key=$apiKey";
                        // Use cURL to make the API request
                        $chdrop = curl_init($dropapiUrl);
                        curl_setopt($chdrop, CURLOPT_RETURNTRANSFER, true);
                
                        $responseDrop = curl_exec($chdrop);
                        curl_close($chdrop);
                
                        $dropupdata = json_decode($responseDrop, true);
                
                        if ($dropupdata['status'] === 'OK') {
                            $dropupCity = $this->getCityName($dropupdata['results'][0]['address_components']);
                            $generateBookingStep2FormData['booking_drop_city'] = $dropupCity;

                        } else {
                            // Handle the API error, log it, or return an appropriate response
                            return null;
                        }

                        $apiUrl = "https://maps.googleapis.com/maps/api/directions/json?key={$apiKey}&units=metric&origin={$generateBookingStep2FormData['booking_pick_lat']},{$generateBookingStep2FormData['booking_pick_long']}&destination={$generateBookingStep2FormData['booking_drop_lat']},{$generateBookingStep2FormData['booking_drop_long']}&mode=driving";
            
                        // Make the API request using cURL
                        $curl = curl_init();
                        curl_setopt($curl, CURLOPT_URL, $apiUrl);
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                        $response = curl_exec($curl);
                        curl_close($curl);
            
                        // Parse the JSON response
                        $data = json_decode($response, true);
                    // dd($data);
                    // dd($data['routes'][0]['legs'][0]['start_address'], $data['routes'][0]['legs'][0]['end_address']);
                        if ($data && isset($data['status']) && $data['status'] === "OK") {
                                 $distanceFromAPI = $data['routes'][0]['legs'][0]['distance']['text'];
                                  $duration = $data['routes'][0]['legs'][0]['duration']['text'];
                                  $this->duration = $duration;
                                  $polylineEncoded = $data['routes'][0]['overview_polyline']['points'];
                                // Use regular expressions to extract hours, minutes, and seconds
                                $generateBookingStep2FormData['booking_polyline'] = $polylineEncoded;
                                $trim_distance = $b = str_replace(" km",'',$distanceFromAPI); 
                                $total_fare = str_replace(',', '', $trim_distance);          
                                $distance = round($total_fare, 2); // Rounded distance in kilometers          
                                $generateBookingStep2FormData['booking_distance'] = $distance;
                            // Retrieve ambulance data from the database
                            $get_base_rate = DB::select("SELECT * FROM `ambulance_rate` LEFT JOIN ambulance_base_rate 
                                On ambulance_base_rate.ambulance_base_rate_cat_type=ambulance_rate.ambulance_rate_category_type 
                                LEFT JOIN ambulance_category On ambulance_category.ambulance_category_type=ambulance_rate.ambulance_rate_category_type
                                WHERE ($distance BETWEEN ambulance_rate_starting_km and ambulance_rate_end_km)  
                                ORDER BY `ambulance_rate`.`ambulance_rate_category_type` ASC ");
                        
                            $AmbulanceData = []; // Initialize an array to store processed ambulance data
                            // dd($get_base_rate);
                            foreach($get_base_rate as $key) {
                                $data_list = [];
                                // Your code snippet starts here
                                $base_rate = 0;
                                $km_rate = 0;
                                $service_charge_rate = 0;
                                $total_fare = 0;
                                $total_booking_amount = 0;
                                $data_list['category_type'] = $category_type = $key->ambulance_base_rate_cat_type;
                                $category_name = $key->ambulance_category_name;
                                $data_list['category_name'] = "" . $category_name;
                                $category_icon = $key->ambulance_category_icon;
                                $data_list['category_icon'] = $category_icon;
                                $base_rate = $key->ambulance_base_rate_amount;
                                $data_list['base_rate'] = "" . $base_rate;
                                $km_till = $key->ambulance_base_rate_till_km;
                                $data_list['km_till'] = "" . $km_till;
                                $rate_service_charge = $key->ambulance_rate_service_charge;
                                $data_list['rate_service_charge'] = "" . $rate_service_charge;
            
                                $per_km_rate = $key->ambulance_rate_amount;
                                $data_list['distance'] = $distance;
                                $this->distance = $distance;
                                $data_list['per_km_rate'] = "" . $per_km_rate;
                                $data_list['per_ext_km_rate'] = "" . $key->ambulance_rate_ext_km_charge;
                                $data_list['per_ext_min_rate'] = "" . $key->ambulance_rate_ext_min_charge;
            
                                if ($distance == $km_till) {
                                    $data_list['div_status'] = "Distance is equal to the limit";
                                    $extra_km = 0;
                                } elseif ($distance < $km_till) {
                                    $data_list['div_status'] = "Distance is less than the limit";
                                    $extra_km = 0;
                                } elseif ($distance > $km_till) {
                                    $extra_km = $distance - $km_till;
                                    $data_list['div_status'] = "Distance is greater than the limit";
                                } else {
                                    $data_list['div_status'] = "Error";
                                    $extra_km = 0;
                                }
                                // dd('generateBookingStep2FormData');
                                $ambulance_rate_multiply = $key->ambulance_rate_multiply;
                                $km_rate = ($extra_km * $ambulance_rate_multiply) * $per_km_rate;
                                $data_list['total_fare'] = $base_rate + $km_rate;        
                                $data_list = [
                                    'category_type' => $category_type,
                                    'category_name' => $category_name,
                                    'category_icon' => $category_icon,
                                    'base_rate' => $base_rate,
                                    'km_till' => $km_till,
                                    'rate_service_charge' => $rate_service_charge,
                                    'per_km_rate' => $per_km_rate,
                                    'per_ext_km_rate' =>$key->ambulance_rate_ext_km_charge,
                                    'per_ext_min_rate' => $key->ambulance_rate_ext_min_charge,
                                    'div_status' => $data_list['div_status'], 
                                    'total_fare' => number_format($data_list['total_fare'], 2),// Use the value calculated in the loop
                                ];
                                $generateBookingStep2FormData['booking_total_amount'] = $data_list['total_fare'];
                                $generateBookingStep2FormData['booking_view_total_fare'] = $data_list['total_fare'];
                                $generateBookingStep2FormData['booking_view_category_name'] = $data_list['total_fare'];
                    
                                $AmbulanceData[] = $data_list;
                                $this->ambulanceDetails=$AmbulanceData;
                                if($this->booking_id){
                                    $bookingId = DB::table('booking_view')->where('booking_id', $this->booking_id)->update($generateBookingStep2FormData);
                                    DB::table('remark_data')->where('remark_booking_id', $this->booking_id)->update(['remark_text' => $this->support_remark,'updated_at' => Carbon::now()]);
                                    session()->flash('message', 'generateBookingStep2 bookinfo form updated successfully  !!');
                                }else{
                                $bookingId = DB::table('booking_view')->insertGetId($generateBookingStep2FormData);
                                $this->booking_id = $bookingId;
                                $remarkId = DB::table('remark_data')->insertGetId(['remark_booking_id'=> $bookingId, 'remark_text' => $this->support_remark,'created_at' => Carbon::now(),'updated_at' => Carbon::now(),'remark_add_unix_time'=>Carbon::now()->timestamp]);
                                session()->flash('message', 'generateBookingStep2 bookinfo form inserted successfully  !!');
                            }
                                DB::commit();

                    // dd('generateBookingStep2FormData',$generateBookingStep2FormData,$distance,$duration,$AmbulanceData,$polylineEncoded);
                    // $bookingId = DB::table('booking_view')->insertGetId($generateBookingStep1FormData);
                   
                }
            }
        }
            catch (\Exception $e) {
                session()->flash('message', 'generateBookingStep2Form something went wrong!!'.$e->getMessage());
                DB::rollback();
                \Log::error('Error occurred while processing generateBookingStep2Form: ' . $e->getMessage());
        }
    }
    public function updatedSelectedOption($value)
    {
        dd($value);
        $this->selected_ambulance_category_type=$value;
        // $this->emit('radioButtonSelected', $value);
    }
    public function selectRow($srno)
    {
         $this->selectedRow = $this->ambulanceDetails[$srno];
         $this->selectedRow['rate_service_charge'] = ($this->selectedRow['base_rate'] * 10) / 100;
         $this->advance_rate_service_charge = $this->selectedRow['rate_service_charge'];
         // dd('srno',$srno,$this->selectedRow, $this->ambulanceDetails[$srno]);

    }

    public function updatedSelectedAmbulanceCategoryType($value)
    {
        $this->selected_ambulance_category_type = $value;
        // You can add more logic here if needed
    }
    public function generateBookingStep3Form(){

        // dd($this,$this->selectedRow['rate_service_charge']);
        $validatedData = $this->validate([
            'selectedRow.base_rate' => 'numeric|required',
            'selectedRow.per_km_rate' => 'numeric|required',
            'selectedRow.per_ext_km_rate' => 'numeric|required',
            'selectedRow.per_ext_km_rate' => 'numeric|required',
            'selectedRow.total_fare' => 'required',
            'selectedRow.rate_service_charge' => 'required',
            'selectedRow.category_name' => 'required',
            'selectedRow.category_type' => 'required',
            'selectedRow.category_icon' => 'required',
            'advance_rate_service_charge' => 'required_if:booking_payment_method,2',
            'payment_source_type' => 'required_if:booking_payment_method,2',
            'transactionId' => 'required_if:booking_payment_method,2',
            'transaction_time' => 'required_if:booking_payment_method,2',
            'select_booking_status' => 'required',
            'booking_payment_method' => 'required',
            'select_booking_status' => 'required',
         ], 
        [
        'selectedRow.base_rate.required' => 'Base rate is required',
        'selectedRow.category_name.required' => 'Category name is required',
        'selectedRow.category_type.required' => 'Category type is required',
        'selectedRow.category_icon.required' => 'category name is required',
        'selectedRow.base_rate.numeric' => 'Base rate must be numeric',
        'selectedRow.per_km_rate.required' => 'Per km rate is required',
        'selectedRow.baseper_km_rate_rate.numeric' => 'Per km rate must be numeric',
        'selectedRow.per_ext_km_rate.required' => 'Per km rate is required',
        'selectedRow.per_ext_km_rate.numeric' => 'Per km rate must be numeric',
        'select_booking_status.required' => 'Booking type required',
        'booking_payment_method.required' => 'Payment method required',
        'payment_source_type.required_if' => 'Payment source required',
        'transactionId.required_if' => 'Transaction id required',
        'transaction_time.required_if' => 'Transaction time required',
        'advance_rate_service_charge.required_if' => 'Advance required'
        ]
        );
        try{
            DB::beginTransaction();
        $generateBookingStep3FormData = [
            'booking_view_base_rate' => $validatedData['selectedRow']['base_rate'],
            'booking_view_per_km_rate' => $validatedData['selectedRow']['per_km_rate'],
            'booking_view_per_ext_km_rate' => $validatedData['selectedRow']['per_ext_km_rate'],
            'booking_view_total_fare' => $validatedData['selectedRow']['total_fare'],
            'booking_view_service_charge_rate' => $validatedData['selectedRow']['rate_service_charge'],
            'booking_category' => $validatedData['selectedRow']['category_type'],
            'booking_view_category_name' => $validatedData['selectedRow']['category_name'],
            'booking_view_category_icon' => $validatedData['selectedRow']['category_icon'],
            
            'booking_status' => $validatedData['select_booking_status'],
            'booking_payment_method' => $validatedData['booking_payment_method'],
            'booking_type' => '0'
        ];
        if($this->booking_payment_method == 2){
            $generateBookingStep3FormData['booking_adv_amount'] = $validatedData['advance_rate_service_charge'];
            $generateBookingStep3FormData['booking_payment_method'] = $validatedData['booking_payment_method'];
            
            $booking_paymentsData = [
                'payment_source' => $this->payment_source_type,
                'transaction_id' => $validatedData['transactionId'],
                'booking_id' => $this->booking_id,
                'consumer_id' => $this->booking_by_cid,
                'booking_transaction_time' => $this->transaction_time,
                'amount' => $this->advance_rate_service_charge,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
            // dd($booking_paymentsData);
            DB::table('booking_payments')->insertGetId($booking_paymentsData);
         }
            DB::table('booking_view')->where('booking_id', $this->booking_id)->update($generateBookingStep3FormData);
            session()->flash('message', 'generateBookingStep3Form succesfull!!');
            DB::commit();
            // return Redirect::route($this->routeUri)->with('errorMessage', 'No record found!');
            return Redirect::route('admin.ambulance-booking-details',$this->booking_id)->with('success', 'Booking successfully.');

        // dd('dd',$generateBookingStep3FormData,$booking_paymentsData);
    }
        catch (\Exception $e) {
            session()->flash('message', 'generateBookingStep3Form something went wrong!!'.$e->getMessage());
            DB::rollback();
            \Log::error('Error occurred while processing generateBookingStep3Form: ' . $e->getMessage());
        }
    }
      // Function to extract the city name from the address components
      function getCityName($addressComponents) {
        foreach ($addressComponents as $component) {
            if (in_array('locality', $component['types']) || in_array('administrative_area_level_2', $component['types'])) {
                return $component['long_name'];
            }
        }
        return null; // Return null if city name is not found
    }
// booking shoot to assign driver start
    public function shootbookings__old(Request $request) {
        $bookingArray = DB::table('booking_view')->where('booking_status', 1)->get();
        // print_r($bookingArray);
        if($bookingArray && count($bookingArray) > 0 ) {
            foreach($bookingArray AS $order) {
                    $bookingInfo = DB::table('booking_view')->where('booking_id', $order->booking_id)->first();

                    if($bookingInfo && $bookingInfo->booking_status == 1) {
                        // dd($bookingInfo);
                        $pickup_lat = $bookingInfo->booking_pick_lat;
                        $pickup_long = $bookingInfo->booking_pick_long;
                        increaseRadius:
                        if($bookingInfo->booking_radius < 11) {
                            $radius = ($bookingInfo->booking_radius+1)*5;
                            $nearest_drivers = DB::select("SELECT * , (6371 * 2 * ASIN(SQRT( POWER(SIN(( $pickup_lat- driver_live_location_lat) * pi()/180 / 2), 2) +COS( $pickup_lat * pi()/180) * COS(driver_live_location_lat * pi()/180) * POWER(SIN(( $pickup_long - driver_live_location_long) * pi()/180 / 2), 2) ))) as distance , ROUND((UNIX_TIMESTAMP()-driver_live_location.driver_live_location_updated_time) / 60, 0) as time_diff , ROUND((UNIX_TIMESTAMP()-driver.driver_last_booking_notified_time) / 60, 0) as last_booking from driver_live_location LEFT JOIN driver ON driver.driver_id =driver_live_location.driver_live_location_d_id LEFT JOIN vehicle ON vehicle.vehicle_id= driver.driver_assigned_vehicle_id WHERE driver.driver_on_booking_status = '0' AND driver.driver_duty_status= 'ON' AND driver_id NOT IN(SELECT booking_assigned_td_driver_id FROM booking_assigned_td WHERE booking_assigned_td_booking_id=$order->booking_id AND booking_assigned_td_status=1) having distance <= $radius AND time_diff <= 100 AND last_booking >= .60 order by distance LIMIT 10 ");
    
                            if($nearest_drivers && count($nearest_drivers) > 0) {
                                foreach ($nearest_drivers as $nav) {
                                    $driver_id = $nav->driver_id;
                                    $driver_fcm_token = $nav->driver_fcm_token;
                                    $driver_distance = $nav->distance;
                                    if (!empty($driver_fcm_token)) {
                                        $dataArray = ['enquiry_id' => $order->booking_id, 'driver_id' => $driver_id, 'key1' => '1'];
                                        $result = app('App\Http\Controllers\SendNotificationController')->send_notification($request, $dataArray);
                                        try{
                                            DB::beginTransaction();
                                            date_default_timezone_set('Asia/Kolkata');
    
                                            DB::table('booking_assigned_td')->insertGetId([
                                                'booking_assigned_td_booking_id' => $order->booking_id,
                                                'booking_assigned_td_driver_id' => $driver_id,
                                                'booking_assigned_td_dis_bt_pik_to_dri' => $driver_distance,
                                                'booking_assigned_td_created_date' => time(),
                                                'booking_assigned_td_status' => 1,
                                            ]);
                                            
    
                                            DB::table('driver')->where('driver_id',$driver_id)->update([
                                                'driver_last_booking_notified_time' => time()
                                            ]);
    
                                            DB::table('booking_view')->where('booking_id', $order->booking_id)->update([
                                                'booking_radius' => $bookingInfo->booking_radius+1
                                            ]);
     
                                            DB::commit();
                                        }
                                        catch (\Exception $e) {
                                            // dd("Error");
                                            DB::rollback();
                                            DB::table('a_cronjob_runtime')->insert([
                                                'a_cronjob_runtime' => time(),
                                                'a_cronjob_runtime_status' => '1', 
                                            ]); 
                                            // something went wrong
                                        }
                                    }
                                }    
                            } else {
                                goto increaseRadius;
                            }
                        }

                    }
            }
            
        } 
        try{
            DB::beginTransaction();
            DB::table('a_cronjob_runtime')->insert([
                'a_cronjob_runtime' => time(),
                'a_cronjob_runtime_status' => '0', 
            ]);
            DB::commit();
        } catch (\Exception $e) {
            // dd("Error");
            DB::rollback();
            DB::table('a_cronjob_runtime')->insert([
                'a_cronjob_runtime' => time(),
                'a_cronjob_runtime_status' => '1', 
            ]); 
            // something went wrong
        }
    }
    public function shootbookings(Request $request) {
        $bookingArray = DB::table('booking_view')->where('booking_status', 1)->get();
        // print_r($bookingArray);
        if($bookingArray && count($bookingArray) > 0 ) {
            foreach($bookingArray AS $order) {
                    increaseRadius:
                    $bookingInfo = DB::table('booking_view')->where('booking_id', $order->booking_id)->first();

                    if($bookingInfo && $bookingInfo->booking_status == 1) {
                        // dd($bookingInfo);
                        $pickup_lat = $bookingInfo->booking_pick_lat;
                        $pickup_long = $bookingInfo->booking_pick_long;
                        if($bookingInfo->booking_radius <= 5) {
                            $radius = ($bookingInfo->booking_radius+1);
                            $nearest_drivers = DB::select("SELECT * , (6371 * 2 * ASIN(SQRT( POWER(SIN(( $pickup_lat- driver_live_location_lat) * pi()/180 / 2), 2) +COS( $pickup_lat * pi()/180) * COS(driver_live_location_lat * pi()/180) * POWER(SIN(( $pickup_long - driver_live_location_long) * pi()/180 / 2), 2) ))) as distance , ROUND((UNIX_TIMESTAMP()-driver_live_location.driver_live_location_updated_time) / 60, 0) as time_diff , ROUND((UNIX_TIMESTAMP()-driver.driver_last_booking_notified_time) / 60, 0) as last_booking from driver_live_location LEFT JOIN driver ON driver.driver_id =driver_live_location.driver_live_location_d_id LEFT JOIN vehicle ON vehicle.vehicle_id= driver.driver_assigned_vehicle_id WHERE driver.driver_on_booking_status = '0' AND driver.driver_duty_status= 'ON' AND driver_id NOT IN(SELECT booking_assigned_td_driver_id FROM booking_assigned_td WHERE booking_assigned_td_booking_id=$order->booking_id AND booking_assigned_td_status=1) having distance <= $radius AND time_diff <= 100 AND last_booking >= .60 order by distance LIMIT 10 ");
    
                            if($nearest_drivers && count($nearest_drivers) > 0) {
                                foreach ($nearest_drivers as $nav) {
                                    $driver_id = $nav->driver_id;
                                    $driver_fcm_token = $nav->driver_fcm_token;
                                    $driver_distance = $nav->distance;
                                    if (!empty($driver_fcm_token)) {
                                        $dataArray = ['enquiry_id' => $order->booking_id, 'driver_id' => $driver_id, 'key1' => '1'];
                                        $result = app('App\Http\Controllers\SendNotificationController')->send_notification($request, $dataArray);
                                        try{
                                            DB::beginTransaction();
                                            date_default_timezone_set('Asia/Kolkata');
    
                                            DB::table('booking_assigned_td')->insertGetId([
                                                'booking_assigned_td_booking_id' => $order->booking_id,
                                                'booking_assigned_td_driver_id' => $driver_id,
                                                'booking_assigned_td_dis_bt_pik_to_dri' => $driver_distance,
                                                'booking_assigned_td_created_date' => time(),
                                                'booking_assigned_td_status' => 1,
                                            ]);
                                            
    
                                            DB::table('driver')->where('driver_id',$driver_id)->update([
                                                'driver_last_booking_notified_time' => time()
                                            ]);
    
                                            DB::table('booking_view')->where('booking_id', $order->booking_id)->update([
                                                'booking_radius' => $bookingInfo->booking_radius+1
                                            ]);
     
                                            DB::commit();
                                        }
                                        catch (\Exception $e) {
                                            // dd("Error");
                                            DB::rollback();
                                            DB::table('a_cronjob_runtime')->insert([
                                                'a_cronjob_runtime' => time(),
                                                'a_cronjob_runtime_status' => '1', 
                                            ]); 
                                            // something went wrong
                                        }
                                    }
                                }    
                            } else {
                                try{
                                    DB::beginTransaction();
                                    date_default_timezone_set('Asia/Kolkata');
                                    DB::table('booking_view')->where('booking_id', $order->booking_id)->update([
                                        'booking_radius' => $bookingInfo->booking_radius+1
                                    ]);

                                    DB::commit();
                                    goto increaseRadius;
                                }
                                catch (\Exception $e) {
                                    // dd("Error");
                                    DB::rollback();
                                    DB::table('a_cronjob_runtime')->insert([
                                        'a_cronjob_runtime' => time(),
                                        'a_cronjob_runtime_status' => '1', 
                                    ]); 
                                    // something went wrong
                                }

                            }
                        }

                    }
            }
            
        } 
        try{
            DB::beginTransaction();
            DB::table('a_cronjob_runtime')->insert([
                'a_cronjob_runtime' => time(),
                'a_cronjob_runtime_status' => '0', 
            ]);
            DB::commit();
        } catch (\Exception $e) {
            // dd("Error");
            DB::rollback();
            DB::table('a_cronjob_runtime')->insert([
                'a_cronjob_runtime' => time(),
                'a_cronjob_runtime_status' => '1', 
            ]); 
            // something went wrong
        }
    }
// booking shoot to assign driver start


}
