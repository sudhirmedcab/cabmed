<?php

namespace App\Livewire\Admin\Search;
use Illuminate\Support\Facades\DB; 
use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Livewire\WithFileUploads;

class MasterSearchComponent extends Component
{
    public $selectedDate,$filterConditionl, 
    $selectedFromDate,$selectedToDate, $fromDate=null, 
    $toDate=null,$fromdate;

    public $tags=[];

    public $isOpen = 0;
    use WithPagination;
    use WithoutUrlPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    // 
    public $candidateName = '';
    public $search = '';
    public $candidateNumber = '';
    public $vehiclercNumber = '';
    public $sortBy = 'name';
    public $sortDirection = 'asc';

    public function render()
    {        
        $driverData = [];
        $consumerData = [];
        $partnerData = [];
        $HospitalData = [];
        $HospitalUserData = [];
        $VehicleData = [];
        $PathologyData = [];
        $collectionBoyData = [];
        
        if (!empty($this->candidateName)) {
            $driverData = DB::table('driver')
                ->orWhere(DB::raw("concat(driver_name, ' ', driver_last_name)"), 'LIKE', "%" . $this->candidateName . "%")
                ->orderBy('driver_id','desc')
                ->get();
        
            $consumerData = DB::table('consumer')
                ->where('consumer_name', 'like', '%' . $this->candidateName . '%')
                ->orderBy('consumer_id','desc')
                ->get();
        
            $partnerData = DB::table('partner')
                ->orWhere(DB::raw("concat(partner_f_name, ' ', partner_l_name)"), 'LIKE', "%" . $this->candidateName . "%")
                ->orderBy('partner_id','desc')
                ->get();
        
            $HospitalData = DB::table('hospital_lists')
                ->where('hospital_name', 'like', '%' . $this->candidateName . '%')
                ->orderBy('hospital_id','desc')
                ->get();
        
            $HospitalUserData = DB::table('hospital_users')
            ->leftjoin('hospital_lists','hospital_lists.hospital_user_id','=','hospital_users.hospital_users_id')
            ->where('hospital_users_name', 'like', '%' . $this->candidateName . '%')
                ->orderBy('hospital_users_id','desc')
                ->get();

            $collectionBoyData = DB::table('collection_boy')
                ->where('collection_boy_name', 'like', '%' . $this->candidateName . '%')
                ->orderBy('collection_boy_id','desc')
                ->get();

            $PathologyData = DB::table('lab_owner')
                ->where('lab_owner_name', 'like', '%' . $this->candidateName . '%')
                ->orderBy('lab_owner_id','desc')
                ->get();

        } elseif (!empty($this->candidateNumber)) {
            $driverData = DB::table('driver')
                ->orWhere('driver_mobile', 'like', '%' . $this->candidateNumber . '%')
                ->orderBy('driver_id','desc')
                ->get();
        
            $consumerData = DB::table('consumer')
                ->orWhere('consumer_mobile_no', 'like', '%' . $this->candidateNumber . '%')
                ->orderBy('consumer_id','desc')
                ->get();
        
            $partnerData = DB::table('partner')
                ->orWhere('partner_mobile', 'like', '%' . $this->candidateNumber . '%')
                ->orderBy('partner_id','desc')
                ->get();
        
            $HospitalData = DB::table('hospital_lists')
                ->orWhere('hospital_contact_no', 'like', '%' . $this->candidateNumber . '%')
                ->orderBy('hospital_id','desc')
                ->get();
        
            $HospitalUserData = DB::table('hospital_users')
            ->leftjoin('hospital_lists','hospital_lists.hospital_user_id','=','hospital_users.hospital_users_id')
            ->orWhere('hospital_users_mobile', 'like', '%' . $this->candidateNumber . '%')
                ->orderBy('hospital_users_id','desc')
                ->get();

           $collectionBoyData = DB::table('collection_boy')
                ->where('collection_boy_number', 'like', '%' . $this->candidateNumber . '%')
                ->orderBy('collection_boy_id','desc')
                ->get();

            $PathologyData = DB::table('lab_owner')
                ->where('lab_owner_mobile_number', 'like', '%' . $this->candidateNumber . '%')
                ->orderBy('lab_owner_id','desc')
                ->get();
   
        }
     elseif (!empty($this->vehiclercNumber)) {
            $driverData = DB::table('driver')
                ->orWhere('driver_mobile', 'like', '%' . $this->vehiclercNumber . '%')
                ->orderBy('driver_id','desc')
                ->get();
        
            $consumerData = DB::table('consumer')
                ->orWhere('consumer_mobile_no', 'like', '%' . $this->vehiclercNumber . '%')
                ->orderBy('consumer_id','desc')
                ->get();
        
            $partnerData = DB::table('partner')
                ->orWhere('partner_mobile', 'like', '%' . $this->vehiclercNumber . '%')
                ->orderBy('partner_id','desc')
                ->get();
        
            $HospitalData = DB::table('hospital_lists')
                ->orWhere('hospital_contact_no', 'like', '%' . $this->vehiclercNumber . '%')
                ->orderBy('hospital_id','desc')
                ->get();
        
            $HospitalUserData = DB::table('hospital_users')
                ->leftjoin('hospital_lists','hospital_lists.hospital_user_id','=','hospital_users.hospital_users_id')
                ->orWhere('hospital_users_mobile', 'like', '%' . $this->vehiclercNumber . '%')
                ->orderBy('hospital_users_id','desc')
                ->get();

            $VehicleData = DB::table('vehicle')
                 ->leftJoin('ambulance_category', 'ambulance_category.ambulance_category_type', '=', 'vehicle.vehicle_category_type')
                 ->leftJoin('driver', 'driver.driver_assigned_vehicle_id', '=', 'vehicle.vehicle_id')
                ->orWhere('vehicle_rc_number', 'like', '%' . $this->vehiclercNumber . '%')
                ->orderBy('vehicle_id','desc')
                ->get();

             $collectionBoyData = DB::table('collection_boy')
                ->where('collection_boy_number', 'like', '%' . $this->vehiclercNumber . '%')
                ->orderBy('collection_boy_id','desc')
                ->get();

            $PathologyData = DB::table('lab_owner')
                ->where('lab_owner_mobile_number', 'like', '%' . $this->vehiclercNumber . '%')
                ->orderBy('lab_owner_id','desc')
                ->get();
        }
        
        $allData = [
            'driverData' => $driverData,
            'consumerData' => $consumerData,
            'partnerData' => $partnerData,
            'HospitalData' => $HospitalData,
            'HospitalUserData' => $HospitalUserData,
            'VehicleData' => $VehicleData,
            'PathologyData' => $PathologyData,
            'collectionBoyData' => $collectionBoyData
        ];
      
    return view('livewire.admin.search.master-search-component',['allData' => $allData]);

    }


}
