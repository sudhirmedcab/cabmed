<?php

namespace App\Livewire\Admin\Ambulance;

use Livewire\Component;
use Illuminate\Support\Facades\DB; 
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Http\Response;

class AmbulanceBookingDetails extends Component
{
    public $bookingId,$booking_addons_1,$booking_trans_1,$merged_data_1,$data_1,$driverData,$id,$driverid,$cancelReason,
    $canceled_by;
    public $isCancelBookingOpen = 0;

    public function render()
    {
        // dd($this->bookingId);
        $id=$this->bookingId;
        $booking_data =  DB::table('booking_view')
        ->where('booking_view.booking_id',$id)
        ->get();
        // $this->DriverDataGet2($id);
// dd($booking_data,count($booking_data));
// dd(count($booking_data));
        if (count($booking_data)>0) {
            $booking_status = $booking_data[0]->booking_status;
            // dd('booking_status',$booking_status);
            if($booking_status =='0'){
                $data['booking_list'] = DB::table('booking_view')
                ->leftjoin('consumer','booking_view.booking_by_cid','=','consumer.consumer_id')
                ->leftjoin('driver','booking_view.booking_acpt_driver_id','=','driver.driver_id')
                ->leftjoin('driver_live_location','booking_view.booking_acpt_driver_id','=','driver_live_location.driver_live_location_d_id')
                ->leftjoin('ambulance_category', 'booking_view.booking_category', '=', 'ambulance_category.ambulance_category_type')
                ->leftjoin('booking_driver_distance', 'booking_view.booking_id', '=', 'booking_driver_distance.bdd_booking_id')
                ->where([
                    ['booking_view.booking_status', '=', '0'],
                    ['booking_view.booking_id', '=', $id]    
                    ])
                ->orderBy('booking_view.booking_id','desc')
                ->first(); 
            // dd($data);
                $buket_map_data = [];

                foreach($data as $location_data){
                    $add_data['booking_id'] = $location_data->booking_id;
                    $add_data['driver_live_location_lat'] = $location_data->driver_live_location_lat;
                    $add_data['driver_live_location_long'] = $location_data->driver_live_location_long;
                    $add_data['booking_drop_lat'] = $location_data->booking_drop_lat;
                    $add_data['booking_drop_long'] = $location_data->booking_drop_long;
                    $add_data['booking_pick_lat'] = $location_data->booking_pick_lat;
                    $add_data['booking_pick_long'] = $location_data->booking_pick_long;
                    $add_data['driver_name'] = $location_data->driver_name;
                    $add_data['driver_last_name'] = $location_data->driver_last_name;
                    $unix_time = $location_data->driver_live_location_updated_time; 
        
                    $carbonDateTime = Carbon::createFromTimestamp($unix_time);
                    $normalDateTime = $carbonDateTime->toDateTimeString();
                    // $data = $convertedDates;
                    $currentDateTime = Carbon::now();  
                    $carbonDate = Carbon::parse($normalDateTime);
                    $hoursDifference = $carbonDate->diffInHours($currentDateTime);
                    $daysDifference = $carbonDate->diffInDays($currentDateTime);
                    // Format the date difference as a human-readable message
                    $add_data['time_diffrence'] =  $carbonDate->diffForHumans();
        
                    array_push($buket_map_data, $add_data);
                }  

                $data['booking'] = $buket_map_data; 
            
            $booking_addons = DB::table('booking_view')  
                            ->rightjoin('booking_addons', 'booking_view.booking_id', '=', 'booking_addons.booking_id')
                             ->where('booking_view.booking_id','=',$id)
                             ->get();

            $booking_trans = DB::table('booking_view')  
                            ->rightjoin('booking_payments', 'booking_view.booking_id', '=', 'booking_payments.booking_id')
                             ->where('booking_view.booking_id','=',$id)
                             ->get();
                             
                 // Function to calculate distance between two sets of coordinates
        function calculateDistance($lat1, $lon1, $lat2, $lon2) {
            $earthRadius = 6371; // Earth's radius in kilometers

            $dLat = deg2rad($lat2 - $lat1);
            $dLon = deg2rad($lon2 - $lon1);

            $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

            $distance = $earthRadius * $c; // Distance in kilometers

            return $distance;
        }

        // Your existing code to retrieve booking assignment details
        $booking_assign = DB::table('booking_assigned_td')
            ->leftJoin('driver', 'driver.driver_id', '=', 'booking_assigned_td.booking_assigned_td_driver_id')
            ->leftJoin('booking_view', 'booking_view.booking_id', '=', 'booking_assigned_td.booking_assigned_td_booking_id')
            ->leftJoin('vehicle', 'vehicle.vehicle_id', '=', 'driver.driver_assigned_vehicle_id')
            ->leftJoin('ambulance_category', 'ambulance_category.ambulance_category_type', '=', 'vehicle.vehicle_category_type')
            ->where('booking_assigned_td.booking_assigned_td_booking_id', '=', $id)
            ->orderByDesc('booking_assigned_td.booking_assigned_td_id')
            ->get();

        $merged_data = [];

        if ($booking_assign) {
            foreach ($booking_assign as $assign) {
                // Get driver data related to the booking assignment
                $driver_data = DB::table('booking_assigned_td')
                    ->leftJoin('booking_view', 'booking_view.booking_id', '=', 'booking_assigned_td.booking_assigned_td_booking_id')
                    ->leftJoin('driver_live_location_his', 'driver_live_location_his.driver_live_location_his_d_id', '=', 'booking_assigned_td.booking_assigned_td_driver_id')
                    ->where('booking_view.booking_id', $id)
                    ->where('booking_assigned_td.booking_assigned_td_id', $assign->booking_assigned_td_id)
                    ->select('driver_live_location_his.driver_live_location_his_d_id', 'driver_live_location_his.driver_live_location_his_lat', 'driver_live_location_his.driver_live_location_his_long', 'booking_view.booking_pick_lat', 'booking_view.booking_pick_long')
                    ->distinct()
                    ->first();

                if ($driver_data) {
                    // Calculate distance between pick location and driver location
                    $distance_km = calculateDistance(
                        $driver_data->booking_pick_lat,
                        $driver_data->booking_pick_long,
                        $driver_data->driver_live_location_his_lat,
                        $driver_data->driver_live_location_his_long
                    );

                    // Format distance to two decimal places and concatenate " km" string
                    $formatted_distance = number_format($distance_km, 2) . ' km';

                    // Add formatted distance to the driver_data object
                    $driver_data->formatted_distance = $formatted_distance;

                    // Merge driver data and booking assignment data into a single object
                    $merged_data[] = (object) array_merge((array) $assign, (array) $driver_data);
                        }
                    }
                } 
                    return view('livewire.admin.ambulance.ambulance-booking-details', [
                        'booking_addons' => $booking_addons,
                        'booking_trans' => $booking_trans,
                        'merged_data' => $merged_data,
                        'data' => $data
                    ])->layout('livewire.admin.layouts.base');
            
 
            }elseif ($booking_status == 1){
                
                $array1 = ['apple', 'banana', 'orange'];
$array2 = ['carrot', 'lettuce', 'tomato'];

$mergedArray = array_merge($array1, $array2);
// dd($array1,$array2,$mergedArray);
                $data['booking_list'] = DB::table('booking_view')
                                    ->leftjoin('consumer','booking_view.booking_by_cid','=','consumer.consumer_id')
                                    ->leftjoin('driver','booking_view.booking_acpt_driver_id','=','driver.driver_id')
                                    ->leftjoin('driver_live_location','booking_view.booking_acpt_driver_id','=','driver_live_location.driver_live_location_d_id')
                                    ->leftjoin('ambulance_category', 'booking_view.booking_category', '=', 'ambulance_category.ambulance_category_type')
                                    ->leftjoin('booking_driver_distance', 'booking_view.booking_id', '=', 'booking_driver_distance.bdd_booking_id')
                                    ->where([
                                        ['booking_view.booking_status', '=', '1'],
                                        ['booking_view.booking_id', '=', $id]    
                                        ])
                                    ->orderBy('booking_view.booking_id','desc')
                                    ->first(); 
                                    // dd('booking_list with booking status 1', $data);
                         $buket_map_data = [];

                                    foreach($data as $location_data){
                                        $add_data['booking_id'] = $location_data->booking_id;
                                        $add_data['driver_live_location_lat'] = $location_data->driver_live_location_lat;
                                        $add_data['driver_live_location_long'] = $location_data->driver_live_location_long;
                                        $add_data['booking_drop_lat'] = $location_data->booking_drop_lat;
                                        $add_data['booking_drop_long'] = $location_data->booking_drop_long;
                                        $add_data['booking_pick_lat'] = $location_data->booking_pick_lat;
                                        $add_data['booking_pick_long'] = $location_data->booking_pick_long;
                                        $add_data['driver_name'] = $location_data->driver_name;
                                        $add_data['driver_last_name'] = $location_data->driver_last_name;
                                        $unix_time = $location_data->driver_live_location_updated_time; 
                            
                                        $carbonDateTime = Carbon::createFromTimestamp($unix_time);
                                        $normalDateTime = $carbonDateTime->toDateTimeString();
                                        // $data = $convertedDates;
                                        $currentDateTime = Carbon::now();  
                                        $carbonDate = Carbon::parse($normalDateTime);
                                        $hoursDifference = $carbonDate->diffInHours($currentDateTime);
                                        $daysDifference = $carbonDate->diffInDays($currentDateTime);
                                        // Format the date difference as a human-readable message
                                        $add_data['time_diffrence'] =  $carbonDate->diffForHumans();
                            
                                        array_push($buket_map_data, $add_data);
                                    }  

                                    $data['booking'] = $buket_map_data;                    

                   $booking_addons = DB::table('booking_view')  
                                    ->rightjoin('booking_addons', 'booking_view.booking_id', '=', 'booking_addons.booking_id')
                                     ->where('booking_view.booking_id','=',$id)
                                     ->get();
        
                    $booking_trans = DB::table('booking_view')  
                                    ->rightjoin('booking_payments', 'booking_view.booking_id', '=', 'booking_payments.booking_id')
                                     ->where('booking_view.booking_id','=',$id)
                                     ->get();
                    $booking_trans1 = DB::table('booking_view')  
                                    ->leftjoin('booking_payments', 'booking_view.booking_id', '=', 'booking_payments.booking_id')
                                    ->where('booking_view.booking_id','=',$id)
                                    ->get();
                    // dd($booking_trans,$booking_trans1);
                // Function to calculate distance between two sets of coordinates
                // dd($data);
                function calculateDistance($lat1, $lon1, $lat2, $lon2) {
                    $earthRadius = 6371; // Earth's radius in kilometers
        
                    $dLat = deg2rad($lat2 - $lat1);
                    $dLon = deg2rad($lon2 - $lon1);
        
                    $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
                    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        
                    $distance = $earthRadius * $c; // Distance in kilometers
        
                    return $distance;
                }
                // Your existing code to retrieve booking assignment details
    //             $booking_assign = DB::table('booking_assigned_td')
    // ->join('driver', 'driver.driver_id', '=', 'booking_assigned_td.booking_assigned_td_driver_id')
    // ->join('booking_view', 'booking_view.booking_id', '=', 'booking_assigned_td.booking_assigned_td_booking_id')
    // ->join('vehicle', 'vehicle.vehicle_id', '=', 'driver.driver_assigned_vehicle_id')
    // ->join('ambulance_category', 'ambulance_category.ambulance_category_type', '=', 'vehicle.vehicle_category_type')
    // ->join('driver_live_location_his', 'driver_live_location_his.driver_live_location_his_d_id', '=', 'booking_assigned_td.booking_assigned_td_driver_id')
    // ->where('booking_assigned_td.booking_assigned_td_booking_id', '=', $id)
    // ->orderByDesc('booking_assigned_td.booking_assigned_td_id')
    // ->get();
 
                    $booking_assign = DB::table('booking_assigned_td')
                        ->join('driver', 'driver.driver_id', '=', 'booking_assigned_td.booking_assigned_td_driver_id')
                        ->join('booking_view', 'booking_view.booking_id', '=', 'booking_assigned_td.booking_assigned_td_booking_id')
                        ->join('vehicle', 'vehicle.vehicle_id', '=', 'driver.driver_assigned_vehicle_id')
                        ->join('ambulance_category', 'ambulance_category.ambulance_category_type', '=', 'vehicle.vehicle_category_type')
                        // ->join('driver_live_location_his', 'driver_live_location_his.driver_live_location_his_d_id', '=', 'booking_assigned_td.booking_assigned_td_driver_id')
                        ->leftjoin('driver_live_location','driver_live_location.driver_live_location_d_id','=','booking_assigned_td.booking_assigned_td_driver_id')
                        ->leftjoin('city','city.city_id', '=', 'driver.driver_city_id')
                        ->leftjoin('partner','partner.partner_id','=','driver.driver_created_partner_id')
                        ->where('booking_assigned_td.booking_assigned_td_booking_id', '=', $id)
                        ->orderByDesc('booking_assigned_td.booking_assigned_td_id')
                        ->get();

        // dd($booking_assign);
                $merged_data = [];
         
                if ($booking_assign) {
                    foreach ($booking_assign as $assign) {
                        // Get driver data related to the booking assignment
                        $driver_data = DB::table('booking_assigned_td')
                            ->leftJoin('booking_view', 'booking_view.booking_id', '=', 'booking_assigned_td.booking_assigned_td_booking_id')
                            ->leftJoin('driver_live_location_his', 'driver_live_location_his.driver_live_location_his_d_id', '=', 'booking_assigned_td.booking_assigned_td_driver_id')
                            ->where('booking_view.booking_id', $id)
                            ->where('booking_assigned_td.booking_assigned_td_id', $assign->booking_assigned_td_id)
                            ->select('driver_live_location_his.driver_live_location_his_d_id', 'driver_live_location_his.driver_live_location_his_lat', 'driver_live_location_his.driver_live_location_his_long', 'booking_view.booking_pick_lat', 'booking_view.booking_pick_long')
                            ->distinct()
                            ->first();
        
                        if ($driver_data) {
                            // Calculate distance between pick location and driver location
                            if(isset($assign->driver_live_location_lat) && isset($assign->driver_live_location_long)){
                            $distance_km = calculateDistance(
                                $assign->booking_pick_lat,
                                $assign->booking_pick_long,
                                $assign->driver_live_location_lat,
                                $assign->driver_live_location_long
                            );
        
                            // Format distance to two decimal places and concatenate " km" string
                            $formatted_distance = number_format($distance_km, 2) . ' km';
                            // Add formatted distance to the driver_data object
                            $driver_data->formatted_distance = $formatted_distance;
                            }
                            else
                            {
                                $driver_data->formatted_distance = 'N/A';
                            }
                            // Merge driver data and booking assignment data into a single object
                            $merged_data[] = (object) array_merge((array) $assign, (array) $driver_data);
                        }
                    }
                } 
                        // dd($booking_addons,$booking_trans,$merged_data,$data);  
                        //   dd($merged_data);


        
                        // dd($buket_map_data);
                                return view('livewire.admin.ambulance.ambulance-booking-details', [
                                    'booking_addons' => $booking_addons,
                                    'booking_trans' => $booking_trans,
                                    'notifiedDriversList' => $merged_data,
                                    'data' => $data,
                                    'driverList'=>$this->DriverDataGet2($id),
                                    'buket_map_data' =>$buket_map_data
                                ])->layout('livewire.admin.layouts.base');
        
                                return view('livewire.admin.ambulance.ambulance-booking-details',compact('booking_addons','booking_trans','merged_data'),$data); 
               
            }elseif ($booking_status =='2'){
                $data['booking_list'] = DB::table('booking_view')
                                    ->leftjoin('consumer','booking_view.booking_by_cid','=','consumer.consumer_id')
                                    ->leftjoin('driver','booking_view.booking_acpt_driver_id','=','driver.driver_id')
                                    ->leftjoin('vehicle','vehicle.vehicle_id','=','booking_view.booking_acpt_vehicle_id')
                                    ->leftjoin('driver_live_location','booking_view.booking_acpt_driver_id','=','driver_live_location.driver_live_location_d_id')
                                    ->leftjoin('ambulance_category', 'booking_view.booking_category', '=', 'ambulance_category.ambulance_category_type')
                                    ->leftjoin('booking_driver_distance', 'booking_view.booking_id', '=', 'booking_driver_distance.bdd_booking_id')
                                    ->where([
                                        ['booking_view.booking_status', '=', '2'],
                                        ['booking_view.booking_id', '=', $id]    
                                        ])
                                    ->orderBy('booking_view.booking_id','desc')
                                    ->first(); 

                             $buket_map_data = [];

                                    foreach($data as $location_data){
                                        $add_data['booking_id'] = $location_data->booking_id;
                                        $add_data['driver_live_location_lat'] = $location_data->driver_live_location_lat;
                                        $add_data['driver_live_location_long'] = $location_data->driver_live_location_long;
                                        $add_data['booking_drop_lat'] = $location_data->booking_drop_lat;
                                        $add_data['booking_drop_long'] = $location_data->booking_drop_long;
                                        $add_data['booking_pick_lat'] = $location_data->booking_pick_lat;
                                        $add_data['booking_pick_long'] = $location_data->booking_pick_long;
                                        $add_data['driver_name'] = $location_data->driver_name;
                                        $add_data['driver_last_name'] = $location_data->driver_last_name;
                                        $unix_time = $location_data->driver_live_location_updated_time; 
                            
                                        $carbonDateTime = Carbon::createFromTimestamp($unix_time);
                                        $normalDateTime = $carbonDateTime->toDateTimeString();
                                        // $data = $convertedDates;
                                        $currentDateTime = Carbon::now();  
                                        $carbonDate = Carbon::parse($normalDateTime);
                                        $hoursDifference = $carbonDate->diffInHours($currentDateTime);
                                        $daysDifference = $carbonDate->diffInDays($currentDateTime);
                                        // Format the date difference as a human-readable message
                                        $add_data['time_diffrence'] =  $carbonDate->diffForHumans();
                            
                                        array_push($buket_map_data, $add_data);
                                    }  

                                    $data['booking'] = $buket_map_data; 
                                
                    $booking_addons = DB::table('booking_view')  
                                    ->rightjoin('booking_addons', 'booking_view.booking_id', '=', 'booking_addons.booking_id')
                                     ->where('booking_view.booking_id','=',$id)
                                     ->get();

                     $booking_trans = DB::table('booking_view')  
                                     ->rightjoin('booking_payments', 'booking_view.booking_id', '=', 'booking_payments.booking_id')
                                      ->where('booking_view.booking_id','=',$id)
                                      ->get();

                    // Function to calculate distance between two sets of coordinates
                        function calculateDistance($lat1, $lon1, $lat2, $lon2) {
                            $earthRadius = 6371; // Earth's radius in kilometers

                            $dLat = deg2rad($lat2 - $lat1);
                            $dLon = deg2rad($lon2 - $lon1);

                            $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
                            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

                            $distance = $earthRadius * $c; // Distance in kilometers

                            return $distance;
                        }

                        // Your existing code to retrieve booking assignment details
                        $booking_assign = DB::table('booking_assigned_td')
                            ->leftJoin('driver', 'driver.driver_id', '=', 'booking_assigned_td.booking_assigned_td_driver_id')
                            ->leftJoin('booking_view', 'booking_view.booking_id', '=', 'booking_assigned_td.booking_assigned_td_booking_id')
                            ->leftJoin('vehicle', 'vehicle.vehicle_id', '=', 'driver.driver_assigned_vehicle_id')
                            ->leftJoin('ambulance_category', 'ambulance_category.ambulance_category_type', '=', 'vehicle.vehicle_category_type')
                            ->where('booking_assigned_td.booking_assigned_td_booking_id', '=', $id)
                            ->orderByDesc('booking_assigned_td.booking_assigned_td_id')
                            ->get();

                        $merged_data = [];

                        if ($booking_assign) {
                            foreach ($booking_assign as $assign) {
                                // Get driver data related to the booking assignment
                                $driver_data = DB::table('booking_assigned_td')
                                    ->leftJoin('booking_view', 'booking_view.booking_id', '=', 'booking_assigned_td.booking_assigned_td_booking_id')
                                    ->leftJoin('driver_live_location_his', 'driver_live_location_his.driver_live_location_his_d_id', '=', 'booking_assigned_td.booking_assigned_td_driver_id')
                                    ->where('booking_view.booking_id', $id)
                                    ->where('booking_assigned_td.booking_assigned_td_id', $assign->booking_assigned_td_id)
                                    ->select('driver_live_location_his.driver_live_location_his_d_id', 'driver_live_location_his.driver_live_location_his_lat', 'driver_live_location_his.driver_live_location_his_long', 'booking_view.booking_pick_lat', 'booking_view.booking_pick_long')
                                    ->distinct()
                                    ->first();

                                if ($driver_data) {
                                    // Calculate distance between pick location and driver location
                                    $distance_km = calculateDistance(
                                        $driver_data->booking_pick_lat,
                                        $driver_data->booking_pick_long,
                                        $driver_data->driver_live_location_his_lat,
                                        $driver_data->driver_live_location_his_long
                                    );

                                    // Format distance to two decimal places and concatenate " km" string
                                    $formatted_distance = number_format($distance_km, 2) . ' km';

                                    // Add formatted distance to the driver_data object
                                    $driver_data->formatted_distance = $formatted_distance;

                                    // Merge driver data and booking assignment data into a single object
                                    $merged_data[] = (object) array_merge((array) $assign, (array) $driver_data);
                                }
                            }
                        }
                                    
                     return view('livewire.admin.ambulance.ambulance-booking-details',compact('booking_addons','booking_trans','merged_data'),$data); 
               
            }elseif ($booking_status =='3'){
                $data['booking_list'] = DB::table('booking_view')
                                    ->leftjoin('booking_invoice','booking_invoice.bi_booking_id','=','booking_view.booking_id')
                                    ->leftjoin('consumer','booking_view.booking_by_cid','=','consumer.consumer_id')
                                    ->leftjoin('driver','booking_view.booking_acpt_driver_id','=','driver.driver_id')
                                    ->leftjoin('vehicle','vehicle.vehicle_id','=','booking_view.booking_acpt_vehicle_id')
                                    ->leftjoin('driver_live_location','booking_view.booking_acpt_driver_id','=','driver_live_location.driver_live_location_d_id')
                                    ->leftjoin('ambulance_category', 'booking_view.booking_category', '=', 'ambulance_category.ambulance_category_type')
                                    ->leftjoin('booking_driver_distance', 'booking_view.booking_id', '=', 'booking_driver_distance.bdd_booking_id')
                                    ->where([
                                        ['booking_view.booking_status', '=', '3'],
                                        ['booking_view.booking_id', '=', $id]    
                                        ])
                                    ->orderBy('booking_view.booking_id','desc')
                                    ->first();
                
                                    $buket_map_data = [];

                                    foreach($data as $location_data){
                                        $add_data['booking_id'] = $location_data->booking_id;
                                        $add_data['driver_live_location_lat'] = $location_data->driver_live_location_lat;
                                        $add_data['driver_live_location_long'] = $location_data->driver_live_location_long;
                                        $add_data['booking_drop_lat'] = $location_data->booking_drop_lat;
                                        $add_data['booking_drop_long'] = $location_data->booking_drop_long;
                                        $add_data['booking_pick_lat'] = $location_data->booking_pick_lat;
                                        $add_data['booking_pick_long'] = $location_data->booking_pick_long;
                                        $add_data['driver_name'] = $location_data->driver_name;
                                        $add_data['driver_last_name'] = $location_data->driver_last_name;
                                        $unix_time = $location_data->driver_live_location_updated_time; 
                            
                                        $carbonDateTime = Carbon::createFromTimestamp($unix_time);
                                        $normalDateTime = $carbonDateTime->toDateTimeString();
                                        // $data = $convertedDates;
                                        $currentDateTime = Carbon::now();  
                                        $carbonDate = Carbon::parse($normalDateTime);
                                        $hoursDifference = $carbonDate->diffInHours($currentDateTime);
                                        $daysDifference = $carbonDate->diffInDays($currentDateTime);
                                        // Format the date difference as a human-readable message
                                        $add_data['time_diffrence'] =  $carbonDate->diffForHumans();
                            
                                        array_push($buket_map_data, $add_data);
                                    }  

                                    $data['booking'] = $buket_map_data;                      

           $booking_addons = DB::table('booking_view')  
                            ->rightjoin('booking_addons', 'booking_view.booking_id', '=', 'booking_addons.booking_id')
                             ->where('booking_view.booking_id','=',$id)
                             ->get();

            $booking_trans = DB::table('booking_view')  
                            ->rightjoin('booking_payments', 'booking_view.booking_id', '=', 'booking_payments.booking_id')
                             ->where('booking_view.booking_id','=',$id)
                             ->get();
            
             
        // Function to calculate distance between two sets of coordinates
        function calculateDistance($lat1, $lon1, $lat2, $lon2) {
            $earthRadius = 6371; // Earth's radius in kilometers

            $dLat = deg2rad($lat2 - $lat1);
            $dLon = deg2rad($lon2 - $lon1);

            $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

            $distance = $earthRadius * $c; // Distance in kilometers

            return $distance;
        }

        // Your existing code to retrieve booking assignment details
        $booking_assign = DB::table('booking_assigned_td')
            ->leftJoin('driver', 'driver.driver_id', '=', 'booking_assigned_td.booking_assigned_td_driver_id')
            ->leftJoin('booking_view', 'booking_view.booking_id', '=', 'booking_assigned_td.booking_assigned_td_booking_id')
            ->leftJoin('vehicle', 'vehicle.vehicle_id', '=', 'driver.driver_assigned_vehicle_id')
            ->leftJoin('ambulance_category', 'ambulance_category.ambulance_category_type', '=', 'vehicle.vehicle_category_type')
            ->where('booking_assigned_td.booking_assigned_td_booking_id', '=', $id)
            ->orderByDesc('booking_assigned_td.booking_assigned_td_id')
            ->get();

        $merged_data = [];

        if ($booking_assign) {
            foreach ($booking_assign as $assign) {
                // Get driver data related to the booking assignment
                $driver_data = DB::table('booking_assigned_td')
                    ->leftJoin('booking_view', 'booking_view.booking_id', '=', 'booking_assigned_td.booking_assigned_td_booking_id')
                    ->leftJoin('driver_live_location_his', 'driver_live_location_his.driver_live_location_his_d_id', '=', 'booking_assigned_td.booking_assigned_td_driver_id')
                    ->where('booking_view.booking_id', $id)
                    ->where('booking_assigned_td.booking_assigned_td_id', $assign->booking_assigned_td_id)
                    ->select('driver_live_location_his.driver_live_location_his_d_id', 'driver_live_location_his.driver_live_location_his_lat', 'driver_live_location_his.driver_live_location_his_long', 'booking_view.booking_pick_lat', 'booking_view.booking_pick_long')
                    ->distinct()
                    ->first();

                if ($driver_data) {
                    // Calculate distance between pick location and driver location
                    $distance_km = calculateDistance(
                        $driver_data->booking_pick_lat,
                        $driver_data->booking_pick_long,
                        $driver_data->driver_live_location_his_lat,
                        $driver_data->driver_live_location_his_long
                    );

                    // Format distance to two decimal places and concatenate " km" string
                    $formatted_distance = number_format($distance_km, 2) . ' km';

                    // Add formatted distance to the driver_data object
                    $driver_data->formatted_distance = $formatted_distance;

                    // Merge driver data and booking assignment data into a single object
                    $merged_data[] = (object) array_merge((array) $assign, (array) $driver_data);
                }
            }
        } 

                             return view('livewire.admin.ambulance.ambulance-booking-details',compact('booking_addons','booking_trans','merged_data'),$data); 
                            }elseif($booking_status =='4'){
                                    $data['booking_list'] = DB::table('booking_view')
                                    ->leftjoin('booking_invoice','booking_invoice.bi_booking_id','=','booking_view.booking_id')
                                    ->leftjoin('consumer','booking_view.booking_by_cid','=','consumer.consumer_id')
                                    ->leftjoin('driver','booking_view.booking_acpt_driver_id','=','driver.driver_id')
                                    ->leftjoin('vehicle','vehicle.vehicle_id','=','booking_view.booking_acpt_vehicle_id')
                                    ->leftjoin('driver_live_location','booking_view.booking_acpt_driver_id','=','driver_live_location.driver_live_location_d_id')
                                    ->leftjoin('ambulance_category', 'booking_view.booking_category', '=', 'ambulance_category.ambulance_category_type')
                                    ->leftjoin('booking_driver_distance', 'booking_view.booking_id', '=', 'booking_driver_distance.bdd_booking_id')
                                    ->where([
                                        ['booking_view.booking_status', '=', '4'],
                                        ['booking_view.booking_id', '=', $id]    
                                        ])
                                    ->orderBy('booking_view.booking_id','desc')
                                    ->first();  
                                    // dd('booking status is 4',$data);
                                    $buket_map_data = [];

                                        foreach($data as $location_data){
                                            $add_data['booking_id'] = $location_data->booking_id;
                                            $add_data['driver_live_location_lat'] = $location_data->driver_live_location_lat;
                                            $add_data['driver_live_location_long'] = $location_data->driver_live_location_long;
                                            $add_data['booking_drop_lat'] = $location_data->booking_drop_lat;
                                            $add_data['booking_drop_long'] = $location_data->booking_drop_long;
                                            $add_data['booking_pick_lat'] = $location_data->booking_pick_lat;
                                            $add_data['booking_pick_long'] = $location_data->booking_pick_long;
                                            $add_data['driver_name'] = $location_data->driver_name;
                                            $add_data['driver_last_name'] = $location_data->driver_last_name;
                                            $unix_time = $location_data->driver_live_location_updated_time; 
                                
                                            $carbonDateTime = Carbon::createFromTimestamp($unix_time);
                                            $normalDateTime = $carbonDateTime->toDateTimeString();
                                            // $data = $convertedDates;
                                            $currentDateTime = Carbon::now();  
                                            $carbonDate = Carbon::parse($normalDateTime);
                                            $hoursDifference = $carbonDate->diffInHours($currentDateTime);
                                            $daysDifference = $carbonDate->diffInDays($currentDateTime);
                                            // Format the date difference as a human-readable message
                                            $add_data['time_diffrence'] =  $carbonDate->diffForHumans();
                                
                                            array_push($buket_map_data, $add_data);
                                        }  

                                        $data['booking'] = $buket_map_data; 

                                        $booking_addons = DB::table('booking_view')  
                                                ->rightjoin('booking_addons', 'booking_view.booking_id', '=', 'booking_addons.booking_id')
                                                    ->where('booking_view.booking_id','=',$id)
                                                    ->get();

                                        $booking_trans = DB::table('booking_view')  
                                                ->rightjoin('booking_payments', 'booking_view.booking_id', '=', 'booking_payments.booking_id')
                                                    ->where('booking_view.booking_id','=',$id)
                                                    ->get();

                   // Function to calculate distance between two sets of coordinates
                                        function calculateDistance($lat1, $lon1, $lat2, $lon2) {
                                            $earthRadius = 6371; // Earth's radius in kilometers

                                            $dLat = deg2rad($lat2 - $lat1);
                                            $dLon = deg2rad($lon2 - $lon1);

                                            $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
                                            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

                                            $distance = $earthRadius * $c; // Distance in kilometers

                                            return $distance;
                                        }

                                        // Your existing code to retrieve booking assignment details
                                        $booking_assign = DB::table('booking_assigned_td')
                                            ->leftJoin('driver', 'driver.driver_id', '=', 'booking_assigned_td.booking_assigned_td_driver_id')
                                            ->leftJoin('booking_view', 'booking_view.booking_id', '=', 'booking_assigned_td.booking_assigned_td_booking_id')
                                            ->leftJoin('vehicle', 'vehicle.vehicle_id', '=', 'driver.driver_assigned_vehicle_id')
                                            ->leftJoin('ambulance_category', 'ambulance_category.ambulance_category_type', '=', 'vehicle.vehicle_category_type')
                                            ->where('booking_assigned_td.booking_assigned_td_booking_id', '=', $id)
                                            ->orderByDesc('booking_assigned_td.booking_assigned_td_id')
                                            ->get();
                                            
                                            $booking_assignsudhircode = DB::table('booking_assigned_td')
                                            ->leftJoin('driver', 'driver.driver_id', '=', 'booking_assigned_td.booking_assigned_td_driver_id')
                                            ->leftJoin('booking_view', 'booking_view.booking_id', '=', 'booking_assigned_td.booking_assigned_td_booking_id')
                                            ->leftJoin('vehicle', 'vehicle.vehicle_id', '=', 'driver.driver_assigned_vehicle_id')
                                            ->leftJoin('ambulance_category', 'ambulance_category.ambulance_category_type', '=', 'vehicle.vehicle_category_type')
                                            ->leftJoin('driver_live_location_his', 'driver_live_location_his.driver_live_location_his_d_id', '=', 'booking_assigned_td.booking_assigned_td_driver_id')
                                            ->where('booking_assigned_td.booking_assigned_td_booking_id', '=', $id)
                                            ->orderByDesc('booking_assigned_td.booking_assigned_td_id')
                                            ->select(
                                                'booking_assigned_td.*',
                                                'driver.*',
                                                'booking_view.*',
                                                'vehicle.*',
                                                'ambulance_category.*',
                                                'driver_live_location_his.driver_live_location_his_d_id',
                                                'driver_live_location_his.driver_live_location_his_lat',
                                                'driver_live_location_his.driver_live_location_his_long',
                                                'booking_view.booking_pick_lat',
                                                'booking_view.booking_pick_long'
                                            )
                                            ->distinct()
                                            ->get();

                                            $merged_datasudhircode = $booking_assign->groupBy('booking_assigned_td_id');
                                            // dd($booking_assign,$merged_data0);
                                            $merged_data = [];

                if ($booking_assign) {
                    foreach ($booking_assign as $assign) {
                        // Get driver data related to the booking assignment
                        $driver_data = DB::table('booking_assigned_td')
                            ->leftJoin('booking_view', 'booking_view.booking_id', '=', 'booking_assigned_td.booking_assigned_td_booking_id')
                            ->leftJoin('driver_live_location_his', 'driver_live_location_his.driver_live_location_his_d_id', '=', 'booking_assigned_td.booking_assigned_td_driver_id')
                            ->where('booking_view.booking_id', $id)
                            ->where('booking_assigned_td.booking_assigned_td_id', $assign->booking_assigned_td_id)
                            ->select('driver_live_location_his.driver_live_location_his_d_id', 'driver_live_location_his.driver_live_location_his_lat', 'driver_live_location_his.driver_live_location_his_long', 'booking_view.booking_pick_lat', 'booking_view.booking_pick_long')
                            ->distinct()
                            ->first();

                        if ($driver_data) {
                            // Calculate distance between pick location and driver location
                            $distance_km = calculateDistance(
                                $driver_data->booking_pick_lat,
                                $driver_data->booking_pick_long,
                                $driver_data->driver_live_location_his_lat,
                                $driver_data->driver_live_location_his_long
                            );

                            // Format distance to two decimal places and concatenate " km" string
                            $formatted_distance = number_format($distance_km, 2) . ' km';

                            // Add formatted distance to the driver_data object
                            $driver_data->formatted_distance = $formatted_distance;

                            // Merge driver data and booking assignment data into a single object
                            $merged_data[] = (object) array_merge((array) $assign, (array) $driver_data);
                        }
                    }
                } 
                $data['booking_list']->booking_acpt_time = Carbon::createFromTimestamp($data['booking_list']->booking_acpt_time);
                // dd($merged_data);
                // dd($booking_addons,$booking_trans,$merged_data,$data);

                // return view('livewire.admin.ambulance.ambulance-booking-details',compact('booking_addons','booking_trans','merged_data','data'),$data); 
                return view('livewire.admin.ambulance.ambulance-booking-details', [
                    'booking_addons' => $booking_addons,
                    'booking_trans' => $booking_trans,
                    'buket_map_data' =>$buket_map_data,
                    // 'notifiedDriversList' => $merged_data,
                    'data' => $data
                ])->layout('livewire.admin.layouts.base');

                }elseif($booking_status =='5'){
                $data['booking_list'] = DB::table('booking_view')
                ->leftjoin('booking_invoice','booking_invoice.bi_booking_id','=','booking_view.booking_id')
                ->leftjoin('consumer','booking_view.booking_by_cid','=','consumer.consumer_id')
                ->leftJoin('remark_data', 'remark_data.remark_booking_id', '=', 'booking_view.booking_id')
                ->leftjoin('driver','booking_view.booking_acpt_driver_id','=','driver.driver_id')
                ->leftjoin('vehicle','vehicle.vehicle_id','=','booking_view.booking_acpt_vehicle_id')
                ->leftjoin('driver_live_location','booking_view.booking_acpt_driver_id','=','driver_live_location.driver_live_location_d_id')
                ->leftjoin('ambulance_category', 'booking_view.booking_category', '=', 'ambulance_category.ambulance_category_type')
                ->leftjoin('booking_driver_distance', 'booking_view.booking_id', '=', 'booking_driver_distance.bdd_booking_id')
                ->leftjoin('booking_a_c_history', 'booking_a_c_history.bah_booking_id', '=', 'booking_view.booking_id')
                ->where([
                    ['booking_view.booking_status', '=', '5'],
                    ['booking_view.booking_id', '=', $id]    
                    ])
                ->orderBy('booking_view.booking_id','desc')
                ->first(); 

                // dd($data);

                $buket_map_data = [];

                foreach($data as $location_data){
                    $add_data['booking_id'] = $location_data->booking_id;
                    $add_data['driver_live_location_lat'] = $location_data->driver_live_location_lat;
                    $add_data['driver_live_location_long'] = $location_data->driver_live_location_long;
                    $add_data['booking_drop_lat'] = $location_data->booking_drop_lat;
                    $add_data['booking_drop_long'] = $location_data->booking_drop_long;
                    $add_data['booking_pick_lat'] = $location_data->booking_pick_lat;
                    $add_data['booking_pick_long'] = $location_data->booking_pick_long;
                    $add_data['driver_name'] = $location_data->driver_name;
                    $add_data['driver_last_name'] = $location_data->driver_last_name;
                    $unix_time = $location_data->driver_live_location_updated_time; 
        
                    $carbonDateTime = Carbon::createFromTimestamp($unix_time);
                    $normalDateTime = $carbonDateTime->toDateTimeString();
                    // $data = $convertedDates;
                    $currentDateTime = Carbon::now();  
                    $carbonDate = Carbon::parse($normalDateTime);
                    $hoursDifference = $carbonDate->diffInHours($currentDateTime);
                    $daysDifference = $carbonDate->diffInDays($currentDateTime);
                    // Format the date difference as a human-readable message
                    $add_data['time_diffrence'] =  $carbonDate->diffForHumans();
        
                    array_push($buket_map_data, $add_data);
                }  

                $data['booking'] = $buket_map_data; 
                               
     $booking_addons = DB::table('booking_view')  
                ->rightjoin('booking_addons', 'booking_view.booking_id', '=', 'booking_addons.booking_id')
                 ->where('booking_view.booking_id','=',$id)
                 ->get();

     $booking_trans = DB::table('booking_view')  
                ->rightjoin('booking_payments', 'booking_view.booking_id', '=', 'booking_payments.booking_id')
                 ->where('booking_view.booking_id','=',$id)
                 ->get();
                 
         // Function to calculate distance between two sets of coordinates
         function calculateDistance($lat1, $lon1, $lat2, $lon2) {
            $earthRadius = 6371; // Earth's radius in kilometers

            $dLat = deg2rad($lat2 - $lat1);
            $dLon = deg2rad($lon2 - $lon1);

            $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

            $distance = $earthRadius * $c; // Distance in kilometers

            return $distance;
        }

        // Your existing code to retrieve booking assignment details
        $booking_assign = DB::table('booking_assigned_td')
            ->leftJoin('driver', 'driver.driver_id', '=', 'booking_assigned_td.booking_assigned_td_driver_id')
            ->leftJoin('booking_view', 'booking_view.booking_id', '=', 'booking_assigned_td.booking_assigned_td_booking_id')
            ->leftJoin('vehicle', 'vehicle.vehicle_id', '=', 'driver.driver_assigned_vehicle_id')
            ->leftJoin('ambulance_category', 'ambulance_category.ambulance_category_type', '=', 'vehicle.vehicle_category_type')
            ->where('booking_assigned_td.booking_assigned_td_booking_id', '=', $id)
            ->orderByDesc('booking_assigned_td.booking_assigned_td_id')
            ->get();

        $merged_data = [];

        if ($booking_assign) {
            foreach ($booking_assign as $assign) {
                // Get driver data related to the booking assignment
                $driver_data = DB::table('booking_assigned_td')
                    ->leftJoin('booking_view', 'booking_view.booking_id', '=', 'booking_assigned_td.booking_assigned_td_booking_id')
                    ->leftJoin('driver_live_location_his', 'driver_live_location_his.driver_live_location_his_d_id', '=', 'booking_assigned_td.booking_assigned_td_driver_id')
                    ->where('booking_view.booking_id', $id)
                    ->where('booking_assigned_td.booking_assigned_td_id', $assign->booking_assigned_td_id)
                    ->select('driver_live_location_his.driver_live_location_his_d_id', 'driver_live_location_his.driver_live_location_his_lat', 'driver_live_location_his.driver_live_location_his_long', 'booking_view.booking_pick_lat', 'booking_view.booking_pick_long')
                    ->distinct()
                    ->first();

                if ($driver_data) {
                    // Calculate distance between pick location and driver location
                    $distance_km = calculateDistance(
                        $driver_data->booking_pick_lat,
                        $driver_data->booking_pick_long,
                        $driver_data->driver_live_location_his_lat,
                        $driver_data->driver_live_location_his_long
                    );

                    // Format distance to two decimal places and concatenate " km" string
                    $formatted_distance = number_format($distance_km, 2) . ' km';

                    // Add formatted distance to the driver_data object
                    $driver_data->formatted_distance = $formatted_distance;

                    // Merge driver data and booking assignment data into a single object
                    $merged_data[] = (object) array_merge((array) $assign, (array) $driver_data);
                }
            }
        } 
            //  dd($merged_data);

                 return view('livewire.admin.ambulance.ambulance-booking-details',compact('booking_addons','booking_trans','merged_data'),$data); 
                }elseif($booking_status =='6'){
                    $data['booking_list'] = DB::table('booking_view')
                    ->leftjoin('booking_invoice','booking_invoice.bi_booking_id','=','booking_view.booking_id')
                    ->leftjoin('consumer','booking_view.booking_by_cid','=','consumer.consumer_id')
                    ->leftjoin('driver','booking_view.booking_acpt_driver_id','=','driver.driver_id')
                    ->leftjoin('vehicle','vehicle.vehicle_id','=','booking_view.booking_acpt_vehicle_id')
                    ->leftjoin('driver_live_location','booking_view.booking_acpt_driver_id','=','driver_live_location.driver_live_location_d_id')
                    ->leftjoin('ambulance_category', 'booking_view.booking_category', '=', 'ambulance_category.ambulance_category_type')
                    ->leftjoin('booking_driver_distance', 'booking_view.booking_id', '=', 'booking_driver_distance.bdd_booking_id')
                    ->where([
                        ['booking_view.booking_status', '=', '6'],
                        ['booking_view.booking_id', '=', $id]    
                        ])
                    ->orderBy('booking_view.booking_id','desc')
                    ->first(); 
    
                    $buket_map_data = [];
    
                    foreach($data as $location_data){
                        $add_data['booking_id'] = $location_data->booking_id;
                        $add_data['driver_live_location_lat'] = $location_data->driver_live_location_lat;
                        $add_data['driver_live_location_long'] = $location_data->driver_live_location_long;
                        $add_data['booking_drop_lat'] = $location_data->booking_drop_lat;
                        $add_data['booking_drop_long'] = $location_data->booking_drop_long;
                        $add_data['booking_pick_lat'] = $location_data->booking_pick_lat;
                        $add_data['booking_pick_long'] = $location_data->booking_pick_long;
                        $add_data['driver_name'] = $location_data->driver_name;
                        $add_data['driver_last_name'] = $location_data->driver_last_name;
                        $unix_time = $location_data->driver_live_location_updated_time; 
            
                        $carbonDateTime = Carbon::createFromTimestamp($unix_time);
                        $normalDateTime = $carbonDateTime->toDateTimeString();
                        // $data = $convertedDates;
                        $currentDateTime = Carbon::now();  
                        $carbonDate = Carbon::parse($normalDateTime);
                        $hoursDifference = $carbonDate->diffInHours($currentDateTime);
                        $daysDifference = $carbonDate->diffInDays($currentDateTime);
                        // Format the date difference as a human-readable message
                        $add_data['time_diffrence'] =  $carbonDate->diffForHumans();
            
                        array_push($buket_map_data, $add_data);
                    }  
    
                    $data['booking'] = $buket_map_data; 
                                   
         $booking_addons = DB::table('booking_view')  
                    ->rightjoin('booking_addons', 'booking_view.booking_id', '=', 'booking_addons.booking_id')
                     ->where('booking_view.booking_id','=',$id)
                     ->get();
    
         $booking_trans = DB::table('booking_view')  
                    ->rightjoin('booking_payments', 'booking_view.booking_id', '=', 'booking_payments.booking_id')
                     ->where('booking_view.booking_id','=',$id)
                     ->get();
                     
             // Function to calculate distance between two sets of coordinates
             function calculateDistance($lat1, $lon1, $lat2, $lon2) {
                $earthRadius = 6371; // Earth's radius in kilometers
    
                $dLat = deg2rad($lat2 - $lat1);
                $dLon = deg2rad($lon2 - $lon1);
    
                $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
                $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    
                $distance = $earthRadius * $c; // Distance in kilometers
    
                return $distance;
            }
    
            // Your existing code to retrieve booking assignment details
            $booking_assign = DB::table('booking_assigned_td')
                ->leftJoin('driver', 'driver.driver_id', '=', 'booking_assigned_td.booking_assigned_td_driver_id')
                ->leftJoin('booking_view', 'booking_view.booking_id', '=', 'booking_assigned_td.booking_assigned_td_booking_id')
                ->leftJoin('vehicle', 'vehicle.vehicle_id', '=', 'driver.driver_assigned_vehicle_id')
                ->leftJoin('ambulance_category', 'ambulance_category.ambulance_category_type', '=', 'vehicle.vehicle_category_type')
                ->where('booking_assigned_td.booking_assigned_td_booking_id', '=', $id)
                ->orderByDesc('booking_assigned_td.booking_assigned_td_id')
                ->get();
    
            $merged_data = [];
    
            if ($booking_assign) {
                foreach ($booking_assign as $assign) {
                    // Get driver data related to the booking assignment
                    $driver_data = DB::table('booking_assigned_td')
                        ->leftJoin('booking_view', 'booking_view.booking_id', '=', 'booking_assigned_td.booking_assigned_td_booking_id')
                        ->leftJoin('driver_live_location_his', 'driver_live_location_his.driver_live_location_his_d_id', '=', 'booking_assigned_td.booking_assigned_td_driver_id')
                        ->where('booking_view.booking_id', $id)
                        ->where('booking_assigned_td.booking_assigned_td_id', $assign->booking_assigned_td_id)
                        ->select('driver_live_location_his.driver_live_location_his_d_id', 'driver_live_location_his.driver_live_location_his_lat', 'driver_live_location_his.driver_live_location_his_long', 'booking_view.booking_pick_lat', 'booking_view.booking_pick_long')
                        ->distinct()
                        ->first();
    
                    if ($driver_data) {
                        // Calculate distance between pick location and driver location
                        $distance_km = calculateDistance(
                            $driver_data->booking_pick_lat,
                            $driver_data->booking_pick_long,
                            $driver_data->driver_live_location_his_lat,
                            $driver_data->driver_live_location_his_long
                        );
    
                        // Format distance to two decimal places and concatenate " km" string
                        $formatted_distance = number_format($distance_km, 2) . ' km';
    
                        // Add formatted distance to the driver_data object
                        $driver_data->formatted_distance = $formatted_distance;
    
                        // Merge driver data and booking assignment data into a single object
                        $merged_data[] = (object) array_merge((array) $assign, (array) $driver_data);
                    }
                }
            } 
                //  dd($merged_data);
    
                     return view('livewire.admin.ambulance.ambulance-booking-details',compact('booking_addons','booking_trans','merged_data'),$data); 
                }
                
                else{
              echo "Booking status Not found" ;
            }
        
        }
      
      
        //  return view('livewire.admin.ambulance.ambulance-booking-details');
    }
    
