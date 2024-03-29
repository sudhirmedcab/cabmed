<?php

namespace App\Livewire\Admin\Hospital;
use Illuminate\Support\Facades\DB; 
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class HospitalListComponent extends Component
{
    public $selectedDate,$filterConditionl, 
    $selectedFromDate,$selectedToDate, $fromDate=null, 
    $toDate=null,$fromdate, $todate,$check_for,$HospitalStatusFilter,$cityId,$StateId,$remarkText,$hospitalId,$HospitalId,
    $activeTab,$hospital_id,$hospital_name,$hospital_address,$hospital_city_name,$hospital_lat,$hospital_long,$hospital_pincode,$hospital_users_id,$hospital_users_name,$hospital_users_mobile,$hospital_users_email,$hospital_users_password,$hospital_users_aadhar_no,$verify_by,$citydata,$hospital_verify_status;

    public $isOpen = 0;
    use WithPagination;
    use WithoutUrlPagination;
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
  
      $cities = DB::table('hospital_lists')
          ->leftJoin('city', 'city.city_id', '=', 'hospital_lists.hospital_city_name')
          ->select('hospital_lists.hospital_city_name', 'city.city_name', DB::raw('count(*) as total_hospital'))
          ->whereNot('city.city_id',0)
          ->groupBy('hospital_lists.hospital_city_name', 'city.city_name')
          ->get();
  
          if($this->check_for == 'custom'){
            return view('livewire.admin.hospital.hospital-list-component',['isCustom'=>true],compact('hospital_list','cities','buckethlist'));
            }else {
               return view('livewire.admin.hospital.hospital-list-component',['isCustom'=>false],compact('hospital_list','cities','buckethlist'));
           } 
  }

  public function openModal()
  {
      $this->isOpen = true;
  }
  public function closeModal()
  {
      $this->isOpen = false;
  }

  public function editHospitalData($hospitalId){

    $hospitalData = DB::table('hospital_lists')->where('hospital_id',$hospitalId)
    ->leftjoin('city','city.city_id','=','hospital_lists.hospital_city_name')
    ->first();

    $this->citydata = DB::table('city')->get();

    $this->hospital_id = $hospitalData->hospital_id;
    $this->hospital_name = $hospitalData->hospital_name;
    $this->hospital_address = $hospitalData->hospital_address;
    $this->hospital_city_name = $hospitalData->city_id;
    $this->hospital_lat = $hospitalData->hospital_lat;
    $this->hospital_long = $hospitalData->hospital_long;
    $this->hospital_pincode = $hospitalData->hospital_pincode;
    $this->verify_by = $hospitalData->verify_by;
    $this->hospital_verify_status = $hospitalData->hospital_verify_status;


    $this->openModal();
}
  public function editHospitalOwnerData($hospitalUserId){

    $hospitalData = DB::table('hospital_users')->where('hospital_users_id',$hospitalUserId)
    ->first();

    $this->hospital_users_id  = $hospitalData->hospital_users_id;
    $this->hospital_users_name = $hospitalData->hospital_users_name;
    $this->hospital_users_mobile = $hospitalData->hospital_users_mobile;
    $this->hospital_users_email = $hospitalData->hospital_users_email;
    $this->hospital_users_password = $hospitalData->hospital_users_password;
    $this->hospital_users_password = $hospitalData->hospital_users_password;

    $this->openModal();
}
  
public function UpdateHospitalData(){

    $validatedData = $this->validate([
        'hospital_name' => 'required',
        'hospital_address' => 'required',
        'hospital_city_name' => 'required',
        'hospital_pincode' => 'required',
        'verify_by' => 'required', // Corrected typo here
        'hospital_lat' => 'required', // Corrected typo here
        'hospital_long' => 'required', // Corrected typo here
        'hospital_verify_status' => 'required', // Corrected typo here
    ], [
        'hospital_name.required' => 'Please Add The Hospital Name',
        'hospital_address.required' => 'Please Add The Hospital Address',
        'hospital_city_name.required' => 'Please Add The Hospital City ', // Corrected message
        'hospital_pincode.required' => 'Please Add The Hospital Pincode',
        'hospital_verify_status.required' => 'Please Add The Hospital Verification Status',
        'hospital_lat.required' => 'Please Add The Hospital Lattitude', // Corrected typo here
        'hospital_long.required' => 'Please Add The Hospital Longitude', // Corrected typo here
    ]);
    
    try {
        DB::beginTransaction();

        $LoggeduserId = "1";
        
        $data = [
            'hospital_name' => $this->hospital_name,
            'hospital_address' => $this->hospital_address,
            'hospital_city_name' => $this->hospital_city_name,
            'hospital_pincode' => $this->hospital_pincode,
            'hospital_verify_status' => $this->hospital_verify_status, // Corrected typo here
            'hospital_lat' => $this->hospital_lat,
            'hospital_long' => $this->hospital_long,
            'verify_by'=>$LoggeduserId,
            'verify_date'=>now()->timestamp
        ];
    
        if ($this->hospital_id) {
            
            DB::table('hospital_lists')->where('hospital_id', $this->hospital_id)->update($data);
            session()->flash('activeMessage', 'Hospital updated successfully !!' . $this->hospital_id);
        } 
    
        DB::commit();
    } catch (\Exception $e) {
        session()->flash('inactiveMessage', 'Something went wrong : ' . $e->getMessage());
        DB::rollback();
        \Log::error('Error occurred while processing Hospital Update operation: ' . $e->getMessage());
    }
    
}

public function updateHospitalOwner(){
    $validatedData = $this->validate([
        'hospital_users_name' => 'required',
        'hospital_users_mobile' => 'required',
        'hospital_users_email' => 'required',
        'hospital_users_password' => 'required',
        'hospital_users_aadhar_no' => 'required', // Corrected typo here
    ], [
        'hospital_users_name.required' => 'Please Add The Hospital Owner Name',
        'hospital_users_mobile.required' => 'Please Add The Hospital Mobile',
        'hospital_users_email.required' => 'Please Add The Hospital Email ', // Corrected message
        'hospital_users_password.required' => 'Please Add The Hospital Password',
        'hospital_users_aadhar_no.required' => 'Please Add The Hospital Verification Status',
    ]);
    
    try {
        DB::beginTransaction();

        $LoggeduserId = "1";
        
        $data = [
            'hospital_users_name' => $this->hospital_users_name,
            'hospital_users_mobile' => $this->hospital_users_mobile,
            'hospital_users_email' => $this->hospital_users_email,
            'hospital_users_password' => $this->hospital_users_password,
            'hospital_users_aadhar_no' => $this->hospital_users_aadhar_no
        ];
    
        if ($this->hospital_users_id) {
            
            DB::table('hospital_users')->where('hospital_users_id', $this->hospital_users_id)->update($data);
            session()->flash('activeMessage', 'Hospital Owner updated successfully !!' . $this->hospital_users_id);
        } 
    
        DB::commit();
    } catch (\Exception $e) {
        session()->flash('inactiveMessage', 'Something went wrong : ' . $e->getMessage());
        DB::rollback();
        \Log::error('Error occurred while processing Hospital Update operation: ' . $e->getMessage());
    }
}
  
}
