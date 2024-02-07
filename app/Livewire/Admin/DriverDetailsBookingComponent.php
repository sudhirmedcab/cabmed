<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\DB; 
use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class DriverDetailsBookingComponent extends Component
{

    public $driverId,$activeTab,$booking_status,$selectedDate,$filterConditionl, 
    $selectedFromDate,$selectedToDate, $fromDate=null, 
    $toDate=null,$fromdate, $todate,$check_for;

    protected $paginationTheme = 'bootstrap';
    // 
    public $search = '';
    public $sortBy = 'name';

    #[Layout('livewire.admin.layouts.base')]

    public function resetFilters(){
        $this->selectedDate=null;
    }

    public function filterCondition($value){

        $this->resetFilters();
        if($value=='null'){            
            $this->activeTab=$value;
        }
    
        if($value=='Enquiry'){
            $this->activeTab=$value;
        }
        if($value=='New'){
            $this->activeTab=$value;
        }
    
        if($value=='Ongoing'){
            $this->activeTab=$value;
        }
        if($value=='Invoice'){
            $this->activeTab=$value;
        }
    
        if($value=='Complete'){
            $this->activeTab=$value;
        }
        if($value=='Cancel'){
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

        $booking_status = $this->booking_status ? $this->booking_status : null;
                
        $fromDate = $this->selectedFromDate ? Carbon::createFromFormat('Y-m-d', $this->selectedFromDate)->startOfDay() : null;
        $toDate = $this->selectedToDate ? Carbon::createFromFormat('Y-m-d', $this->selectedToDate)->endOfDay() : null;

        if($this->selectedFromDate && $this->selectedToDate){
                $this->selectedDate = null;     
            }
            
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

            if($booking_status == 'transaction'){

                $transactionDetails = DB::table('driver')
                ->leftJoin('driver_transection', 'driver.driver_id', '=', 'driver_transection.driver_transection_by')
                ->where(function ($query) {
                    $query->where('driver.driver_name', 'like', '%' . $this->search . '%')
                        ->orWhere('driver.driver_last_name', 'like', '%' . $this->search . '%');
                })
                ->where('driver_id','=',$this->driverId)
                ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                    return $query->whereBetween('driver_transection.created_at', [$fromDate, $toDate]);
                }) 
                ->orderBy('driver_transection.driver_transection_id','desc')
                ->paginate(10);

                $driverDetails = DB::table('driver')
                ->where('driver_id',$this->driverId)->first();

                if($this->check_for == 'custom'){
                    return view('livewire.admin.driver-transaction-list-component',['isCustom'=>true],compact('transactionDetails','driverDetails'));
                    }else {
                       return view('livewire.admin.driver-transaction-list-component',['isCustom'=>false],compact('transactionDetails','driverDetails'));
                   }            
            }

            if($booking_status == 'map'){

                $driver_details=DB::table('driver') ->where([
                    ['driver_id', '=', $this->driverId]
                ])
                ->leftJoin('driver_details', 'driver.driver_id', '=', 'driver_details.driver_details_driver_id')
                ->leftJoin('driver_live_location', 'driver.driver_id', '=', 'driver_live_location.driver_live_location_d_id')
                ->leftJoin('vehicle', 'driver.driver_assigned_vehicle_id', '=', 'vehicle.vehicle_id')
                ->leftJoin('ambulance_category', 'vehicle.vehicle_category_type', '=', 'ambulance_category.ambulance_category_type')
                ->leftJoin('partner', 'driver.driver_created_partner_id', '=', 'partner.partner_id')
                ->leftJoin('booking_view', 'driver.driver_id', '=', 'booking_view.booking_acpt_driver_id')
                ->leftJoin('city', 'driver.driver_city_id', '=', 'city.city_id')
                ->leftJoin('state', 'state.state_id', '=', 'city.city_state')
                ->get();
        
                $buket_map_data = [];
        
                foreach($driver_details as $location_data){
                    $add_data['driver_live_location_lat'] = $location_data->driver_live_location_lat;
                    $add_data['driver_live_location_long'] = $location_data->driver_live_location_long;
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

                $transactionDetails = DB::table('driver')
                ->leftJoin('driver_transection', 'driver.driver_id', '=', 'driver_transection.driver_transection_by')
                ->where('driver_id','=',$this->driverId)
                ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                    return $query->whereBetween('driver_transection.created_at', [$fromDate, $toDate]);
                }) 
                ->orderBy('driver_transection.driver_transection_id','desc')
                ->paginate(10);

                $driverDetails = DB::table('driver')
                ->where('driver_id',$this->driverId)->first();

                if($this->check_for == 'custom'){
                    return view('livewire.admin.driver-location-component',['isCustom'=>true],compact('transactionDetails','driverDetails','buket_map_data'));
                    }else {
                       return view('livewire.admin.driver-location-component',['isCustom'=>false],compact('transactionDetails','driverDetails','buket_map_data'));
                   }            
            }

        $bookingDetails = DB::table('booking_view')
        ->leftJoin('consumer', 'booking_view.booking_by_cid', '=', 'consumer.consumer_id')
        ->leftJoin('ambulance_category', 'booking_view.booking_category', '=', 'ambulance_category.ambulance_category_type')
        ->where('booking_view.booking_view_category_name', 'like', '%' . $this->search . '%')
        ->leftJoin('driver', 'booking_view.booking_acpt_driver_id', '=', 'driver.driver_id')
        ->orderBy('booking_view.booking_id','desc')
         ->where('booking_acpt_driver_id','=',$this->driverId)
         ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
            return $query->whereBetween('booking_view.created_at', [$fromDate, $toDate]);
        }) 
        ->when($booking_status !== '0', function ($query) use ($booking_status) {
            return $query->where('booking_view.booking_status', $this->booking_status);
        })
         ->paginate(10);

         $driverDetails = DB::table('driver')
         ->where('driver_id',$this->driverId)->first();

         if($this->check_for == 'custom'){
         return view('livewire.admin.driver-details-booking-component',['isCustom'=>true],compact('bookingDetails','driverDetails'));
         }else {
            return view('livewire.admin.driver-details-booking-component',['isCustom'=>false],compact('bookingDetails','driverDetails'));
        }

        }

    
}
