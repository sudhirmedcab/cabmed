<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\DB; 
use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class DriverDetailComponent extends Component
{

    public $driverId,$activeTab,$booking_status,$selectedDate,$filterConditionl, 
    $selectedFromDate,$selectedToDate, $fromDate=null, 
    $toDate=null,$fromdate, $todate;

    #[Layout('livewire.admin.layouts.base')]

    public function resetFilters(){
          
        $this->booking_status=null;
        $this->selectedDate=null;
    }

    public function filterCondition($value){

        $this->resetFilters();
        if($value=='driver_details'){            
            $this->activeTab=$value;
        }
    
        if($value=='Enquiry'){
            $this->booking_status='0';
            $this->activeTab=$value;
        }
        if($value=='New'){
            $this->booking_status = '1';
            $this->activeTab=$value;
        }
    
        if($value=='Ongoing'){
            $this->booking_status='2';
            $this->activeTab=$value;
        }
        if($value=='Invoice'){
            $this->booking_status = '3';
            $this->activeTab=$value;
        }
    
        if($value=='Complete'){
            $this->booking_status='4';
            $this->activeTab=$value;
        }
        if($value=='Cancel'){
            $this->booking_status = '5';
            $this->activeTab=$value;
        }
        if($value=='Transaction'){
            $this->activeTab=$value;
        }
        if($value=='Map'){
            $this->activeTab=$value;
        }
  
}
    public function render()
    {

       $driver_id = $this->driverId;

       $decryptdriverId = decrypt($driver_id);

            $driver_details = DB::table('driver')
            ->leftJoin('driver_details', 'driver.driver_id', '=', 'driver_details.driver_details_driver_id')
            ->leftJoin('driver_live_location', 'driver.driver_id', '=', 'driver_live_location.driver_live_location_d_id')
            ->leftJoin('vehicle', 'driver.driver_assigned_vehicle_id', '=', 'vehicle.vehicle_id')
            ->leftJoin('vehicle_details', 'vehicle_details.vehicle_details_vheicle_id', '=', 'vehicle.vehicle_id')
            ->leftJoin('ambulance_category', 'vehicle.vehicle_category_type', '=', 'ambulance_category.ambulance_category_type')
            ->leftJoin('booking_view', 'driver.driver_id', '=', 'booking_view.booking_acpt_driver_id')
            ->leftJoin('partner', 'driver.driver_created_partner_id', '=', 'partner.partner_id')
            ->leftJoin('city', 'driver.driver_city_id', '=', 'city.city_id')
            ->where('driver_id', $decryptdriverId)
            ->leftJoin('state', 'state.state_id', '=', 'city.city_state')
            ->first();
    
             $ambulance_category_type = $driver_details->ambulance_category_type;
             $ambulanceKit = DB::table('ambulance_facilities')->where('ambulance_facilities_category_type', $ambulance_category_type)->get();
    
             return view('livewire.admin.driver-detail-component',compact('driver_details','ambulanceKit'));
        }

}
