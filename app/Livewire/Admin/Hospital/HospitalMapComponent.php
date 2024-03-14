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
        
        $HospitalStatusFilter = $this->HospitalStatusFilter ? $this->HospitalStatusFilter : null;
        $cityId = $this->cityId ? $this->cityId : null;    

        $fromDate = $this->selectedFromDate ? strtotime($this->selectedFromDate) : null;
        $toDate = $this->selectedToDate ?  strtotime($this->selectedToDate) : null;

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
                    $fromDate = strtotime(date('Y-m-d'));
                    $toDate = strtotime(date('Y-m-d').' 23:59:59');
                    break;
                case 'yesterday':
                    $fromDate = strtotime('-1 day', strtotime(date('Y-m-d')));
                    $toDate = strtotime('-1 day', strtotime(date('Y-m-d').' 23:59:59'));
                    break;
                case 'thisWeek':
                    $fromDate = strtotime('-7 days', strtotime(date('Y-m-d')));
                    $toDate = strtotime(date('Y-m-d').' 23:59:59');
                    break;
                case 'thisMonth':
                    $fromDate = strtotime(date('Y-m-01'));
                    $toDate = strtotime(date('Y-m-t').' 23:59:59');
                    break;
                default:
                    $fromDate = $fromDate;
                    $toDate = $toDate;
                    break;
            }

            if($this->activeTab =='HospitalOwner'){

                $hospital_user = DB::table('hospital_users')
                ->join('hospital_lists', 'hospital_lists.hospital_user_id', '=','hospital_users.hospital_users_id')
                ->leftjoin('tele_callers', 'hospital_users.hospital_users_referral_code', '=', 'tele_callers.tele_caller_referral_code')
                ->leftjoin('city', 'city.city_id', '=', 'hospital_lists.hospital_city_name')
                ->where(function ($query) {
                    $query->where('hospital_users.hospital_users_name', 'like', '%' . $this->search . '%')
                        ->orWhere('hospital_lists.hospital_name', 'like', '%' . $this->search . '%');
                })  
                ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                    return $query->whereBetween('hospital_users.hospital_users_reg_time_unix', [$fromDate, $toDate]);
                })
                ->when($HospitalStatusFilter == 'All', function ($query) use ($HospitalStatusFilter){
                    return $query->whereIn('hospital_lists.hospital_status',[1,0]);
                        })
               ->when($HospitalStatusFilter == 'Verified', function ($query) use ($HospitalStatusFilter){
                    return $query->where('hospital_lists.hospital_verify_status',1);
                        })
              ->when($HospitalStatusFilter == 'Unverified', function ($query) use ($HospitalStatusFilter){
                   return $query->where('hospital_lists.hospital_verify_status',0);
                         })
                ->when($HospitalStatusFilter == 'New', function ($query) use ($HospitalStatusFilter){
                          return $query->where('hospital_lists.hospital_status',0);
                       })
                ->orderBy('hospital_users.hospital_users_id','desc')
                ->paginate(10);

                if($this->check_for == 'custom'){
                    return view('livewire.admin.hospital.hospital-list-component',['isCustom'=>true],compact('hospital_user'));
                    }else {
                       return view('livewire.admin.hospital.hospital-list-component',['isCustom'=>false],compact('hospital_user'));
                   } 

            }

            if($this->activeTab == 'districtWise'){
                
                $StateId = $this->StateId ? $this->StateId : null;    

                $hospitalData = DB::table('district_list')
                ->leftJoin('city', 'city.city_district', '=', 'district_list.district_id')
                ->leftJoin('hospital_lists', 'hospital_lists.hospital_city_name', '=', 'city.city_id')
                ->leftJoin('division', 'division.division_id', '=', 'city.city_division')
                ->leftJoin('state', 'state.state_id', '=', 'division.division_state_id')
                ->where('state.state_id', $StateId)
                ->where(function ($query) {
                    $query->where('district_list.district_name', 'like', '%' . $this->search . '%')
                        ->orWhere('state.state_name', 'like', '%' . $this->search . '%');
                })  
                ->selectRaw('state.state_name, district_list.district_name, COALESCE(COUNT(hospital_lists.hospital_id), 0) as hospital_count')
                ->groupBy('state.state_name', 'district_list.district_name')
                ->orderBy('state.state_name', 'asc')
                ->orderBy('district_list.district_name', 'asc')
                ->paginate(10);        
            // $sumHospitalCountsByDivision = $hospital_data->sum('hospital_count');
         
            $stateData = DB::table('state')
            ->leftJoin('district_list', 'state.state_id', '=', 'district_list.d_state_id')
            ->leftJoin('city', 'district_list.district_id', '=', 'city.city_district')
            ->leftJoin('hospital_lists as drv', 'city.city_id', '=', 'drv.hospital_city_name')
            ->selectRaw('state.state_id,
                         state.state_name, 
                         COUNT(DISTINCT district_list.district_id) as district_count,
                         COUNT(DISTINCT drv.hospital_id) as total_hospital_count')
            ->groupBy('state.state_id', 'state.state_name')
            ->get();

            return view('livewire.admin.hospital.hospital-list-component',compact('stateData','hospitalData'));

            }

            if($this->activeTab == 'divisionWise'){
                
                $StateId = $this->StateId ? $this->StateId : null;    

                $hospitalData = DB::table('division')
                ->leftJoin('city', 'city.city_division', '=', 'division.division_id')
                ->leftJoin('hospital_lists', 'hospital_lists.hospital_city_name', '=', 'city.city_id')
                ->leftJoin('state', 'state.state_id', '=', 'division.division_state_id')
                ->where('state.state_id', $StateId)
                ->selectRaw('state.state_name, division.division_name, COALESCE(COUNT(hospital_lists.hospital_id), 0) as hospital_count')
                ->where(function ($query) {
                    $query->where('division.division_name', 'like', '%' . $this->search . '%')
                        ->orWhere('state.state_name', 'like', '%' . $this->search . '%');
                })  
                ->groupBy('state.state_name', 'division.division_name')
                ->orderBy('state.state_name', 'asc')
                ->orderBy('division.division_name', 'asc')
                ->paginate(10);        
         
            $stateData = DB::table('state')
                ->leftJoin('division', 'state.state_id', '=', 'division.division_state_id')
                ->leftJoin('city', 'division.division_id', '=', 'city.city_division')
                ->leftJoin('hospital_lists as drv', 'city.city_id', '=', 'drv.hospital_city_name')
                ->selectRaw('state.state_id,
                            state.state_name, 
                            COUNT(DISTINCT division.division_id) as division_count,
                            COUNT(DISTINCT drv.hospital_id) as total_driver_count')
                ->groupBy('state.state_id', 'state.state_name')
                ->get();

            return view('livewire.admin.hospital.hospital-count-list-component',compact('stateData','hospitalData'));

            }

            if($this->activeTab == 'cityWise'){
                
                $StateId = $this->StateId ? $this->StateId : null;    

                $hospitalData = DB::table('city')
                ->leftJoin('hospital_lists', 'hospital_lists.hospital_city_name', '=', 'city.city_id')
                ->leftJoin('state', 'state.state_id', '=', 'city.city_state')
                ->where('state.state_id', $StateId)
                ->selectRaw('state.state_name, city.city_name, COALESCE(COUNT(hospital_lists.hospital_id), 0) as hospital_count')
                ->where(function ($query) {
                    $query->where('city.city_name', 'like', '%' . $this->search . '%')
                        ->orWhere('state.state_name', 'like', '%' . $this->search . '%');
                })  
                ->groupBy('state.state_name', 'city.city_name')
                ->orderBy('state.state_name', 'asc')
                ->orderBy('city.city_name', 'asc')
                ->paginate(10);        
         
            $stateData = DB::table('state')
                ->leftJoin('city', 'city.city_state', '=', 'state.state_id')
                ->leftJoin('hospital_lists as drv', 'city.city_id', '=', 'drv.hospital_city_name')
                ->selectRaw('state.state_id,
                            state.state_name, 
                            COUNT(DISTINCT city.city_id) as city_count,
                            COUNT(DISTINCT drv.hospital_id) as total_hospital_count')
                ->groupBy('state.state_id', 'state.state_name')
                ->get();

            return view('livewire.admin.hospital.hospital-count-list-component',compact('stateData','hospitalData'));

            }

           

      $hospital_list = DB::table('hospital_lists')
          ->leftjoin('hospital_users', 'hospital_users.hospital_users_id', '=', 'hospital_lists.hospital_user_id')
          ->leftjoin('tele_callers', 'hospital_users.hospital_users_referral_code', '=', 'tele_callers.tele_caller_referral_code')
          ->leftjoin('city', 'city.city_id', '=', 'hospital_lists.hospital_city_name')
          ->where(function ($query) {
            $query->where('hospital_users.hospital_users_name', 'like', '%' . $this->search . '%')
                ->orWhere('hospital_lists.hospital_name', 'like', '%' . $this->search . '%');
        })  
          ->leftJoin('remark_data', 'hospital_lists.hospital_id', '=', 'remark_data.remark_hospital_id')
          ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
            return $query->whereBetween('hospital_lists.hospital_added_timestamp', [$fromDate, $toDate]);
        })
         ->when($cityId !==null, function ($query) use ($cityId){
          return $query->where('hospital_lists.hospital_city_name',$cityId);
         })
      ->when($HospitalStatusFilter == 'All', function ($query) use ($HospitalStatusFilter){
               return $query->whereIn('hospital_lists.hospital_status',[1,0]);
                   })
      ->when($HospitalStatusFilter == 'Verified', function ($query) use ($HospitalStatusFilter){
               return $query->where('hospital_lists.hospital_verify_status',1);
                   })
       ->when($HospitalStatusFilter == 'Unverified', function ($query) use ($HospitalStatusFilter){
              return $query->where('hospital_lists.hospital_verify_status',0);
                    })
           ->when($HospitalStatusFilter == 'New', function ($query) use ($HospitalStatusFilter){
                     return $query->where('hospital_lists.hospital_status',0);
                  })
          ->orderBy('hospital_lists.hospital_id', 'desc')
          ->paginate(10); // Paginate the results with 10 items per page
          
      $buckethlist = [];

      foreach ($hospital_list as $hkey) {
           $hospital_id  = $hkey->hospital_id; 
       
          $hospital_service_count = DB::table('hospital_available_service')
              ->where('ha_hospital_id', $hospital_id)->count();
          $buckethlist[$hospital_id] = $hospital_service_count;
  
      }
        
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