    public function show_booking_list($id)
    {
         $booking_data =  DB::table('booking_view')
        ->where('booking_view.booking_id',$id)
        ->get(); 
// dd($booking_data,count($booking_data));
        if (count($booking_data)>0) {
            $booking_status = $booking_data[0]->booking_status;
            // dd('booking_status',$booking_status);
            if($booking_status =='0'){
                $data['booking_list'] = DB::table('booking_view')
                ->leftjoin('consumer','booking_view.booking_by_cid','=','consumer.consumer_id')
                ->leftjoin('driver','booking_view.booking_acpt_driver_id','=','driver.driver_id')
                ->leftjoin('driver_live_location','booking_view.booking_acpt_driver_id','=','driver_live_location.driver_live_location_d_id')
                ->leftjoin('ambulance_category', 'booking_view.booking_category', '=', 'ambulance_category.ambulance_category_type')
                ->leftjoin('booking_driver_distance', 'booking_view.booking_id', '=', 'booking_driver_distance.bdd_booking_id')
                ->where([
                    ['booking_view.booking_status', '=', '0'],
                    ['booking_view.booking_id', '=', $id]    
                    ])
                ->orderBy('booking_view.booking_id','desc')
                ->first(); 
            // dd($data);
                $buket_map_data = [];

                foreach($data as $location_data){
                    $add_data['booking_id'] = $location_data->booking_id;
                    $add_data['driver_live_location_lat'] = $location_data->driver_live_location_lat;
                    $add_data['driver_live_location_long'] = $location_data->driver_live_location_long;
                    $add_data['booking_drop_lat'] = $location_data->booking_drop_lat;
                    $add_data['booking_drop_long'] = $location_data->booking_drop_long;
                    $add_data['booking_pick_lat'] = $location_data->booking_pick_lat;
                    $add_data['booking_pick_long'] = $location_data->booking_pick_long;
                    $add_data['driver_name'] = $location_data->driver_name;
                    $add_data['driver_last_name'] = $location_data->driver_last_name;
                    $unix_time = $location_data->driver_live_location_updated_time; 
        
                    $carbonDateTime = Carbon::createFromTimestamp($unix_time);
                    $normalDateTime = $carbonDateTime->toDateTimeString();
                    // $data = $convertedDates;
                    $currentDateTime = Carbon::now();  
                    $carbonDate = Carbon::parse($normalDateTime);
                    $hoursDifference = $carbonDate->diffInHours($currentDateTime);
                    $daysDifference = $carbonDate->diffInDays($currentDateTime);
                    // Format the date difference as a human-readable message
                    $add_data['time_diffrence'] =  $carbonDate->diffForHumans();
        
                    array_push($buket_map_data, $add_data);
                }  

                $data['booking'] = $buket_map_data; 
            
            $booking_addons = DB::table('booking_view')  
                            ->rightjoin('booking_addons', 'booking_view.booking_id', '=', 'booking_addons.booking_id')
                             ->where('booking_view.booking_id','=',$id)
                             ->get();

            $booking_trans = DB::table('booking_view')  
                            ->rightjoin('booking_payments', 'booking_view.booking_id', '=', 'booking_payments.booking_id')
                             ->where('booking_view.booking_id','=',$id)
                             ->get();
                 // Function to calculate distance between two sets of coordinates
        function calculateDistance($lat1, $lon1, $lat2, $lon2) {
            $earthRadius = 6371; // Earth's radius in kilometers

            $dLat = deg2rad($lat2 - $lat1);
            $dLon = deg2rad($lon2 - $lon1);

            $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

            $distance = $earthRadius * $c; // Distance in kilometers

            return $distance;
        }

        // Your existing code to retrieve booking assignment details
        $booking_assign = DB::table('booking_assigned_td')
            ->leftJoin('driver', 'driver.driver_id', '=', 'booking_assigned_td.booking_assigned_td_driver_id')
            ->leftJoin('booking_view', 'booking_view.booking_id', '=', 'booking_assigned_td.booking_assigned_td_booking_id')
            ->leftJoin('vehicle', 'vehicle.vehicle_id', '=', 'driver.driver_assigned_vehicle_id')
            ->leftJoin('ambulance_category', 'ambulance_category.ambulance_category_type', '=', 'vehicle.vehicle_category_type')
            ->where('booking_assigned_td.booking_assigned_td_booking_id', '=', $id)
            ->orderByDesc('booking_assigned_td.booking_assigned_td_id')
            ->get();

        $merged_data = [];

        if ($booking_assign) {
            foreach ($booking_assign as $assign) {
                // Get driver data related to the booking assignment
                $driver_data = DB::table('booking_assigned_td')
                    ->leftJoin('booking_view', 'booking_view.booking_id', '=', 'booking_assigned_td.booking_assigned_td_booking_id')
                    ->leftJoin('driver_live_location_his', 'driver_live_location_his.driver_live_location_his_d_id', '=', 'booking_assigned_td.booking_assigned_td_driver_id')
                    ->where('booking_view.booking_id', $id)
                    ->where('booking_assigned_td.booking_assigned_td_id', $assign->booking_assigned_td_id)
                    ->select('driver_live_location_his.driver_live_location_his_d_id', 'driver_live_location_his.driver_live_location_his_lat', 'driver_live_location_his.driver_live_location_his_long', 'booking_view.booking_pick_lat', 'booking_view.booking_pick_long')
                    ->distinct()
                    ->first();

                if ($driver_data) {
                    // Calculate distance between pick location and driver location
                    $distance_km = calculateDistance(
                        $driver_data->booking_pick_lat,
                        $driver_data->booking_pick_long,
                        $driver_data->driver_live_location_his_lat,
                        $driver_data->driver_live_location_his_long
                    );

                    // Format distance to two decimal places and concatenate " km" string
                    $formatted_distance = number_format($distance_km, 2) . ' km';

                    // Add formatted distance to the driver_data object
                    $driver_data->formatted_distance = $formatted_distance;

                    // Merge driver data and booking assignment data into a single object
                    $merged_data[] = (object) array_merge((array) $assign, (array) $driver_data);
                }
            }
        } 
  
            return view('livewire.admin.ambulance.ambulance-booking-details',compact('booking_addons','booking_trans','merged_data'),$data); 

            }elseif ($booking_status == 1){
                $data['booking_list'] = DB::table('booking_view')
                                    ->leftjoin('consumer','booking_view.booking_by_cid','=','consumer.consumer_id')
                                    ->leftjoin('driver','booking_view.booking_acpt_driver_id','=','driver.driver_id')
                                    ->leftjoin('driver_live_location','booking_view.booking_acpt_driver_id','=','driver_live_location.driver_live_location_d_id')
                                    ->leftjoin('ambulance_category', 'booking_view.booking_category', '=', 'ambulance_category.ambulance_category_type')
                                    ->leftjoin('booking_driver_distance', 'booking_view.booking_id', '=', 'booking_driver_distance.bdd_booking_id')
                                    ->where([
                                        ['booking_view.booking_status', '=', '1'],
                                        ['booking_view.booking_id', '=', $id]    
                                        ])
                                    ->orderBy('booking_view.booking_id','desc')
                                    ->first(); 
                                    // dd('booking_list with booking status 1', $booking_list);
                         $buket_map_data = [];

                                    foreach($data as $location_data){
                                        $add_data['booking_id'] = $location_data->booking_id;
                                        $add_data['driver_live_location_lat'] = $location_data->driver_live_location_lat;
                                        $add_data['driver_live_location_long'] = $location_data->driver_live_location_long;
                                        $add_data['booking_drop_lat'] = $location_data->booking_drop_lat;
                                        $add_data['booking_drop_long'] = $location_data->booking_drop_long;
                                        $add_data['booking_pick_lat'] = $location_data->booking_pick_lat;
                                        $add_data['booking_pick_long'] = $location_data->booking_pick_long;
                                        $add_data['driver_name'] = $location_data->driver_name;
                                        $add_data['driver_last_name'] = $location_data->driver_last_name;
                                        $unix_time = $location_data->driver_live_location_updated_time; 
                            
                                        $carbonDateTime = Carbon::createFromTimestamp($unix_time);
                                        $normalDateTime = $carbonDateTime->toDateTimeString();
                                        // $data = $convertedDates;
                                        $currentDateTime = Carbon::now();  
                                        $carbonDate = Carbon::parse($normalDateTime);
                                        $hoursDifference = $carbonDate->diffInHours($currentDateTime);
                                        $daysDifference = $carbonDate->diffInDays($currentDateTime);
                                        // Format the date difference as a human-readable message
                                        $add_data['time_diffrence'] =  $carbonDate->diffForHumans();
                            
                                        array_push($buket_map_data, $add_data);
                                    }  

                                    $data['booking'] = $buket_map_data;                    

                   $booking_addons = DB::table('booking_view')  
                                    ->rightjoin('booking_addons', 'booking_view.booking_id', '=', 'booking_addons.booking_id')
                                     ->where('booking_view.booking_id','=',$id)
                                     ->get();
        
                    $booking_trans = DB::table('booking_view')  
                                    ->rightjoin('booking_payments', 'booking_view.booking_id', '=', 'booking_payments.booking_id')
                                     ->where('booking_view.booking_id','=',$id)
                                     ->get();
    
                // Function to calculate distance between two sets of coordinates
                function calculateDistance($lat1, $lon1, $lat2, $lon2) {
                    $earthRadius = 6371; // Earth's radius in kilometers
        
                    $dLat = deg2rad($lat2 - $lat1);
                    $dLon = deg2rad($lon2 - $lon1);
        
                    $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
                    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        
                    $distance = $earthRadius * $c; // Distance in kilometers
        
                    return $distance;
                }
        
                // Your existing code to retrieve booking assignment details
                $booking_assign = DB::table('booking_assigned_td')
                    ->leftJoin('driver', 'driver.driver_id', '=', 'booking_assigned_td.booking_assigned_td_driver_id')
                    ->leftJoin('booking_view', 'booking_view.booking_id', '=', 'booking_assigned_td.booking_assigned_td_booking_id')
                    ->leftJoin('vehicle', 'vehicle.vehicle_id', '=', 'driver.driver_assigned_vehicle_id')
                    ->leftJoin('ambulance_category', 'ambulance_category.ambulance_category_type', '=', 'vehicle.vehicle_category_type')
                    ->where('booking_assigned_td.booking_assigned_td_booking_id', '=', $id)
                    ->orderByDesc('booking_assigned_td.booking_assigned_td_id')
                    ->get();
        
                $merged_data = [];
        
                if ($booking_assign) {
                    foreach ($booking_assign as $assign) {
                        // Get driver data related to the booking assignment
                        $driver_data = DB::table('booking_assigned_td')
                            ->leftJoin('booking_view', 'booking_view.booking_id', '=', 'booking_assigned_td.booking_assigned_td_booking_id')
                            ->leftJoin('driver_live_location_his', 'driver_live_location_his.driver_live_location_his_d_id', '=', 'booking_assigned_td.booking_assigned_td_driver_id')
                            ->where('booking_view.booking_id', $id)
                            ->where('booking_assigned_td.booking_assigned_td_id', $assign->booking_assigned_td_id)
                            ->select('driver_live_location_his.driver_live_location_his_d_id', 'driver_live_location_his.driver_live_location_his_lat', 'driver_live_location_his.driver_live_location_his_long', 'booking_view.booking_pick_lat', 'booking_view.booking_pick_long')
                            ->distinct()
                            ->first();
        
                        if ($driver_data) {
                            // Calculate distance between pick location and driver location
                            $distance_km = calculateDistance(
                                $driver_data->booking_pick_lat,
                                $driver_data->booking_pick_long,
                                $driver_data->driver_live_location_his_lat,
                                $driver_data->driver_live_location_his_long
                            );
        
                            // Format distance to two decimal places and concatenate " km" string
                            $formatted_distance = number_format($distance_km, 2) . ' km';
        
                            // Add formatted distance to the driver_data object
                            $driver_data->formatted_distance = $formatted_distance;
        
                            // Merge driver data and booking assignment data into a single object
                            $merged_data[] = (object) array_merge((array) $assign, (array) $driver_data);
                        }
                    }
                } 
                        // dd($booking_addons,$booking_trans,$merged_data,$data);  
                return view('livewire.admin.ambulance.ambulance-booking-details', [
                    'booking_addons' => $booking_addons,
                    'booking_trans' => $booking_trans,
                    'merged_data' => $merged_data,
                    'data' => $data
                ])->layout('livewire.admin.layouts.base');

                                return view('livewire.admin.ambulance.ambulance-booking-details',compact('booking_addons','booking_trans','merged_data'),$data); 
               
            }elseif ($booking_status =='2'){
                $data['booking_list'] = DB::table('booking_view')
                                    ->leftjoin('consumer','booking_view.booking_by_cid','=','consumer.consumer_id')
                                    ->leftjoin('driver','booking_view.booking_acpt_driver_id','=','driver.driver_id')
                                    ->leftjoin('vehicle','vehicle.vehicle_id','=','booking_view.booking_acpt_vehicle_id')
                                    ->leftjoin('driver_live_location','booking_view.booking_acpt_driver_id','=','driver_live_location.driver_live_location_d_id')
                                    ->leftjoin('ambulance_category', 'booking_view.booking_category', '=', 'ambulance_category.ambulance_category_type')
                                    ->leftjoin('booking_driver_distance', 'booking_view.booking_id', '=', 'booking_driver_distance.bdd_booking_id')
                                    ->where([
                                        ['booking_view.booking_status', '=', '2'],
                                        ['booking_view.booking_id', '=', $id]    
                                        ])
                                    ->orderBy('booking_view.booking_id','desc')
                                    ->first(); 

                             $buket_map_data = [];

                                    foreach($data as $location_data){
                                        $add_data['booking_id'] = $location_data->booking_id;
                                        $add_data['driver_live_location_lat'] = $location_data->driver_live_location_lat;
                                        $add_data['driver_live_location_long'] = $location_data->driver_live_location_long;
                                        $add_data['booking_drop_lat'] = $location_data->booking_drop_lat;
                                        $add_data['booking_drop_long'] = $location_data->booking_drop_long;
                                        $add_data['booking_pick_lat'] = $location_data->booking_pick_lat;
                                        $add_data['booking_pick_long'] = $location_data->booking_pick_long;
                                        $add_data['driver_name'] = $location_data->driver_name;
                                        $add_data['driver_last_name'] = $location_data->driver_last_name;
                                        $unix_time = $location_data->driver_live_location_updated_time; 
                            
                                        $carbonDateTime = Carbon::createFromTimestamp($unix_time);
                                        $normalDateTime = $carbonDateTime->toDateTimeString();
                                        // $data = $convertedDates;
                                        $currentDateTime = Carbon::now();  
                                        $carbonDate = Carbon::parse($normalDateTime);
                                        $hoursDifference = $carbonDate->diffInHours($currentDateTime);
                                        $daysDifference = $carbonDate->diffInDays($currentDateTime);
                                        // Format the date difference as a human-readable message
                                        $add_data['time_diffrence'] =  $carbonDate->diffForHumans();
                            
                                        array_push($buket_map_data, $add_data);
                                    }  

                                    $data['booking'] = $buket_map_data; 
                                
                    $booking_addons = DB::table('booking_view')  
                                    ->rightjoin('booking_addons', 'booking_view.booking_id', '=', 'booking_addons.booking_id')
                                     ->where('booking_view.booking_id','=',$id)
                                     ->get();

                     $booking_trans = DB::table('booking_view')  
                                     ->rightjoin('booking_payments', 'booking_view.booking_id', '=', 'booking_payments.booking_id')
                                      ->where('booking_view.booking_id','=',$id)
                                      ->get();

                    // Function to calculate distance between two sets of coordinates
                        function calculateDistance($lat1, $lon1, $lat2, $lon2) {
                            $earthRadius = 6371; // Earth's radius in kilometers

                            $dLat = deg2rad($lat2 - $lat1);
                            $dLon = deg2rad($lon2 - $lon1);

                            $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
                            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

                            $distance = $earthRadius * $c; // Distance in kilometers

                            return $distance;
                        }

                        // Your existing code to retrieve booking assignment details
                        $booking_assign = DB::table('booking_assigned_td')
                            ->leftJoin('driver', 'driver.driver_id', '=', 'booking_assigned_td.booking_assigned_td_driver_id')
                            ->leftJoin('booking_view', 'booking_view.booking_id', '=', 'booking_assigned_td.booking_assigned_td_booking_id')
                            ->leftJoin('vehicle', 'vehicle.vehicle_id', '=', 'driver.driver_assigned_vehicle_id')
                            ->leftJoin('ambulance_category', 'ambulance_category.ambulance_category_type', '=', 'vehicle.vehicle_category_type')
                            ->where('booking_assigned_td.booking_assigned_td_booking_id', '=', $id)
                            ->orderByDesc('booking_assigned_td.booking_assigned_td_id')
                            ->get();

                        $merged_data = [];

                        if ($booking_assign) {
                            foreach ($booking_assign as $assign) {
                                // Get driver data related to the booking assignment
                                $driver_data = DB::table('booking_assigned_td')
                                    ->leftJoin('booking_view', 'booking_view.booking_id', '=', 'booking_assigned_td.booking_assigned_td_booking_id')
                                    ->leftJoin('driver_live_location_his', 'driver_live_location_his.driver_live_location_his_d_id', '=', 'booking_assigned_td.booking_assigned_td_driver_id')
                                    ->where('booking_view.booking_id', $id)
                                    ->where('booking_assigned_td.booking_assigned_td_id', $assign->booking_assigned_td_id)
                                    ->select('driver_live_location_his.driver_live_location_his_d_id', 'driver_live_location_his.driver_live_location_his_lat', 'driver_live_location_his.driver_live_location_his_long', 'booking_view.booking_pick_lat', 'booking_view.booking_pick_long')
                                    ->distinct()
                                    ->first();

                                if ($driver_data) {
                                    // Calculate distance between pick location and driver location
                                    $distance_km = calculateDistance(
                                        $driver_data->booking_pick_lat,
                                        $driver_data->booking_pick_long,
                                        $driver_data->driver_live_location_his_lat,
                                        $driver_data->driver_live_location_his_long
                                    );

                                    // Format distance to two decimal places and concatenate " km" string
                                    $formatted_distance = number_format($distance_km, 2) . ' km';

                                    // Add formatted distance to the driver_data object
                                    $driver_data->formatted_distance = $formatted_distance;

                                    // Merge driver data and booking assignment data into a single object
                                    $merged_data[] = (object) array_merge((array) $assign, (array) $driver_data);
                                }
                            }
                        }
                                    
                     return view('livewire.admin.ambulance.ambulance-booking-details',compact('booking_addons','booking_trans','merged_data'),$data); 
               
            }elseif ($booking_status =='3'){
                $data['booking_list'] = DB::table('booking_view')
                                    ->leftjoin('booking_invoice','booking_invoice.bi_booking_id','=','booking_view.booking_id')
                                    ->leftjoin('consumer','booking_view.booking_by_cid','=','consumer.consumer_id')
                                    ->leftjoin('driver','booking_view.booking_acpt_driver_id','=','driver.driver_id')
                                    ->leftjoin('vehicle','vehicle.vehicle_id','=','booking_view.booking_acpt_vehicle_id')
                                    ->leftjoin('driver_live_location','booking_view.booking_acpt_driver_id','=','driver_live_location.driver_live_location_d_id')
                                    ->leftjoin('ambulance_category', 'booking_view.booking_category', '=', 'ambulance_category.ambulance_category_type')
                                    ->leftjoin('booking_driver_distance', 'booking_view.booking_id', '=', 'booking_driver_distance.bdd_booking_id')
                                    ->where([
                                        ['booking_view.booking_status', '=', '3'],
                                        ['booking_view.booking_id', '=', $id]    
                                        ])
                                    ->orderBy('booking_view.booking_id','desc')
                                    ->first();
                
                                    $buket_map_data = [];

                                    foreach($data as $location_data){
                                        $add_data['booking_id'] = $location_data->booking_id;
                                        $add_data['driver_live_location_lat'] = $location_data->driver_live_location_lat;
                                        $add_data['driver_live_location_long'] = $location_data->driver_live_location_long;
                                        $add_data['booking_drop_lat'] = $location_data->booking_drop_lat;
                                        $add_data['booking_drop_long'] = $location_data->booking_drop_long;
                                        $add_data['booking_pick_lat'] = $location_data->booking_pick_lat;
                                        $add_data['booking_pick_long'] = $location_data->booking_pick_long;
                                        $add_data['driver_name'] = $location_data->driver_name;
                                        $add_data['driver_last_name'] = $location_data->driver_last_name;
                                        $unix_time = $location_data->driver_live_location_updated_time; 
                            
                                        $carbonDateTime = Carbon::createFromTimestamp($unix_time);
                                        $normalDateTime = $carbonDateTime->toDateTimeString();
                                        // $data = $convertedDates;
                                        $currentDateTime = Carbon::now();  
                                        $carbonDate = Carbon::parse($normalDateTime);
                                        $hoursDifference = $carbonDate->diffInHours($currentDateTime);
                                        $daysDifference = $carbonDate->diffInDays($currentDateTime);
                                        // Format the date difference as a human-readable message
                                        $add_data['time_diffrence'] =  $carbonDate->diffForHumans();
                            
                                        array_push($buket_map_data, $add_data);
                                    }  

                                    $data['booking'] = $buket_map_data;                      

           $booking_addons = DB::table('booking_view')  
                            ->rightjoin('booking_addons', 'booking_view.booking_id', '=', 'booking_addons.booking_id')
                             ->where('booking_view.booking_id','=',$id)
                             ->get();

            $booking_trans = DB::table('booking_view')  
                            ->rightjoin('booking_payments', 'booking_view.booking_id', '=', 'booking_payments.booking_id')
                             ->where('booking_view.booking_id','=',$id)
                             ->get();
            
             
        // Function to calculate distance between two sets of coordinates
        function calculateDistance($lat1, $lon1, $lat2, $lon2) {
            $earthRadius = 6371; // Earth's radius in kilometers

            $dLat = deg2rad($lat2 - $lat1);
            $dLon = deg2rad($lon2 - $lon1);

            $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

            $distance = $earthRadius * $c; // Distance in kilometers

            return $distance;
        }

        // Your existing code to retrieve booking assignment details
        $booking_assign = DB::table('booking_assigned_td')
            ->leftJoin('driver', 'driver.driver_id', '=', 'booking_assigned_td.booking_assigned_td_driver_id')
            ->leftJoin('booking_view', 'booking_view.booking_id', '=', 'booking_assigned_td.booking_assigned_td_booking_id')
            ->leftJoin('vehicle', 'vehicle.vehicle_id', '=', 'driver.driver_assigned_vehicle_id')
            ->leftJoin('ambulance_category', 'ambulance_category.ambulance_category_type', '=', 'vehicle.vehicle_category_type')
            ->where('booking_assigned_td.booking_assigned_td_booking_id', '=', $id)
            ->orderByDesc('booking_assigned_td.booking_assigned_td_id')
            ->get();

        $merged_data = [];

        if ($booking_assign) {
            foreach ($booking_assign as $assign) {
                // Get driver data related to the booking assignment
                $driver_data = DB::table('booking_assigned_td')
                    ->leftJoin('booking_view', 'booking_view.booking_id', '=', 'booking_assigned_td.booking_assigned_td_booking_id')
                    ->leftJoin('driver_live_location_his', 'driver_live_location_his.driver_live_location_his_d_id', '=', 'booking_assigned_td.booking_assigned_td_driver_id')
                    ->where('booking_view.booking_id', $id)
                    ->where('booking_assigned_td.booking_assigned_td_id', $assign->booking_assigned_td_id)
                    ->select('driver_live_location_his.driver_live_location_his_d_id', 'driver_live_location_his.driver_live_location_his_lat', 'driver_live_location_his.driver_live_location_his_long', 'booking_view.booking_pick_lat', 'booking_view.booking_pick_long')
                    ->distinct()
                    ->first();

                if ($driver_data) {
                    // Calculate distance between pick location and driver location
                    $distance_km = calculateDistance(
                        $driver_data->booking_pick_lat,
                        $driver_data->booking_pick_long,
                        $driver_data->driver_live_location_his_lat,
                        $driver_data->driver_live_location_his_long
                    );

                    // Format distance to two decimal places and concatenate " km" string
                    $formatted_distance = number_format($distance_km, 2) . ' km';

                    // Add formatted distance to the driver_data object
                    $driver_data->formatted_distance = $formatted_distance;

                    // Merge driver data and booking assignment data into a single object
                    $merged_data[] = (object) array_merge((array) $assign, (array) $driver_data);
                }
            }
        } 

                             return view('livewire.admin.ambulance.ambulance-booking-details',compact('booking_addons','booking_trans','merged_data'),$data); 
                            }elseif($booking_status =='4'){
                                    $data['booking_list'] = DB::table('booking_view')
                                    ->leftjoin('booking_invoice','booking_invoice.bi_booking_id','=','booking_view.booking_id')
                                    ->leftjoin('consumer','booking_view.booking_by_cid','=','consumer.consumer_id')
                                    ->leftjoin('driver','booking_view.booking_acpt_driver_id','=','driver.driver_id')
                                    ->leftjoin('vehicle','vehicle.vehicle_id','=','booking_view.booking_acpt_vehicle_id')
                                    ->leftjoin('driver_live_location','booking_view.booking_acpt_driver_id','=','driver_live_location.driver_live_location_d_id')
                                    ->leftjoin('ambulance_category', 'booking_view.booking_category', '=', 'ambulance_category.ambulance_category_type')
                                    ->leftjoin('booking_driver_distance', 'booking_view.booking_id', '=', 'booking_driver_distance.bdd_booking_id')
                                    ->where([
                                        ['booking_view.booking_status', '=', '4'],
                                        ['booking_view.booking_id', '=', $id]    
                                        ])
                                    ->orderBy('booking_view.booking_id','desc')
                                    ->first();  
                                    // dd('booking status is 4',$data);
                                    $buket_map_data = [];

                                        foreach($data as $location_data){
                                            $add_data['booking_id'] = $location_data->booking_id;
                                            $add_data['driver_live_location_lat'] = $location_data->driver_live_location_lat;
                                            $add_data['driver_live_location_long'] = $location_data->driver_live_location_long;
                                            $add_data['booking_drop_lat'] = $location_data->booking_drop_lat;
                                            $add_data['booking_drop_long'] = $location_data->booking_drop_long;
                                            $add_data['booking_pick_lat'] = $location_data->booking_pick_lat;
                                            $add_data['booking_pick_long'] = $location_data->booking_pick_long;
                                            $add_data['driver_name'] = $location_data->driver_name;
                                            $add_data['driver_last_name'] = $location_data->driver_last_name;
                                            $unix_time = $location_data->driver_live_location_updated_time; 
                                
                                            $carbonDateTime = Carbon::createFromTimestamp($unix_time);
                                            $normalDateTime = $carbonDateTime->toDateTimeString();
                                            // $data = $convertedDates;
                                            $currentDateTime = Carbon::now();  
                                            $carbonDate = Carbon::parse($normalDateTime);
                                            $hoursDifference = $carbonDate->diffInHours($currentDateTime);
                                            $daysDifference = $carbonDate->diffInDays($currentDateTime);
                                            // Format the date difference as a human-readable message
                                            $add_data['time_diffrence'] =  $carbonDate->diffForHumans();
                                
                                            array_push($buket_map_data, $add_data);
                                        }  

                                        $data['booking'] = $buket_map_data; 

                                        $booking_addons = DB::table('booking_view')  
                                                ->rightjoin('booking_addons', 'booking_view.booking_id', '=', 'booking_addons.booking_id')
                                                    ->where('booking_view.booking_id','=',$id)
                                                    ->get();

                                        $booking_trans = DB::table('booking_view')  
                                                ->rightjoin('booking_payments', 'booking_view.booking_id', '=', 'booking_payments.booking_id')
                                                    ->where('booking_view.booking_id','=',$id)
                                                    ->get();

                   // Function to calculate distance between two sets of coordinates
                                        function calculateDistance($lat1, $lon1, $lat2, $lon2) {
                                            $earthRadius = 6371; // Earth's radius in kilometers

                                            $dLat = deg2rad($lat2 - $lat1);
                                            $dLon = deg2rad($lon2 - $lon1);

                                            $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
                                            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

                                            $distance = $earthRadius * $c; // Distance in kilometers

                                            return $distance;
                                        }

                                        // Your existing code to retrieve booking assignment details
                                        $booking_assign = DB::table('booking_assigned_td')
                                            ->leftJoin('driver', 'driver.driver_id', '=', 'booking_assigned_td.booking_assigned_td_driver_id')
                                            ->leftJoin('booking_view', 'booking_view.booking_id', '=', 'booking_assigned_td.booking_assigned_td_booking_id')
                                            ->leftJoin('vehicle', 'vehicle.vehicle_id', '=', 'driver.driver_assigned_vehicle_id')
                                            ->leftJoin('ambulance_category', 'ambulance_category.ambulance_category_type', '=', 'vehicle.vehicle_category_type')
                                            ->where('booking_assigned_td.booking_assigned_td_booking_id', '=', $id)
                                            ->orderByDesc('booking_assigned_td.booking_assigned_td_id')
                                            ->get();

                                        $merged_data = [];

                if ($booking_assign) {
                    foreach ($booking_assign as $assign) {
                        // Get driver data related to the booking assignment
                        $driver_data = DB::table('booking_assigned_td')
                            ->leftJoin('booking_view', 'booking_view.booking_id', '=', 'booking_assigned_td.booking_assigned_td_booking_id')
                            ->leftJoin('driver_live_location_his', 'driver_live_location_his.driver_live_location_his_d_id', '=', 'booking_assigned_td.booking_assigned_td_driver_id')
                            ->where('booking_view.booking_id', $id)
                            ->where('booking_assigned_td.booking_assigned_td_id', $assign->booking_assigned_td_id)
                            ->select('driver_live_location_his.driver_live_location_his_d_id', 'driver_live_location_his.driver_live_location_his_lat', 'driver_live_location_his.driver_live_location_his_long', 'booking_view.booking_pick_lat', 'booking_view.booking_pick_long')
                            ->distinct()
                            ->first();

                        if ($driver_data) {
                            // Calculate distance between pick location and driver location
                            $distance_km = calculateDistance(
                                $driver_data->booking_pick_lat,
                                $driver_data->booking_pick_long,
                                $driver_data->driver_live_location_his_lat,
                                $driver_data->driver_live_location_his_long
                            );

                            // Format distance to two decimal places and concatenate " km" string
                            $formatted_distance = number_format($distance_km, 2) . ' km';

                            // Add formatted distance to the driver_data object
                            $driver_data->formatted_distance = $formatted_distance;

                            // Merge driver data and booking assignment data into a single object
                            $merged_data[] = (object) array_merge((array) $assign, (array) $driver_data);
                            // dd($merged_data,$booking_trans);
                        }
                    }
                } 
                // return view('livewire.admin.ambulance.ambulance-booking-details',compact('booking_addons','booking_trans','merged_data','data'),$data); 
                return view('livewire.admin.ambulance.ambulance-booking-details',compact('booking_addons','booking_trans','merged_data','data'),$data); 
                            }elseif($booking_status =='5'){
                $data['booking_list'] = DB::table('booking_view')
                ->leftjoin('booking_invoice','booking_invoice.bi_booking_id','=','booking_view.booking_id')
                ->leftjoin('consumer','booking_view.booking_by_cid','=','consumer.consumer_id')
                ->leftJoin('remark_data', 'remark_data.remark_booking_id', '=', 'booking_view.booking_id')
                ->leftjoin('driver','booking_view.booking_acpt_driver_id','=','driver.driver_id')
                ->leftjoin('vehicle','vehicle.vehicle_id','=','booking_view.booking_acpt_vehicle_id')
                ->leftjoin('driver_live_location','booking_view.booking_acpt_driver_id','=','driver_live_location.driver_live_location_d_id')
                ->leftjoin('ambulance_category', 'booking_view.booking_category', '=', 'ambulance_category.ambulance_category_type')
                ->leftjoin('booking_driver_distance', 'booking_view.booking_id', '=', 'booking_driver_distance.bdd_booking_id')
                ->leftjoin('booking_a_c_history', 'booking_a_c_history.bah_booking_id', '=', 'booking_view.booking_id')
                ->where([
                    ['booking_view.booking_status', '=', '5'],
                    ['booking_view.booking_id', '=', $id]    
                    ])
                ->orderBy('booking_view.booking_id','desc')
                ->first(); 

                // dd($data);

                $buket_map_data = [];

                foreach($data as $location_data){
                    $add_data['booking_id'] = $location_data->booking_id;
                    $add_data['driver_live_location_lat'] = $location_data->driver_live_location_lat;
                    $add_data['driver_live_location_long'] = $location_data->driver_live_location_long;
                    $add_data['booking_drop_lat'] = $location_data->booking_drop_lat;
                    $add_data['booking_drop_long'] = $location_data->booking_drop_long;
                    $add_data['booking_pick_lat'] = $location_data->booking_pick_lat;
                    $add_data['booking_pick_long'] = $location_data->booking_pick_long;
                    $add_data['driver_name'] = $location_data->driver_name;
                    $add_data['driver_last_name'] = $location_data->driver_last_name;
                    $unix_time = $location_data->driver_live_location_updated_time; 
        
                    $carbonDateTime = Carbon::createFromTimestamp($unix_time);
                    $normalDateTime = $carbonDateTime->toDateTimeString();
                    // $data = $convertedDates;
                    $currentDateTime = Carbon::now();  
                    $carbonDate = Carbon::parse($normalDateTime);
                    $hoursDifference = $carbonDate->diffInHours($currentDateTime);
                    $daysDifference = $carbonDate->diffInDays($currentDateTime);
                    // Format the date difference as a human-readable message
                    $add_data['time_diffrence'] =  $carbonDate->diffForHumans();
        
                    array_push($buket_map_data, $add_data);
                }  

                $data['booking'] = $buket_map_data; 
                               
     $booking_addons = DB::table('booking_view')  
                ->rightjoin('booking_addons', 'booking_view.booking_id', '=', 'booking_addons.booking_id')
                 ->where('booking_view.booking_id','=',$id)
                 ->get();

     $booking_trans = DB::table('booking_view')  
                ->rightjoin('booking_payments', 'booking_view.booking_id', '=', 'booking_payments.booking_id')
                 ->where('booking_view.booking_id','=',$id)
                 ->get();
                 
         // Function to calculate distance between two sets of coordinates
         function calculateDistance($lat1, $lon1, $lat2, $lon2) {
            $earthRadius = 6371; // Earth's radius in kilometers

            $dLat = deg2rad($lat2 - $lat1);
            $dLon = deg2rad($lon2 - $lon1);

            $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

            $distance = $earthRadius * $c; // Distance in kilometers

            return $distance;
        }

        // Your existing code to retrieve booking assignment details
        $booking_assign = DB::table('booking_assigned_td')
            ->leftJoin('driver', 'driver.driver_id', '=', 'booking_assigned_td.booking_assigned_td_driver_id')
            ->leftJoin('booking_view', 'booking_view.booking_id', '=', 'booking_assigned_td.booking_assigned_td_booking_id')
            ->leftJoin('vehicle', 'vehicle.vehicle_id', '=', 'driver.driver_assigned_vehicle_id')
            ->leftJoin('ambulance_category', 'ambulance_category.ambulance_category_type', '=', 'vehicle.vehicle_category_type')
            ->where('booking_assigned_td.booking_assigned_td_booking_id', '=', $id)
            ->orderByDesc('booking_assigned_td.booking_assigned_td_id')
            ->get();

        $merged_data = [];

        if ($booking_assign) {
            foreach ($booking_assign as $assign) {
                // Get driver data related to the booking assignment
                $driver_data = DB::table('booking_assigned_td')
                    ->leftJoin('booking_view', 'booking_view.booking_id', '=', 'booking_assigned_td.booking_assigned_td_booking_id')
                    ->leftJoin('driver_live_location_his', 'driver_live_location_his.driver_live_location_his_d_id', '=', 'booking_assigned_td.booking_assigned_td_driver_id')
                    ->where('booking_view.booking_id', $id)
                    ->where('booking_assigned_td.booking_assigned_td_id', $assign->booking_assigned_td_id)
                    ->select('driver_live_location_his.driver_live_location_his_d_id', 'driver_live_location_his.driver_live_location_his_lat', 'driver_live_location_his.driver_live_location_his_long', 'booking_view.booking_pick_lat', 'booking_view.booking_pick_long')
                    ->distinct()
                    ->first();

                if ($driver_data) {
                    // Calculate distance between pick location and driver location
                    $distance_km = calculateDistance(
                        $driver_data->booking_pick_lat,
                        $driver_data->booking_pick_long,
                        $driver_data->driver_live_location_his_lat,
                        $driver_data->driver_live_location_his_long
                    );

                    // Format distance to two decimal places and concatenate " km" string
                    $formatted_distance = number_format($distance_km, 2) . ' km';

                    // Add formatted distance to the driver_data object
                    $driver_data->formatted_distance = $formatted_distance;

                    // Merge driver data and booking assignment data into a single object
                    $merged_data[] = (object) array_merge((array) $assign, (array) $driver_data);
                }
            }
        } 
            //  dd($merged_data);

                 return view('livewire.admin.ambulance.ambulance-booking-details',compact('booking_addons','booking_trans','merged_data'),$data); 
                }elseif($booking_status =='6'){
                    $data['booking_list'] = DB::table('booking_view')
                    ->leftjoin('booking_invoice','booking_invoice.bi_booking_id','=','booking_view.booking_id')
                    ->leftjoin('consumer','booking_view.booking_by_cid','=','consumer.consumer_id')
                    ->leftjoin('driver','booking_view.booking_acpt_driver_id','=','driver.driver_id')
                    ->leftjoin('vehicle','vehicle.vehicle_id','=','booking_view.booking_acpt_vehicle_id')
                    ->leftjoin('driver_live_location','booking_view.booking_acpt_driver_id','=','driver_live_location.driver_live_location_d_id')
                    ->leftjoin('ambulance_category', 'booking_view.booking_category', '=', 'ambulance_category.ambulance_category_type')
                    ->leftjoin('booking_driver_distance', 'booking_view.booking_id', '=', 'booking_driver_distance.bdd_booking_id')
                    ->where([
                        ['booking_view.booking_status', '=', '6'],
                        ['booking_view.booking_id', '=', $id]    
                        ])
                    ->orderBy('booking_view.booking_id','desc')
                    ->first(); 
    
                    $buket_map_data = [];
    
                    foreach($data as $location_data){
                        $add_data['booking_id'] = $location_data->booking_id;
                        $add_data['driver_live_location_lat'] = $location_data->driver_live_location_lat;
                        $add_data['driver_live_location_long'] = $location_data->driver_live_location_long;
                        $add_data['booking_drop_lat'] = $location_data->booking_drop_lat;
                        $add_data['booking_drop_long'] = $location_data->booking_drop_long;
                        $add_data['booking_pick_lat'] = $location_data->booking_pick_lat;
                        $add_data['booking_pick_long'] = $location_data->booking_pick_long;
                        $add_data['driver_name'] = $location_data->driver_name;
                        $add_data['driver_last_name'] = $location_data->driver_last_name;
                        $unix_time = $location_data->driver_live_location_updated_time; 
            
                        $carbonDateTime = Carbon::createFromTimestamp($unix_time);
                        $normalDateTime = $carbonDateTime->toDateTimeString();
                        // $data = $convertedDates;
                        $currentDateTime = Carbon::now();  
                        $carbonDate = Carbon::parse($normalDateTime);
                        $hoursDifference = $carbonDate->diffInHours($currentDateTime);
                        $daysDifference = $carbonDate->diffInDays($currentDateTime);
                        // Format the date difference as a human-readable message
                        $add_data['time_diffrence'] =  $carbonDate->diffForHumans();
            
                        array_push($buket_map_data, $add_data);
                    }  
    
                    $data['booking'] = $buket_map_data; 
                                   
         $booking_addons = DB::table('booking_view')  
                    ->rightjoin('booking_addons', 'booking_view.booking_id', '=', 'booking_addons.booking_id')
                     ->where('booking_view.booking_id','=',$id)
                     ->get();
    
         $booking_trans = DB::table('booking_view')  
                    ->rightjoin('booking_payments', 'booking_view.booking_id', '=', 'booking_payments.booking_id')
                     ->where('booking_view.booking_id','=',$id)
                     ->get();
                     
             // Function to calculate distance between two sets of coordinates
             function calculateDistance($lat1, $lon1, $lat2, $lon2) {
                $earthRadius = 6371; // Earth's radius in kilometers
    
                $dLat = deg2rad($lat2 - $lat1);
                $dLon = deg2rad($lon2 - $lon1);
    
                $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
                $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    
                $distance = $earthRadius * $c; // Distance in kilometers
    
                return $distance;
            }
    
            // Your existing code to retrieve booking assignment details
            $booking_assign = DB::table('booking_assigned_td')
                ->leftJoin('driver', 'driver.driver_id', '=', 'booking_assigned_td.booking_assigned_td_driver_id')
                ->leftJoin('booking_view', 'booking_view.booking_id', '=', 'booking_assigned_td.booking_assigned_td_booking_id')
                ->leftJoin('vehicle', 'vehicle.vehicle_id', '=', 'driver.driver_assigned_vehicle_id')
                ->leftJoin('ambulance_category', 'ambulance_category.ambulance_category_type', '=', 'vehicle.vehicle_category_type')
                ->where('booking_assigned_td.booking_assigned_td_booking_id', '=', $id)
                ->orderByDesc('booking_assigned_td.booking_assigned_td_id')
                ->get();
    
            $merged_data = [];
    
            if ($booking_assign) {
                foreach ($booking_assign as $assign) {
                    // Get driver data related to the booking assignment
                    $driver_data = DB::table('booking_assigned_td')
                        ->leftJoin('booking_view', 'booking_view.booking_id', '=', 'booking_assigned_td.booking_assigned_td_booking_id')
                        ->leftJoin('driver_live_location_his', 'driver_live_location_his.driver_live_location_his_d_id', '=', 'booking_assigned_td.booking_assigned_td_driver_id')
                        ->where('booking_view.booking_id', $id)
                        ->where('booking_assigned_td.booking_assigned_td_id', $assign->booking_assigned_td_id)
                        ->select('driver_live_location_his.driver_live_location_his_d_id', 'driver_live_location_his.driver_live_location_his_lat', 'driver_live_location_his.driver_live_location_his_long', 'booking_view.booking_pick_lat', 'booking_view.booking_pick_long')
                        ->distinct()
                        ->first();
    
                    if ($driver_data) {
                        // Calculate distance between pick location and driver location
                        $distance_km = calculateDistance(
                            $driver_data->booking_pick_lat,
                            $driver_data->booking_pick_long,
                            $driver_data->driver_live_location_his_lat,
                            $driver_data->driver_live_location_his_long
                        );
    
                        // Format distance to two decimal places and concatenate " km" string
                        $formatted_distance = number_format($distance_km, 2) . ' km';
    
                        // Add formatted distance to the driver_data object
                        $driver_data->formatted_distance = $formatted_distance;
    
                        // Merge driver data and booking assignment data into a single object
                        $merged_data[] = (object) array_merge((array) $assign, (array) $driver_data);
                    }
                }
            } 
                //  dd($merged_data);
    
                     return view('livewire.admin.ambulance.ambulance-booking-details',compact('booking_addons','booking_trans','merged_data'),$data); 
                }
                
                else{
              echo "Booking status Not found" ;
            }
        
        }
      
      }



