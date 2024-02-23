<?php

namespace App\Livewire\Admin\Ambulance;
use Illuminate\Support\Facades\DB; 
use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;
use Livewire\WithoutUrlPagination;

class DriverEmergencyComponent extends Component
{
    public $selectedDate,$filterConditionl, 
    $selectedFromDate,$selectedToDate, $fromDate=null, 
    $toDate=null,$fromdate, $todate,$selectedBookingType,$check_for,$selectedbookingStatus,$checkEmergencyStatus,$checkbookingEmergency,
    $activeTab,$events = [];
    
    

    public $isOpen = 0;
    use WithPagination;
    use WithFileUploads;
    use WithoutUrlPagination;


    protected $paginationTheme = 'bootstrap';
    // 
    public $search = '';
    public $sortBy = 'name';
    public $sortDirection = 'asc';
    public $partner_filter = '';
 
    #[Layout('livewire.admin.layouts.base')]    //......... add the layout dynamically for the all ...........//
    

    public function resetFilters(){
          
        $this->consumer_status=null;
        $this->selectedDate=null;
        $this->search = '';
        $this->selectedFromDate = '';
        $this->selectedToDate = '';

    }

    public function filterCondition($value){
        $this->resetFilters();

            if($value=='All'){            
            $this->activeTab=$value;
        }
    
        elseif($value=='ConsumerEmergency'){
            $this->activeTab=$value;
        }
        elseif($value=='DriverEmergency'){
            $this->activeTab=$value;
        }
        elseif($value=='airAmbulance'){
            $this->activeTab=$value;
        }elseif($value=='driverAutosearch'){
            $this->activeTab=$value;
        }elseif($value=='') {
            
        }
       
  
}
    public function render()
    {
        // $fromDate = $this->selectedFromDate ? Carbon::createFromFormat('Y-m-d', $this->selectedFromDate)->startOfDay() : null;
        // $toDate = $this->selectedToDate ? Carbon::createFromFormat('Y-m-d', $this->selectedToDate)->endOfDay() : null;
        
        // if($this->selectedDate == 'custom'){
        //     $this->selectedFromDate;
        //     $this->selectedToDate;
        // }else{
        //     $this->selectedFromDate ='';
        //     $this->selectedToDate =''; 
        // }
     
        // switch ($this->selectedDate) {
        //     case 'all':
        //         $fromDate = null;
        //         $toDate = null;
        //         break;
        //     case 'today':
        //         $fromDate = Carbon::today();
        //         $toDate = Carbon::today()->endOfDay();
        //         break;
        //     case 'yesterday':
        //         $fromDate = Carbon::yesterday();
        //         $toDate = Carbon::yesterday()->endOfDay();
        //         break;
        //     case 'thisWeek':
        //         $fromDate = Carbon::now()->subDays(7)->startOfDay();
        //         $toDate = Carbon::now();
        //         break;
        //     case 'thisMonth':
        //         $fromDate = Carbon::now()->startOfMonth();
        //         $toDate = Carbon::now()->endOfMonth();
        //         break;
        //     default:
        //         $fromDate = $fromDate;
        //         $toDate = $toDate;
        //         break;
        // }

        // $driver_list = DB::table('driver_emergency')
        // ->leftjoin('driver', 'driver_emergency.driver_emergency_driver_id', '=', 'driver.driver_id')
        // ->where(function ($query) {
        //     $query->where('driver.driver_name', 'like', '%' . $this->search . '%')
        //         ->orWhere('driver.driver_mobile', 'like', '%' . $this->search . '%');
        // })
        // ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
        //     return $query->whereBetween('driver_emergency.created_at', [$fromDate, $toDate]);
        // }) 
        // ->orderByDesc('driver_emergency.driver_emergency_id')
        // ->paginate(10);

        // // dd($driver_list);
        // $buket_map_data = [];

        // foreach($driver_list as $location_data){
        //     $add_data['driver_emergency_driver_lat'] = $location_data->driver_emergency_driver_lat;
        //     $add_data['driver_emergency_driver_long'] = $location_data->driver_emergency_driver_long;
        //     $add_data['driver_name'] = $location_data->driver_name;
        //     $add_data['driver_last_name'] = $location_data->driver_last_name;
        //     $add_data['driver_mobile'] = $location_data->driver_mobile;
        //     $unix_time = $location_data->driver_emergency_request_timing; 

        //     $carbonDateTime = Carbon::createFromTimestamp($unix_time);
        //     $normalDateTime = $carbonDateTime->toDateTimeString();
        //     // $data = $convertedDates;
        //     $currentDateTime = Carbon::now();  
        //     $carbonDate = Carbon::parse($normalDateTime);
        //     $hoursDifference = $carbonDate->diffInHours($currentDateTime);
        //     $daysDifference = $carbonDate->diffInDays($currentDateTime);
        //     // Format the date difference as a human-readable message
        //     $add_data['time_diffrence'] =  $carbonDate->diffForHumans();

        //     array_push($buket_map_data, $add_data);
        // }

        // $locations = [
        //     ['Mumbai', 19.0760,72.8777],
        //     ['Pune', 18.5204,73.8567],
        //     ['Bhopal ', 23.2599,77.4126],
        //     ['Agra', 27.1767,78.0081],
        //     ['Delhi', 28.7041,77.1025],
        //     ['Rajkot', 22.2734719,70.7512559],
        // ];

        // if($this->check_for == 'custom'){
        //     return view('livewire.admin.ambulance.driver-emergency-component',[
        //         'isCustom' => true
        //     ],compact('buket_map_data', 'driver_list'));
        // }

        return view('livewire.admin.ambulance.driver-emergency-component');

    }
}
