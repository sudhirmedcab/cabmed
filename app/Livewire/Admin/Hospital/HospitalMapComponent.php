<?php

namespace App\Livewire\Admin\Hospital;
use Illuminate\Support\Facades\DB; 
use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithPagination;

class HospitalMapComponent extends Component
{
    public $selectedDate,$filterConditionl, 
    $selectedFromDate,$selectedToDate, $fromDate=null, 
    $toDate=null,$fromdate, $todate,$check_for,$HospitalStatusFilter,$cityId,$StateId,$remarkText,$hospitalId,$HospitalId,
    $activeTab;

    public $isOpen = 0;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    // 
    public $search = '';
    public $sortBy = 'name';
    public $sortDirection = 'asc';

    public function resetFilters(){

        $this->selectedDate=null;
        $this->search ='';
        $this->StateId =null;
        $this->cityId =null;

           }

    public function filterCondition($value){
        $this->resetFilters();

        if($value=='districtWise'){
            $this->activeTab=$value;
        }
        if($value=='cityWise'){
            $this->activeTab=$value;
        }
        if($value=='divisionWise'){
            $this->activeTab=$value;
        }
      
        if($value=='HospitalOwner'){
            $this->activeTab=$value;
        }
        if($value=='hospitalMap'){
            $this->activeTab=$value;
        }
       
  }

    public function render()
    {
        
        $HospitalId = $this->HospitalId ? $this->HospitalId : null;    
        
        $hospitalDetails = DB::table('hospital_lists')
        ->where(function ($query) {
            $query->where('hospital_lists.hospital_name', 'like', '%' . $this->search . '%');
        })      
         ->get();


         $buket_map_data = [];
      
     foreach($hospitalDetails as $location_data){
         $add_data['hospital_lat'] = $location_data->hospital_lat;
         $add_data['hospital_long'] = $location_data->hospital_long;
         $add_data['hospital_name'] = $location_data->hospital_name;
         $add_data['hospital_address'] = $location_data->hospital_address;
         $unix_time = $location_data->hospital_added_timestamp; 
 
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
 
     $hospitalData = DB::table('hospital_lists')
                ->get();

    return view('livewire.admin.hospital.hospital-map-component',compact('hospitalData','buket_map_data'));
    }


}
