<?php

namespace App\Livewire\Admin\Vehicle;
use Illuminate\Support\Facades\DB; 
use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class VehicleComponent extends Component
{
    public $selectedDate,$filterConditionl, 
    $selectedFromDate,$selectedToDate, $fromDate=null, 
    $toDate=null,$fromdate, $todate, $id, $name, $email, $state=[],
    $position, $cityCount, $driver_status=null, $driver_duty_status=null,$division_state_id=null,$check_for,
    $activeTab,$documentExpiry,
    $districtCount,
    $division_state,
    $district_state,
    $city_state,
    $districtWise_state,
    $bookingState,$vehicleCreated,
    $vehicleStatusFilter;
    public $isOpen = 0;
    use WithPagination;
    use WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';
    // 
    public $search = '';
    public $sortBy = 'name';
    public $sortDirection = 'asc';
     public $age = '30';
    public $address = 'Lucknow';
  
    #[Layout('livewire.admin.layouts.base')] 

  public function resetFilters(){

         $this->vehicle_status=null;
         $this->selectedDate=null;

            }

            public function filterCondition($value){
                $this->resetFilters();
                if($value=='cityCount'){
                    $this->activeTab=$value;
                }
                if($value=='districtCount'){
                    $this->activeTab=$value;
                }
                if($value=='districtWise'){
                    $this->activeTab=$value;
                }
                if($value=='divisionWise'){
                    $this->activeTab=$value;
                }
                if($value=='totalData'){
                    $this->activeTab=$value;
                }
                if($value=='filterWise'){
                    $this->activeTab=$value;
                }
                if($value=='documentExpiry'){
                    $this->activeTab=$value;
                }
                if($value=='bookingVehicle'){
                    $this->activeTab=$value;
                }
                if($value=='cityWiseBooking'){
                    $this->activeTab=$value;
                }
          }

    public function render()
    {
          if($this->activeTab=='cityCount'){

            $city_state_id = ($this->city_state ) ? $this->city_state : 27;

            $cityCountData = DB::table('city')
            ->leftJoin('driver', 'city.city_id', '=', 'driver.driver_city_id')
            ->leftJoin('state', 'state.state_id', '=', 'city.city_state')
            ->leftJoin('vehicle', 'vehicle.vehicle_id', '=', 'driver.driver_assigned_vehicle_id')
            ->leftJoin('ambulance_category', 'ambulance_category.ambulance_category_type', '=', 'vehicle.vehicle_category_type')
            ->when($city_state_id !== null, function ($query) use ($city_state_id) {
                return $query->where('state.state_id', $city_state_id);
            })    
            ->where('city.city_name', 'like', '%' . $this->search . '%')       
            ->selectRaw('
                state.state_name,
                city.city_name,
                COUNT(vehicle.vehicle_id) as total_vehicle,
                COUNT(CASE WHEN ambulance_category.ambulance_category_type = "A" THEN 1 END) as medical_first_responder,
                COUNT(CASE WHEN ambulance_category.ambulance_category_type = "B" THEN 1 END) as patient_transfer_ambulances,
                COUNT(CASE WHEN ambulance_category.ambulance_category_type = "C" THEN 1 END) as basic_life_support,
                COUNT(CASE WHEN ambulance_category.ambulance_category_type = "D" THEN 1 END) as advance_life_support,
                COUNT(CASE WHEN ambulance_category.ambulance_category_type = "H" THEN 1 END) as dead_body_small,
                COUNT(CASE WHEN ambulance_category.ambulance_category_type = "J" THEN 1 END) as train_ambulances,
                COUNT(CASE WHEN ambulance_category.ambulance_category_type = "H1" THEN 1 END) as dead_body_medium,
                COUNT(CASE WHEN ambulance_category.ambulance_category_type = "H2" THEN 1 END) as dead_body_big,
                COUNT(CASE WHEN ambulance_category.ambulance_category_type = "B_AC_DLT" THEN 1 END) as patience_ransafer_ac,
                COUNT(CASE WHEN ambulance_category.ambulance_category_type = "C_AC" THEN 1 END) as basic_life_support_ac,
                COUNT(CASE WHEN ambulance_category.ambulance_category_type = "H1_AC" THEN 1 END) as dead_body_medium_fridge,
                COUNT(CASE WHEN ambulance_category.ambulance_category_type = "H2_AC" THEN 1 END) as dead_body_big_fridge
            ')
            ->orderBy('total_vehicle','DESC')
            ->groupBy('state.state_name', 'city.city_name') // Group by both state and city
            ->paginate(10);

                
                $SumVehicle = DB::table('driver')
                ->leftJoin('city', 'city.city_id', '=', 'driver.driver_city_id')
                ->leftJoin('state', 'state.state_id', '=', 'city.city_state')
                ->leftJoin('vehicle', 'vehicle.vehicle_id', '=', 'driver.driver_assigned_vehicle_id')
                ->leftJoin('ambulance_category', 'ambulance_category.ambulance_category_type', '=', 'vehicle.vehicle_category_type')
                ->when($city_state_id !== null, function ($query) use ($city_state_id) {
                    return $query->where('state.state_id', $city_state_id);
                })   
                 ->where('driver.driver_status', '1')
                ->where('driver.driver_assigned_vehicle_id', '!=', '0')
                ->where('driver.driver_assigned_vehicle_id', '!=', '')
               ->get();

                $vehicle_sum = count($SumVehicle);

                
            $stateData = DB::table('state')
            ->leftJoin('city', 'city.city_state', '=', 'state.state_id')
            ->selectRaw('state.state_id,
                         state.state_name, 
                         COUNT(DISTINCT city.city_id ) as total_city_count')
            ->groupBy('state.state_id', 'state.state_name')
            ->get();

     return view('livewire.admin.vehicle.cityor-district-count-component',['cityCountData' => $cityCountData, 'vehicle_sum'=>$vehicle_sum,'stateData'=>$stateData]);

        }elseif($this->activeTab=='districtCount'){

            $district_state_id = ($this->district_state ) ? $this->district_state : 27; 

             $districtCountData = DB::table('district_list')
                            ->leftJoin('city', 'city.city_district', '=', 'district_list.district_id')
                            ->leftJoin('driver', 'driver.driver_city_id', '=', 'city.city_id')
                            ->leftJoin('state', 'state.state_id', '=', 'district_list.d_state_id')
                            ->where('district_list.district_name', 'like', '%' . $this->search . '%')       
                            ->leftJoin('vehicle', 'vehicle.vehicle_id', '=', 'driver.driver_assigned_vehicle_id')
                            ->leftJoin('ambulance_category', 'ambulance_category.ambulance_category_type', '=', 'vehicle.vehicle_category_type')
                            ->when($district_state_id !== null, function ($query) use ($district_state_id) {
                                return $query->where('state.state_id', $district_state_id);
                            })  
                            ->selectRaw('
                                state.state_name,
                                district_list.district_name,
                                COUNT(vehicle.vehicle_id) as total_vehicle,
                                COUNT(CASE WHEN ambulance_category.ambulance_category_type = "A" THEN 1 END) as medical_first_responder,
                                COUNT(CASE WHEN ambulance_category.ambulance_category_type = "B" THEN 1 END) as patient_transfer_ambulances,
                                COUNT(CASE WHEN ambulance_category.ambulance_category_type = "C" THEN 1 END) as basic_life_support,
                                COUNT(CASE WHEN ambulance_category.ambulance_category_type = "D" THEN 1 END) as advance_life_support,
                                COUNT(CASE WHEN ambulance_category.ambulance_category_type = "H" THEN 1 END) as dead_body_small,
                                COUNT(CASE WHEN ambulance_category.ambulance_category_type = "J" THEN 1 END) as train_ambulances,
                                COUNT(CASE WHEN ambulance_category.ambulance_category_type = "H1" THEN 1 END) as dead_body_medium,
                                COUNT(CASE WHEN ambulance_category.ambulance_category_type = "H2" THEN 1 END) as dead_body_big,
                                COUNT(CASE WHEN ambulance_category.ambulance_category_type = "B_AC_DLT" THEN 1 END) as patience_ransafer_ac,
                                COUNT(CASE WHEN ambulance_category.ambulance_category_type = "C_AC" THEN 1 END) as basic_life_support_ac,
                                COUNT(CASE WHEN ambulance_category.ambulance_category_type = "H1_AC" THEN 1 END) as dead_body_medium_fridge,
                                COUNT(CASE WHEN ambulance_category.ambulance_category_type = "H2_AC" THEN 1 END) as dead_body_big_fridge
                            ')
                            ->orderBy('total_vehicle','DESC')
                            ->groupBy('state.state_name', 'district_list.district_name') // Group by both state and city
                            ->paginate(10);
     
                            $sumVehicleCountsByDstrict = $districtCountData->sum('total_vehicle');
     
                                $stateData = DB::table('state')
                                ->leftJoin('district_list', 'district_list.d_state_id', '=', 'state.state_id')
                                ->selectRaw('state.state_id,
                                             state.state_name, 
                                             COUNT(DISTINCT district_list.district_id ) as total_district_count')
                                ->groupBy('state.state_id', 'state.state_name')
                                ->get();
     
                                $total_vehicle =  DB::table('vehicle')->count(); 

                                return view('livewire.admin.vehicle.cityor-district-count-component',['districtCountData' => $districtCountData, 'total_vehicle'=>$total_vehicle,'stateData'=>$stateData,'sumVehicleCountsByDstrict'=>$sumVehicleCountsByDstrict]);
                       
                        }

        elseif($this->activeTab=='bookingVehicle'){

            $stateId = ($this->bookingState ) ? $this->bookingState : 27; 

            $driverInfo = DB::table('city')
            ->leftJoin('driver', 'city.city_id', '=', 'driver.driver_city_id')
            ->leftJoin('vehicle', 'vehicle.vehicle_id', '=', 'driver.driver_assigned_vehicle_id')
            ->leftJoin('ambulance_category', 'ambulance_category.ambulance_category_type', '=', 'vehicle.vehicle_category_type')
            ->where('city.city_name', 'like', '%' . $this->search . '%')       
            ->where('city.city_state', $stateId)
            ->selectRaw('
                city.city_name,
                COUNT(vehicle.vehicle_id) as total_vehicle,
                COUNT(CASE WHEN ambulance_category.ambulance_category_type = "A" THEN 1 END) as medical_first_responder,
                COUNT(CASE WHEN ambulance_category.ambulance_category_type = "B" THEN 1 END) as patient_transfer_ambulances,
                COUNT(CASE WHEN ambulance_category.ambulance_category_type = "C" THEN 1 END) as basic_life_support,
                COUNT(CASE WHEN ambulance_category.ambulance_category_type = "D" THEN 1 END) as advance_life_support,
                COUNT(CASE WHEN ambulance_category.ambulance_category_type = "H" THEN 1 END) as dead_body_small,
                COUNT(CASE WHEN ambulance_category.ambulance_category_type = "J" THEN 1 END) as train_ambulances,
                COUNT(CASE WHEN ambulance_category.ambulance_category_type = "H1" THEN 1 END) as dead_body_medium,
                COUNT(CASE WHEN ambulance_category.ambulance_category_type = "H2" THEN 1 END) as dead_body_big,
                COUNT(CASE WHEN ambulance_category.ambulance_category_type = "B_AC_DLT" THEN 1 END) as patience_ransafer_ac,
                COUNT(CASE WHEN ambulance_category.ambulance_category_type = "C_AC" THEN 1 END) as basic_life_support_ac,
                COUNT(CASE WHEN ambulance_category.ambulance_category_type = "H1_AC" THEN 1 END) as dead_body_medium_fridge,
                COUNT(CASE WHEN ambulance_category.ambulance_category_type = "H2_AC" THEN 1 END) as dead_body_big_fridge
            ')
            ->orderBy('total_vehicle','DESC')
            ->groupBy('city.city_name') // Group by both state and city
            ->paginate(5);                        


            $bookingInfo = DB::table('city')
            ->leftJoin('booking_view', 'booking_view.booking_pickup_city', '=', 'city.city_name') 
            ->where('city.city_state', $stateId)
            ->where('city.city_name', 'like', '%' . $this->search . '%')       
            ->selectRaw('
                city.city_name,
                COUNT(CASE WHEN booking_view.booking_id !="0" THEN 1 END ) as total_booking, 
                COUNT(CASE WHEN booking_view.booking_category = "A" THEN 1 END) as medical_first_responder,
                COUNT(CASE WHEN booking_view.booking_category = "B" THEN 1 END) as patient_transfer_ambulances,
                COUNT(CASE WHEN booking_view.booking_category = "C" THEN 1 END) as basic_life_support,
                COUNT(CASE WHEN booking_view.booking_category = "D" THEN 1 END) as advance_life_support,
                COUNT(CASE WHEN booking_view.booking_category = "H" THEN 1 END) as dead_body_small,
                COUNT(CASE WHEN booking_view.booking_category = "J" THEN 1 END) as train_ambulances,
                COUNT(CASE WHEN booking_view.booking_category = "H1" THEN 1 END) as dead_body_medium,
                COUNT(CASE WHEN booking_view.booking_category = "H2" THEN 1 END) as dead_body_big,
                COUNT(CASE WHEN booking_view.booking_category = "" THEN 1 END) as others,
                COUNT(CASE WHEN booking_view.booking_category = "B_AC_DLT" THEN 1 END) as patience_ransafer_ac,
                COUNT(CASE WHEN booking_view.booking_category = "C_AC" THEN 1 END) as basic_life_support_ac,
                COUNT(CASE WHEN booking_view.booking_category = "H1_AC" THEN 1 END) as dead_body_medium_fridge,
                COUNT(CASE WHEN booking_view.booking_category = "H2_AC" THEN 1 END) as dead_body_big_fridge,
                COUNT(CASE WHEN booking_view.booking_status = "0" THEN 1 END) as enquiry_booking,
                COUNT(CASE WHEN booking_view.booking_status = "1" THEN 1 END) as new_booking,
                COUNT(CASE WHEN booking_view.booking_status = "2" THEN 1 END) as ongoing_booking,
                COUNT(CASE WHEN booking_view.booking_status = "3" THEN 1 END) as invoice_booking,
                COUNT(CASE WHEN booking_view.booking_status = "4" THEN 1 END) as complete_booking,
                COUNT(CASE WHEN booking_view.booking_status = "5" THEN 1 END) as cancel_booking,
                COUNT(CASE WHEN booking_view.booking_status = "6" THEN 1 END) as future_booking,
                
                COUNT(CASE WHEN booking_view.booking_status = "0" AND  booking_view.booking_category = "A" THEN 1 END) as enq_booking_a,
                COUNT(CASE WHEN booking_view.booking_status = "0" AND  booking_view.booking_category = "B" THEN 1 END) as enq_booking_b,
                COUNT(CASE WHEN booking_view.booking_status = "0" AND  booking_view.booking_category = "B_AC" THEN 1 END) as enq_booking_b_ac,
                COUNT(CASE WHEN booking_view.booking_status = "0" AND  booking_view.booking_category = "C" THEN 1 END) as enq_booking_c,
                COUNT(CASE WHEN booking_view.booking_status = "0" AND  booking_view.booking_category = "C_AC" THEN 1 END) as enq_booking_c_ac,
                COUNT(CASE WHEN booking_view.booking_status = "0" AND  booking_view.booking_category = "D" THEN 1 END) as enq_booking_d,
                COUNT(CASE WHEN booking_view.booking_status = "0" AND  booking_view.booking_category = "H" THEN 1 END) as enq_booking_h,
                COUNT(CASE WHEN booking_view.booking_status = "0" AND  booking_view.booking_category = "H1" THEN 1 END) as enq_booking_h1,
                COUNT(CASE WHEN booking_view.booking_status = "0" AND  booking_view.booking_category = "H1_AC" THEN 1 END) as enq_booking_h1_ac,
                COUNT(CASE WHEN booking_view.booking_status = "0" AND  booking_view.booking_category = "H2" THEN 1 END) as enq_booking_h2,
                COUNT(CASE WHEN booking_view.booking_status = "0" AND  booking_view.booking_category = "H2_AC" THEN 1 END) as enq_booking_h_ac,
                COUNT(CASE WHEN booking_view.booking_status = "0" AND  booking_view.booking_category = " " THEN 1 END) as enq_booking_no_cat,

                
                COUNT(CASE WHEN booking_view.booking_status = "1" AND  booking_view.booking_category = "A" THEN 1 END) as new_booking_a,
                COUNT(CASE WHEN booking_view.booking_status = "1" AND  booking_view.booking_category = "B" THEN 1 END) as new_booking_b,
                COUNT(CASE WHEN booking_view.booking_status = "1" AND  booking_view.booking_category = "B_AC" THEN 1 END) as new_booking_b_ac,
                COUNT(CASE WHEN booking_view.booking_status = "1" AND  booking_view.booking_category = "C" THEN 1 END) as new_booking_c,
                COUNT(CASE WHEN booking_view.booking_status = "1" AND  booking_view.booking_category = "C_AC" THEN 1 END) as new_booking_c_ac,
                COUNT(CASE WHEN booking_view.booking_status = "1" AND  booking_view.booking_category = "D" THEN 1 END) as new_booking_d,
                COUNT(CASE WHEN booking_view.booking_status = "1" AND  booking_view.booking_category = "H" THEN 1 END) as new_booking_h,
                COUNT(CASE WHEN booking_view.booking_status = "1" AND  booking_view.booking_category = "H1" THEN 1 END) as new_booking_h1,
                COUNT(CASE WHEN booking_view.booking_status = "1" AND  booking_view.booking_category = "H1_AC" THEN 1 END) as new_booking_h1_ac,
                COUNT(CASE WHEN booking_view.booking_status = "1" AND  booking_view.booking_category = "H2" THEN 1 END) as new_booking_h2,
                COUNT(CASE WHEN booking_view.booking_status = "1" AND  booking_view.booking_category = "H2_AC" THEN 1 END) as new_booking_h_ac,
                COUNT(CASE WHEN booking_view.booking_status = "1" AND  booking_view.booking_category = " " THEN 1 END) as new_booking_no_cat,

                COUNT(CASE WHEN booking_view.booking_status = "2" AND  booking_view.booking_category = "A" THEN 1 END) as ongoing_booking_a,
                COUNT(CASE WHEN booking_view.booking_status = "2" AND  booking_view.booking_category = "B" THEN 1 END) as ongoing_booking_b,
                COUNT(CASE WHEN booking_view.booking_status = "2" AND  booking_view.booking_category = "B_AC" THEN 1 END) as ongoing_booking_b_ac,
                COUNT(CASE WHEN booking_view.booking_status = "2" AND  booking_view.booking_category = "C" THEN 1 END) as ongoing_booking_c,
                COUNT(CASE WHEN booking_view.booking_status = "2" AND  booking_view.booking_category = "C_AC" THEN 1 END) as ongoing_booking_c_ac,
                COUNT(CASE WHEN booking_view.booking_status = "2" AND  booking_view.booking_category = "D" THEN 1 END) as ongoing_booking_d,
                COUNT(CASE WHEN booking_view.booking_status = "2" AND  booking_view.booking_category = "H" THEN 1 END) as ongoing_booking_h,
                COUNT(CASE WHEN booking_view.booking_status = "2" AND  booking_view.booking_category = "H1" THEN 1 END) as ongoing_booking_h1,
                COUNT(CASE WHEN booking_view.booking_status = "2" AND  booking_view.booking_category = "H1_AC" THEN 1 END) as ongoing_booking_h1_ac,
                COUNT(CASE WHEN booking_view.booking_status = "2" AND  booking_view.booking_category = "H2" THEN 1 END) as ongoing_booking_h2,
                COUNT(CASE WHEN booking_view.booking_status = "2" AND  booking_view.booking_category = "H2_AC" THEN 1 END) as ongoing_booking_h_ac,
                COUNT(CASE WHEN booking_view.booking_status = "2" AND  booking_view.booking_category = " " THEN 1 END) as ongoing_booking_no_cat,
                
                
                COUNT(CASE WHEN booking_view.booking_status = "3" AND  booking_view.booking_category = "A" THEN 1 END) as invoice_booking_a,
                COUNT(CASE WHEN booking_view.booking_status = "3" AND  booking_view.booking_category = "B" THEN 1 END) as invoice_booking_b,
                COUNT(CASE WHEN booking_view.booking_status = "3" AND  booking_view.booking_category = "B_AC" THEN 1 END) as invoice_booking_b_ac,
                COUNT(CASE WHEN booking_view.booking_status = "3" AND  booking_view.booking_category = "C" THEN 1 END) as invoice_booking_c,
                COUNT(CASE WHEN booking_view.booking_status = "3" AND  booking_view.booking_category = "C_AC" THEN 1 END) as invoice_booking_c_ac,
                COUNT(CASE WHEN booking_view.booking_status = "3" AND  booking_view.booking_category = "D" THEN 1 END) as invoice_booking_d,
                COUNT(CASE WHEN booking_view.booking_status = "3" AND  booking_view.booking_category = "H" THEN 1 END) as invoice_booking_h,
                COUNT(CASE WHEN booking_view.booking_status = "3" AND  booking_view.booking_category = "H1" THEN 1 END) as invoice_booking_h1,
                COUNT(CASE WHEN booking_view.booking_status = "3" AND  booking_view.booking_category = "H1_AC" THEN 1 END) as invoice_booking_h1_ac,
                COUNT(CASE WHEN booking_view.booking_status = "3" AND  booking_view.booking_category = "H2" THEN 1 END) as invoice_booking_h2,
                COUNT(CASE WHEN booking_view.booking_status = "3" AND  booking_view.booking_category = "H2_AC" THEN 1 END) as invoice_booking_h_ac,
                COUNT(CASE WHEN booking_view.booking_status = "3" AND  booking_view.booking_category = " " THEN 1 END) as invoice_booking_no_cat,
                
                
                
                COUNT(CASE WHEN booking_view.booking_status = "4" AND  booking_view.booking_category = "A" THEN 1 END) as complete_booking_a,
                COUNT(CASE WHEN booking_view.booking_status = "4" AND  booking_view.booking_category = "B" THEN 1 END) as complete_booking_b,
                COUNT(CASE WHEN booking_view.booking_status = "4" AND  booking_view.booking_category = "B_AC" THEN 1 END) as complete_booking_b_ac,
                COUNT(CASE WHEN booking_view.booking_status = "4" AND  booking_view.booking_category = "C" THEN 1 END) as complete_booking_c,
                COUNT(CASE WHEN booking_view.booking_status = "4" AND  booking_view.booking_category = "C_AC" THEN 1 END) as complete_booking_c_ac,
                COUNT(CASE WHEN booking_view.booking_status = "4" AND  booking_view.booking_category = "D" THEN 1 END) as complete_booking_d,
                COUNT(CASE WHEN booking_view.booking_status = "4" AND  booking_view.booking_category = "H" THEN 1 END) as complete_booking_h,
                COUNT(CASE WHEN booking_view.booking_status = "4" AND  booking_view.booking_category = "H1" THEN 1 END) as complete_booking_h1,
                COUNT(CASE WHEN booking_view.booking_status = "4" AND  booking_view.booking_category = "H1_AC" THEN 1 END) as complete_booking_h1_ac,
                COUNT(CASE WHEN booking_view.booking_status = "4" AND  booking_view.booking_category = "H2" THEN 1 END) as complete_booking_h2,
                COUNT(CASE WHEN booking_view.booking_status = "4" AND  booking_view.booking_category = "H2_AC" THEN 1 END) as complete_booking_h_ac,
                COUNT(CASE WHEN booking_view.booking_status = "4" AND  booking_view.booking_category = " " THEN 1 END) as complete_booking_no_cat,

                COUNT(CASE WHEN booking_view.booking_status = "5" AND  booking_view.booking_category = "A" THEN 1 END) as cancel_booking_a,
                COUNT(CASE WHEN booking_view.booking_status = "5" AND  booking_view.booking_category = "B" THEN 1 END) as cancel_booking_b,
                COUNT(CASE WHEN booking_view.booking_status = "5" AND  booking_view.booking_category = "B_AC" THEN 1 END) as cancel_booking_b_ac,
                COUNT(CASE WHEN booking_view.booking_status = "5" AND  booking_view.booking_category = "C" THEN 1 END) as cancel_booking_c,
                COUNT(CASE WHEN booking_view.booking_status = "5" AND  booking_view.booking_category = "C_AC" THEN 1 END) as cancel_booking_c_ac,
                COUNT(CASE WHEN booking_view.booking_status = "5" AND  booking_view.booking_category = "D" THEN 1 END) as cancel_booking_d,
                COUNT(CASE WHEN booking_view.booking_status = "5" AND  booking_view.booking_category = "H" THEN 1 END) as cancel_booking_h,
                COUNT(CASE WHEN booking_view.booking_status = "5" AND  booking_view.booking_category = "H1" THEN 1 END) as cancel_booking_h1,
                COUNT(CASE WHEN booking_view.booking_status = "5" AND  booking_view.booking_category = "H1_AC" THEN 1 END) as cancel_booking_h1_ac,
                COUNT(CASE WHEN booking_view.booking_status = "5" AND  booking_view.booking_category = "H2" THEN 1 END) as cancel_booking_h2,
                COUNT(CASE WHEN booking_view.booking_status = "5" AND  booking_view.booking_category = "H2_AC" THEN 1 END) as cancel_booking_h_ac,
                COUNT(CASE WHEN booking_view.booking_status = "5" AND  booking_view.booking_category = " " THEN 1 END) as cancel_booking_no_cat,


                
                COUNT(CASE WHEN booking_view.booking_status = "6" AND  booking_view.booking_category = "A" THEN 1 END) as future_booking_a,
                COUNT(CASE WHEN booking_view.booking_status = "6" AND  booking_view.booking_category = "B" THEN 1 END) as future_booking_b,
                COUNT(CASE WHEN booking_view.booking_status = "6" AND  booking_view.booking_category = "B_AC" THEN 1 END) as future_booking_b_ac,
                COUNT(CASE WHEN booking_view.booking_status = "6" AND  booking_view.booking_category = "C" THEN 1 END) as future_booking_c,
                COUNT(CASE WHEN booking_view.booking_status = "6" AND  booking_view.booking_category = "C_AC" THEN 1 END) as future_booking_c_ac,
                COUNT(CASE WHEN booking_view.booking_status = "6" AND  booking_view.booking_category = "D" THEN 1 END) as future_booking_d,
                COUNT(CASE WHEN booking_view.booking_status = "6" AND  booking_view.booking_category = "H" THEN 1 END) as future_booking_h,
                COUNT(CASE WHEN booking_view.booking_status = "6" AND  booking_view.booking_category = "H1" THEN 1 END) as future_booking_h1,
                COUNT(CASE WHEN booking_view.booking_status = "6" AND  booking_view.booking_category = "H1_AC" THEN 1 END) as future_booking_h1_ac,
                COUNT(CASE WHEN booking_view.booking_status = "6" AND  booking_view.booking_category = "H2" THEN 1 END) as future_booking_h2,
                COUNT(CASE WHEN booking_view.booking_status = "6" AND  booking_view.booking_category = "H2_AC" THEN 1 END) as future_booking_h_ac,
                COUNT(CASE WHEN booking_view.booking_status = "6" AND  booking_view.booking_category = " " THEN 1 END) as future_booking_no_cat
            ') 
            ->groupBy('city.city_name') // Group by both state and city
            ->get();  
            
            $stateData = DB::table('state')
            ->leftJoin('city', 'city.city_state', '=', 'state.state_id')
            ->selectRaw('state.state_id,
                         state.state_name, 
                         COUNT(DISTINCT city.city_id ) as total_city_count')
            ->groupBy('state.state_id', 'state.state_name')
            ->get();

            $total_data = ['driverInfo' => $driverInfo, 'bookingInfo' => $bookingInfo];

            return view('livewire.admin.vehicle.cityor-district-count-component',['total_data' => $total_data,'stateData'=>$stateData],compact('driverInfo'));

        }elseif($this->activeTab=='districtWise'){

            $districtWise_state_id = ($this->districtWise_state ) ? $this->districtWise_state : 27;

           if($this->vehicleCreated = 'All')
            {
                $stateData = DB::table('state')
                ->leftJoin('district_list', 'state.state_id', '=', 'district_list.d_state_id')
                ->leftJoin('city', 'district_list.district_id', '=', 'city.city_district')
                ->leftJoin('driver', 'city.city_id', '=', 'driver.driver_city_id')
                ->leftJoin('vehicle', 'vehicle.vehicle_id', '=', 'driver.driver_assigned_vehicle_id')
                ->selectRaw('state.state_id,
                             state.state_name, 
                             COUNT(DISTINCT district_list.district_id) as district_count,
                             COUNT(DISTINCT vehicle.vehicle_id) as total_vehicle_count')
                ->groupBy('state.state_id', 'state.state_name')
                ->get();
                        
                $total_vehicle =  DB::table('vehicle')->get(); 
    
                $driverQuery = DB::table('district_list')
                    ->leftJoin('city', 'city.city_district', '=', 'district_list.district_id')
                    ->leftJoin('state', 'state.state_id', '=', 'district_list.d_state_id')
                    ->leftJoin('driver', 'driver.driver_city_id', '=', 'city.city_id')
                    ->where('district_list.district_name', 'like', '%' . $this->search . '%')       
                    ->leftJoin('vehicle', 'vehicle.vehicle_id', '=', 'driver.driver_assigned_vehicle_id')
                    ->when($districtWise_state_id !== null, function ($query) use ($districtWise_state_id) {
                        return $query->where('state.state_id', $districtWise_state_id);
                    })                 
                    ->where('vehicle.vehicle_added_type', '=', '0')
                    ->groupBy('state.state_name', 'district_list.district_name')
                    ->selectRaw('state.state_name, district_list.district_name, 
                                COALESCE(COUNT(vehicle.vehicle_id), 0) as vehicle_count, 
                                COUNT(CASE WHEN driver.driver_duty_status = "ON" THEN 1 ELSE null END) as on_duty_count,
                                COUNT(CASE WHEN driver.driver_duty_status = "OFF" THEN 1 ELSE null END) as off_duty_count');
            
                $partnerQuery = DB::table('district_list')
                    ->leftJoin('city', 'city.city_district', '=', 'district_list.district_id')
                    ->leftJoin('state', 'state.state_id', '=', 'district_list.d_state_id')
                    ->leftJoin('partner', 'partner.partner_city_id', '=', 'city.city_id')
                    ->where('district_list.district_name', 'like', '%' . $this->search . '%')       
                    ->leftJoin('vehicle', 'vehicle.vehicle_added_by', '=', 'partner.partner_id')
                    ->leftJoin('driver', 'driver.driver_created_partner_id', '=', 'partner.partner_id')
                    ->when($districtWise_state_id !== null, function ($query) use ($districtWise_state_id) {
                        return $query->where('state.state_id', $districtWise_state_id);
                    })   
                    ->where('vehicle.vehicle_added_type', '=', '1')
                    ->where('driver.driver_created_by', '=', '1')
                    ->groupBy('state.state_name', 'district_list.district_name')
                    ->selectRaw('state.state_name, district_list.district_name, 
                                COALESCE(COUNT(vehicle.vehicle_id), 0) as vehicle_count, 
                                COUNT(CASE WHEN driver.driver_duty_status = "ON" THEN 1 ELSE null END) as on_duty_count,
                                COUNT(CASE WHEN driver.driver_duty_status = "OFF" THEN 1 ELSE null END) as off_duty_count');
            
                $driverResults = $driverQuery->paginate(10);
                $partnerResults = $partnerQuery->paginate(10);
            
                $results = $driverResults->concat($partnerResults);
            
                $responseData = [];
            
                foreach ($results as $result) {
                    $responseData[] = [
                        'state_name' => $result->state_name,
                        'district_name' => $result->district_name,
                        'vehicle_count' => $result->vehicle_count,
                        'on_duty_count' => $result->on_duty_count,
                        'off_duty_count' => $result->off_duty_count,
                    ];
                }
            
                $totalDataOfVehicle = DB::table('vehicle')->count();
                return view('livewire.admin.vehicle.vehicle-filter-data-component',['total_vehicle' => $total_vehicle,'stateData'=>$stateData,'responseData'=>$responseData,'totalDataOfVehicle'=>$totalDataOfVehicle]);
            }else{
                dd("No Data Available");
            }
  

        }elseif($this->activeTab=='divisionWise'){

            $division_state_id = ($this->division_state ) ? $this->division_state : 27;

            if($this->vehicleCreated = 'All')
             {
               
                $stateData = DB::table('state')
                ->leftJoin('division', 'state.state_id', '=', 'division.division_state_id')
                ->leftJoin('city', 'division.division_id', '=', 'city.city_division')
                ->leftJoin('driver', 'city.city_id', '=', 'driver.driver_city_id')
                ->leftJoin('vehicle', 'vehicle.vehicle_id', '=', 'driver.driver_assigned_vehicle_id')
                ->selectRaw('state.state_id,
                             state.state_name, 
                             COUNT(DISTINCT division.division_id) as division_count,
                             COUNT(DISTINCT vehicle.vehicle_id) as total_vehicle_count')
                ->groupBy('state.state_id', 'state.state_name')
                ->get();

            $driverQuery = DB::table('division')
                ->leftJoin('city', 'city.city_division', '=', 'division.division_id')
                ->leftJoin('state', 'state.state_id', '=', 'division.division_state_id')
                ->leftJoin('driver', 'driver.driver_city_id', '=', 'city.city_id')
                ->leftJoin('vehicle', 'vehicle.vehicle_id', '=', 'driver.driver_assigned_vehicle_id')
                ->where('division.division_name', 'like', '%' . $this->search . '%')       
                ->where('state.state_id', $division_state_id)
                ->where('vehicle.vehicle_added_type', '=', '0')
                ->groupBy('state.state_name', 'division.division_name')
                ->selectRaw('state.state_name, division.division_name, COALESCE(COUNT(vehicle.vehicle_id), 0) as vehicle_count');

            $partnerQuery = DB::table('division')
                ->leftJoin('city', 'city.city_division', '=', 'division.division_id')
                ->leftJoin('state', 'state.state_id', '=', 'division.division_state_id')
                ->leftJoin('partner', 'partner.partner_city_id', '=', 'city.city_id')
                ->leftJoin('vehicle', 'vehicle.vehicle_added_by', '=', 'partner.partner_id')
                ->where('state.state_id', $division_state_id)
                ->where('division.division_name', 'like', '%' . $this->search . '%')       
                ->where('vehicle.vehicle_added_type', '=', '1')
                ->groupBy('state.state_name', 'division.division_name')
                ->selectRaw('state.state_name, division.division_name, COALESCE(COUNT(vehicle.vehicle_id), 0) as vehicle_count');

            $results = DB::query()
                ->fromSub($driverQuery, 'driver_counts')
                ->unionAll(DB::query()->fromSub($partnerQuery, 'partner_counts'))
                ->get();

            $divisionData = [];

            foreach ($results as $result) {
                $divisionData[] = [
                    'state_name' => $result->state_name,
                    'division_name' => $result->division_name,
                    'vehicle_count' => $result->vehicle_count,
                ];
            }
                $totalDataOfVehicle = DB::table('vehicle')->count();

                 return view('livewire.admin.vehicle.vehicle-filter-data-component',['stateData'=>$stateData,'divisionData'=>$divisionData,'totalDataOfVehicle'=>$totalDataOfVehicle]);
             }else{
                 dd("No Data Available");
             }
            
        }elseif($this->activeTab=='cityWiseBooking'){
          
            $division_state_id = ($this->division_state ) ? $this->division_state : 27;
            $fromDate = $this->selectedFromDate ? Carbon::createFromFormat('Y-m-d', $this->selectedFromDate)->startOfDay() : null;
            $toDate = $this->selectedToDate ? Carbon::createFromFormat('Y-m-d', $this->selectedToDate)->endOfDay() : null;
  
            if($this->selectedDate == 'custom'){
              $this->selectedFromDate;
              $this->selectedToDate;
              }else{
                  $this->selectedFromDate ='';
                  $this->selectedToDate =''; 
              }
           
            switch ($this->selectedDate) {
                case 'all':
                    $fromDate = null;
                    $toDate = null;
                    break;
                case 'today':
                    $fromDate = Carbon::today();
                    $toDate = Carbon::today()->endOfDay();
                    break;
                case 'yesterday':
                    $fromDate = Carbon::yesterday();
                    $toDate = Carbon::yesterday()->endOfDay();
                    break;
                case 'thisWeek':
                    $fromDate = Carbon::now()->subDays(7)->startOfDay();
                    $toDate = Carbon::now();
                    break;
                case 'thisMonth':
                    $fromDate = Carbon::now()->startOfMonth();
                    $toDate = Carbon::now()->endOfMonth();
                    break;
                default:
                    $fromDate = $fromDate;
                    $toDate = $toDate;
                    break;
            }

            $bookingData = DB::table('city')
            ->leftJoin('booking_view', 'booking_view.booking_pickup_city', '=', 'city.city_name') 
            ->where('city.city_state', $division_state_id)
            ->selectRaw('
                city.city_name,
                COUNT(CASE WHEN booking_view.booking_id !="0" THEN 1 END ) as total_booking, 
                COUNT(CASE WHEN booking_view.booking_status = "0" THEN 1 END) as enquiry_booking,
                COUNT(CASE WHEN booking_view.booking_status = "1" THEN 1 END) as new_booking,
                COUNT(CASE WHEN booking_view.booking_status = "2" THEN 1 END) as ongoing_booking,
                COUNT(CASE WHEN booking_view.booking_status = "3" THEN 1 END) as invoice_booking,
                COUNT(CASE WHEN booking_view.booking_status = "4" THEN 1 END) as complete_booking,
                COUNT(CASE WHEN booking_view.booking_status = "5" THEN 1 END) as cancel_booking,
                COUNT(CASE WHEN booking_view.booking_status = "6" THEN 1 END) as future_booking') 
                ->where('booking_view.booking_status','<>','7')
                ->where('city.city_name', 'like', '%' . $this->search . '%')       
                ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                    return $query->whereBetween('booking_view.created_at', [$fromDate, $toDate]);
                })
                ->orderBy('total_booking','DESC')
                ->groupBy('city.city_name') // Group by both state and city
                ->paginate(10);  

                $stateData = DB::table('state')
                ->leftJoin('city', 'city.city_state', '=', 'state.state_id')
                ->selectRaw('state.state_id,
                            state.state_name, 
                            COUNT(DISTINCT city.city_id ) as total_city_count')
                ->groupBy('state.state_id', 'state.state_name')
                ->get();

                if($this->check_for == 'custom'){
                    return view('livewire.admin.vehicle.vehicle-filter-data-component',[
                        'isCustom' => true
                    ],compact('bookingData','stateData'));
                }
                return view('livewire.admin.vehicle.vehicle-filter-data-component',[
                    'isCustom' => false
                ],compact('bookingData','stateData'));

        }elseif($this->activeTab=='documentExpiry'){
            dd("documentExpiry");

        }elseif($this->activeTab=='totalData'){

            $stateId = ($this->division_state ) ? $this->division_state : 27;

            $partnerData = DB::table('city')
            ->select('city_name', DB::raw('(SELECT COUNT(*) FROM partner WHERE partner_city_id = city_id) as total_partners'))
            ->where('city.city_name', 'like', '%' . $this->search . '%')       
            ->where('city_state', $stateId)
            ->paginate(10);
        
                        
            $partnerdriverData = DB::table('city')
              ->select('city_name', DB::raw('(SELECT COUNT(*) FROM driver WHERE driver_created_by = 1 AND driver_city_id = city_id) as total_count'))
              ->where('city.city_state', $stateId)
              ->where('city.city_name', 'like', '%' . $this->search . '%')       
              ->paginate(10);

          // Fetching partner vehicle data
              $partnervehicleData = DB::table('city')
              ->select('city_name', DB::raw('(SELECT COUNT(*) FROM vehicle LEFT JOIN partner ON partner.partner_id = vehicle.vehicle_added_by  WHERE vehicle.vehicle_added_type = 1 AND partner.partner_city_id = city_id) as total_count'))
              ->where('city.city_state', $stateId)
              ->where('city.city_name', 'like', '%' . $this->search . '%')       
              ->paginate(10);


          // Fetching self driver data
          $selfdriverData = DB::table('city')
          ->select('city_name', DB::raw('(SELECT COUNT(*) FROM driver WHERE driver_created_by = 0 AND driver_city_id = city_id) as total_count'))
          ->where('city.city_state', $stateId)
          ->where('city.city_name', 'like', '%' . $this->search . '%')       
          ->paginate(10);

          // Fetching self vehicle data
          $selfvehicleData = DB::table('city')
          ->select('city_name', DB::raw('(SELECT COUNT(*) FROM vehicle LEFT JOIN driver ON driver.driver_assigned_vehicle_id = vehicle.vehicle_id  WHERE vehicle.vehicle_added_type = 0 AND driver.driver_city_id = city_id) as total_count'))
          ->where('city.city_state', $stateId)
          ->where('city.city_name', 'like', '%' . $this->search . '%')       
          ->paginate(10);

          // Organizing data
          $partertotalData = [
              'partnerData' => $partnerData,
              'partnerdriverData' => $partnerdriverData,
              'partnervehicleData' => $partnervehicleData,
          ];

          $drivertotalData = [
              'selfdriverData' => $selfdriverData,
              'selfvehicleData' => $selfvehicleData,
          ];

          $totalData = [
              'partertotalData' => $partertotalData,
              'drivertotalData' => $drivertotalData,
          ];


              $stateData = DB::table('state')
              ->leftJoin('city', 'city.city_state', '=', 'state.state_id')
              ->selectRaw('state.state_id,
                           state.state_name, 
                           COUNT(DISTINCT city.city_id ) as total_city_count')
              ->groupBy('state.state_id', 'state.state_name')
              ->get();
          
              return view('livewire.admin.vehicle.vehicle-filter-data-component',['totalData' => $totalData,'stateData'=>$stateData],compact('partnerData','selfdriverData'));

        }

          $vehicleStatusFilter = $this->vehicleStatusFilter ? $this->vehicleStatusFilter : null;
          $fromDate = $this->selectedFromDate ? Carbon::createFromFormat('Y-m-d', $this->selectedFromDate)->startOfDay() : null;
          $toDate = $this->selectedToDate ? Carbon::createFromFormat('Y-m-d', $this->selectedToDate)->endOfDay() : null;

          
          if($this->selectedDate == 'custom'){
            $this->selectedFromDate;
            $this->selectedToDate;
            }else{
                $this->selectedFromDate ='';
                $this->selectedToDate =''; 
            }
         
          switch ($this->selectedDate) {
              case 'all':
                  $fromDate = null;
                  $toDate = null;
                  break;
              case 'today':
                  $fromDate = Carbon::today();
                  $toDate = Carbon::today()->endOfDay();
                  break;
              case 'yesterday':
                  $fromDate = Carbon::yesterday();
                  $toDate = Carbon::yesterday()->endOfDay();
                  break;
              case 'thisWeek':
                  $fromDate = Carbon::now()->subDays(7)->startOfDay();
                  $toDate = Carbon::now();
                  break;
              case 'thisMonth':
                  $fromDate = Carbon::now()->startOfMonth();
                  $toDate = Carbon::now()->endOfMonth();
                  break;
              default:
                  $fromDate = $fromDate;
                  $toDate = $toDate;
                  break;
          }
         
          $vehicleDetails = DB::table('vehicle')
          ->select(
              'vehicle.*',
              'partner.partner_id',
              'partner.partner_f_name',
              'partner.partner_l_name',
              'partner.partner_mobile',
              'partner.partner_wallet',
              'ambulance_category.ambulance_category_name',
              'remark_data.remark_id',
              'remark_data.remark_vehicle_id',
              'remark_data.remark_text',
              'admin.admin_name',
          )
          ->orderBy('vehicle.vehicle_id', 'desc')
          ->leftJoin('remark_data', 'vehicle.vehicle_id', '=', 'remark_data.remark_vehicle_id')
          ->leftJoin('ambulance_category', 'ambulance_category.ambulance_category_type', '=', 'vehicle.vehicle_category_type')
          ->leftJoin('admin', 'admin.id', '=', 'remark_data.remark_type')
          ->where(function ($query) {
            $query->where('vehicle.vehicle_rc_number', 'like', '%' . $this->search . '%')
                ->orWhere('ambulance_category.ambulance_category_name', 'like', '%' . $this->search . '%');
        })
          ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
            return $query->whereBetween('vehicle.created_at', [$fromDate, $toDate]);
        })
          ->when($vehicleStatusFilter !==null && $vehicleStatusFilter == 'New', function ($query) use ($vehicleStatusFilter){
            return $query->where('vehicle.vehicle_status',0);
        })
        ->when($vehicleStatusFilter !==null && $vehicleStatusFilter == 'All', function ($query) use ($vehicleStatusFilter){
            return $query->whereIn('vehicle.vehicle_status',[1,0]);
        })
        ->when($vehicleStatusFilter !==null && $vehicleStatusFilter == 'Active', function ($query) use ($vehicleStatusFilter){
            return $query->where('vehicle.vehicle_status',1);
        })
        ->when($vehicleStatusFilter !==null && $vehicleStatusFilter == 'Partner', function ($query) use ($vehicleStatusFilter){
            return $query->where('vehicle.vehicle_added_type',1);
        })
        ->when($vehicleStatusFilter !==null && $vehicleStatusFilter == 'Driver', function ($query) use ($vehicleStatusFilter){
            return $query->where('vehicle.vehicle_added_type',0);
        })
          ->leftJoin('partner', 'vehicle.vehicle_added_by', '=', 'partner.partner_id')
          ->paginate(10);
  
      $data = [];
  
      foreach ($vehicleDetails as $vehicle) {
          $active_drivers = DB::table('driver')
              ->select(
                  'driver.*',
                  'vehicle.vehicle_id',
                  'vehicle.vehicle_rc_number'
              )
              ->leftJoin('vehicle', 'driver.driver_assigned_vehicle_id', '=', 'vehicle.vehicle_id')
              ->where('driver.driver_assigned_vehicle_id', $vehicle->vehicle_id)
              ->get();
  
          $vehicleData = [
              'vehicle' => $vehicle,
              'active_drivers' => $active_drivers
          ];
  
          array_push($data, $vehicleData);
      }

      if($this->check_for == 'custom'){
        return view('livewire.admin.vehicle.vehicle-component',[
            'isCustom' => true
        ],compact('data','vehicleDetails'));
    }
    return view('livewire.admin.vehicle.vehicle-component',[
        'isCustom' => false
    ],compact('data','vehicleDetails'));

    }


}