      public function DriverDataGet2($bookingId)
      {
        $bookingData = DB::table('booking_view')
        ->where('booking_view.booking_id',$bookingId)
        ->first();


          $selectedCategory = $bookingData->booking_category;
          $pickupLatitude = $bookingData->booking_pick_lat;
          $pickupLongitude = $bookingData->booking_pick_long;
          $driverDutyStatus = 'All';
          $nearestDriverOption = 'Nearest';
        //   dd($bookingData,$selectedCategory,$pickupLatitude,$pickupLongitude,$driverDutyStatus,$nearestDriverOption);

        //   $selectedCategory = $request->input('category');
        //   $pickupLatitude = $request->input('pickupLatitude');
        //   $pickupLongitude = $request->input('pickupLongitude');
        //   $driverDutyStatus = $request->input('driver_duty_status') ?? 'NULL';
        //   $nearestDriverOption = $request->input('nearest_driver') ?? 'NULL';
      
          $query = DB::table('driver')
              ->leftJoin('partner', 'partner.partner_id', '=', 'driver.driver_created_partner_id')
              ->leftJoin('city', 'city.city_id', '=', 'driver.driver_city_id')
              ->leftJoin('state', 'state.state_id', '=', 'city.city_state')
              ->leftJoin('vehicle', 'vehicle.vehicle_id', '=', 'driver.driver_assigned_vehicle_id')
              ->leftJoin('ambulance_category', 'ambulance_category.ambulance_category_type', '=', 'vehicle.vehicle_category_type')
              ->leftJoin('driver_live_location', 'driver.driver_id', '=', 'driver_live_location.driver_live_location_d_id')
              ->selectRaw('vehicle.*, partner.*, city.*, state.*, driver_live_location.*, ambulance_category.*, driver.*, 
                          (6371 * 2 * ASIN(SQRT(POWER(SIN((? - driver_live_location_lat) * pi()/180 / 2), 2) + COS(? * pi()/180) * COS(driver_live_location_lat * pi()/180) * POWER(SIN((? - driver_live_location_long) * pi()/180 / 2), 2) ))) as distance,
                          ROUND((UNIX_TIMESTAMP()-driver_live_location.driver_live_location_updated_time) / 60, 0) as last_updated_diff,
                          ROUND((UNIX_TIMESTAMP()-driver.driver_last_booking_notified_time) / 60, 0) as last_booking', 
                          [$pickupLatitude, $pickupLatitude, $pickupLongitude])
              ->where('vehicle.vehicle_category_type', $selectedCategory);
      
          // Apply duty status filter
          if ($driverDutyStatus == 'All') {
              $query->whereIn('driver.driver_duty_status', ['ON', 'OFF']);
          } else {
              $query->where('driver.driver_duty_status', $driverDutyStatus);
          }
      
          $query->orderBy('distance');
      
          if ($nearestDriverOption == 'Nearest') {
              $query->whereNotNull('driver_live_location.driver_live_location_updated_time'); // Filter by non-null distance
          }
      
          $driverData = $query->paginate(8); // Paginate the results, adjust the number of items per page as needed
            // dd('driverData',$driverData);
            return $driverData;
                 return response()->json(['driverData' => $driverData->toArray()]);
              }

// booking cancel start

                public function openModal()
                {
                    $this->isCancelBookingOpen = true;
                }
                public function closeModal()
                {
                    $this->isCancelBookingOpen = false;
                }
              public function cancelBooking($id)
              {
                
                // $bookingData = DB::table('booking_view')->where(['booking_id'=> $id])->first();
                // dd($bookingData);
                // $this->driverid = $bookingData->booking_acpt_driver_id;
                $this->openModal();
              }
              public function cancelBookingProcessing(){
                $validatedData = $this->validate([
                    'canceled_by' => 'required',
                    'cancelReason' => 'required',
                 ],[
                    'canceled_by.required' => 'Please select canceled by',
                    'cancelReason.required' => 'Please give cancel reason',
                 ]);
                 $this->CancelBookingOn($this->bookingId);
              }

                     public function CancelBookingOn($id)
                    {
                        DB::beginTransaction();
                        try {
                           $booking = DB::table('booking_view')
                                            ->leftjoin('consumer', 'booking_view.booking_by_cid', '=', 'consumer.consumer_id')
                                            ->leftjoin('driver', 'driver.driver_id', '=', 'booking_view.booking_acpt_driver_id')
                                            ->leftjoin('driver_live_location', 'driver.driver_id', '=', 'driver_live_location.driver_live_location_d_id')
                                            ->where('booking_status','=','2')
                                            ->where('booking_id','=',$id)
                                            ->get();
// dd('CancelBookingOn one',$id,$booking);
                            foreach($booking as $key)
                            {   
                                    $booking_id = $key->booking_id;
                                    $consumer_name = $key->consumer_name;
                                    $consumer_fcm_token = $key->consumer_fcm_token;

                                    $booking_acpt_driver_id = $key->booking_acpt_driver_id;
                                    $driver_name = $key->driver_name;
                                    $driver_last_name = $key->driver_last_name;
                                    $driver_fcm_token = $key->driver_fcm_token;

                                    // $booking_transaction_time = $key->booking_acpt_driver_id;
                                    $booking_by_cid = $key->booking_by_cid;
                                    $booking_acpt_vehicle_id = $key->booking_acpt_vehicle_id;
                                    $booking_adv_amount  = $key->booking_adv_amount;
                                    $booking_amount  = $key->booking_amount;
                                    // $booking_transaction_time  = $key->driver_live_location_long;
                                
                        //............................... Consumer notification Starts.................................

                                    $i =0;
                                    $title='Sorry: '.$consumer_name.' your Booking Id : '.$booking_id.", Canceled by Medcab ";
                                    $sound="default";
                                    $image="https://madmin.cabmed.in/site_img/title_icon.png";
                                    $key='2';
                                    $key2=''.$booking_id; // splash screen
                                    $body=  "Hey ,".$consumer_name." your Accepted booking Id : ".$booking_id." has been Cancelled ."; 
                                    $result = $this->multiple_notification_msg($consumer_fcm_token,$title,$body,$sound,$image,$key,$key2);

                        //............................... Consumer notification ends...................................

                        //............................... Driver notification Starts.................................

                                    $i =0;
                                    $title='Sorry: '.$driver_name.'  '.$driver_last_name. ' your Booking Id : '.$booking_id.", Canceled by Medcab ";
                                    $sound="default";
                                    $image="https://madmin.cabmed.in/site_img/title_icon.png";
                                    $key='2';
                                    $key2=''.$booking_id; // splash screen
                                    $body=  "Hey ,".$driver_name.'  '.$driver_last_name." your Accepted booking Id : ".$booking_id." has been Cancelled Now Your are Free to New Booking from Medcab."; 
                                    $result = $this->multiple_notification_msg($driver_fcm_token,$title,$body,$sound,$image,$key,$key2);


                                    db::table('driver')
                                    ->where('driver_id','=',$booking_acpt_driver_id)
                                    ->update(['driver_on_booking_status' =>'0']); 

                        //............................... Driver notification ends.................................
// dd('CancelBookingOn two',$booking);
                            
                               
                        if ($booking[0]->booking_status == '2') {
                            DB::table('booking_view')
                                ->where('booking_id', '=', $id)
                                ->update(['booking_status' => '5']);

                                $check_payment = DB::table('booking_payments')
                                ->where('booking_id',$booking_id)
                                ->where('status', 'Success')
                                ->get();
    
                                   // Calculate the sum of the "amount" field
                            $totalAmount = $check_payment->sum('amount');
                        
                            if (count($check_payment) > 0) {
    
                                   $booking_id = $check_payment[0]->booking_id;
                                   $consumer_id = $check_payment[0]->consumer_id;
                                   $payment_mobile = $check_payment[0]->payment_mobile;
    
                                //    $booking_payments = new booking_payments;
    
                                   $data = [
                                    'payment_source' => 'MedCab_Pvt_Pay',
                                    'consumer_id' => $consumer_id,
                                    'booking_id' => $booking_id,
                                    'transaction_id' => '11296683.' . rand(0, 9999),
                                    'amount' => '0', // NULL or appropriate value
                                    'currency' => 'INR',
                                    'status' => 'Success',
                                    'order_id' => 'order_C224payment.' . rand(0, 9999),
                                    'method' => null, // NULL or appropriate value
                                    'payment_mobile' => $payment_mobile,
                                    'amount_refunded' => $totalAmount,
                                    'wallet' => null, // NULL or appropriate value
                                    'entity' => null, // NULL or appropriate value
                                    'refund_Date' => Carbon::now(),
                                    'bank_ref_no' => null, // NULL or appropriate value
                                    'refund_id' => 'Refunded_' . $booking_id,
                                    'booking_transaction_time' => Carbon::now()->timestamp,
                                    'booking_payments_trans_status' => '2'
                                ];
                                
                                DB::table('booking_payments')->insert($data);
                                $request->session()->flash('message', 'Booking is Cancel and Amount is refunded Successfully,.');
                                $check_transaction = DB::table('consumer_transection')
                                ->where('consumer_transection_done_by', $consumer_id)
                                ->orderByDesc('consumer_transection_id')
                                ->first();
    
                            if ($check_transaction) { // Use "if ($check_transaction)" to check if a transaction exists
                                $consumer_previous = $check_transaction->consumer_transection_new_amount; // Remove [0]
                                $consumer_amount = $totalAmount;
    
                                $consumer_transection = new consumer_transection;
    
                                $consumer_transection->consumer_transection_done_by = $consumer_id;
                                $consumer_transection->consumer_transection_amount = $consumer_amount;
                                $consumer_transection->consumer_transection_payment_id = 'REQ_224_W_169260.' . rand(0, 9999);
                                $consumer_transection->consumer_transection_note = 'Refund Wallet';
                                $consumer_transection->consumer_transection_time = Carbon::now()->timestamp;
                                $consumer_transection->consumer_transection_type_cr_db = '4';
                                $consumer_transection->consumer_transection_previous_amount = $consumer_previous;
                                $consumer_transection->consumer_transection_new_amount = $consumer_previous + $consumer_amount; // Update with correct formula
                                $consumer_transection->consumer_transection_status = '0';
                                $consumer_transection->save();
                            }
    
                                    $consumer_pay = DB::table('consumer')
                                    ->where('consumer_id', '=', $consumer_id)
                                    ->get();
                                
                                        if (count($consumer_pay) > 0) {
                                            $consumer_wallet_pre = $consumer_pay[0]->consumer_wallet_amount;
                                            $consumer_new_wallet = $consumer_wallet_pre + $consumer_amount;
                                            $consumers = $consumer_pay[0]->consumer_id;
                                        
                                            $update_consumer = DB::table('consumer')
                                                ->where('consumer_id', $consumers)
                                                ->update(['consumer_wallet_amount' => $consumer_new_wallet]);
                                        }
                                 
                                }
                        
                                } else {
                                    // No successful payment exists, show a message
                                    $request->session()->flash('message', 'Booking Cancel Successfully and Not any paid amount for Booking');
                                }

                                $admin = session('admin_data_id');
                                $booking_a_c_history= new booking_a_c_history;
    
                                $booking_a_c_history->bah_booking_id = $booking_id;
                                $booking_a_c_history->bah_consumer_id = $booking_by_cid;
                                $booking_a_c_history->bah_admin_id = $admin;
                                $booking_a_c_history->bah_driver_id = $booking_acpt_driver_id;
                                $booking_a_c_history->bah_vehicle_id = $booking_acpt_vehicle_id;
                                $booking_a_c_history->bah_driver_latitude = $driver_live_location_lat ?? '0';
                                $booking_a_c_history->bah_driver_longitude = $driver_live_location_long ?? '0';
                                $booking_a_c_history->bah_cancel_reason_id = '0';
                                $booking_a_c_history->bah_cancel_reason_text = 'He is not Receive Call';
                                $booking_a_c_history->bah_time = time();
                                $booking_a_c_history->bah_status = '2';
                                $booking_a_c_history->bah_user_type = '2';
                                $booking_a_c_history->save();
                            }
                        }catch (\Exception $e) {
                            DB::rollBack(); // Rollback the transaction if an exception occurs
                            // Handle the exception, log it, or return an error response
                            return response()->json(['error' => 'An error occurred while cancelling the booking.']);
                        }
                    }
            //   booking cancel code end

            // admin side otp match function start
            public function bookingOtpMatch($id){
                 DB::beginTransaction();
                        try {
                            DB::table('booking_view')
                            ->where('booking_view.booking_id',$id)
                            ->update(['booking_view_status_otp' =>'0']); 
                            DB::commit();
                            session()->flash('message', 'otp matched successfully!!'.$e->getMessage());

                        }
                catch (\Exception $e) {
                    session()->flash('message', 'otp match something went wrong!!'.$e->getMessage());
                    DB::rollback();
                    \Log::error('Error occurred while processing admin side otp match: ' . $e->getMessage());    
                }
            }
            // admin side otp match function end
   
}
