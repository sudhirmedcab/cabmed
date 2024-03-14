<?php

namespace App\Livewire\Admin\Hospital;
use Illuminate\Support\Facades\DB; 
use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class HospitalDetailsComponent extends Component
{
    public $hospitalId,$activeTab,$booking_status,$selectedDate,$filterConditionl, 
    $selectedFromDate,$selectedToDate, $fromDate=null, 
    $toDate=null,$fromdate, $todate,$check_for,$Details;

    protected $paginationTheme = 'bootstrap';
    // 
    public $tags=[];
    public $isOpen = 0;
    public $search;
    public $sortBy = 'name';
    public $sortDirection = 'asc';

    #[Layout('livewire.admin.layouts.base')]

    public function resetFilters(){
        $this->selectedDate=null;
    }

    public function filterCondition($value){

        $this->resetFilters();
        if($value=='hospital_services'){            
            $this->activeTab=$value;
        }
    
        if($value=='map'){
            $this->activeTab=$value;
        }
       
     }
    public function render()
    {        
        $hospitalId = $this->hospitalId;
        $Details = $this->Details ? $this->Details : null;


        try {
            $decrypthospitalId = decrypt($hospitalId);
            } catch (DecryptException $e) {
                abort(403, 'Unauthorized action.');
            }

            if($this->Details =='hospitalService'){

                $hospitalService = DB::table('hospital_available_service')
                ->join('hospital_service_category', 'hospital_available_service.hospital_available_serv_cat_id', '=','hospital_service_category.hospital_serv_cat_id')
                ->when($this->search, fn($query) => $query->where('hospital_service_category.hospital_serv_cat_name', 'like', '%'.$this->search.'%'))
                ->where('hospital_available_service.ha_hospital_id', $decrypthospitalId) 
                ->paginate(10); 
                
                $hospitalData =DB::table('hospital_lists')
                ->join('hospital_users', 'hospital_users.hospital_users_id', '=','hospital_lists.hospital_user_id')
                ->leftjoin('city', 'city.city_id', '=', 'hospital_lists.hospital_city_name')
                ->where('hospital_lists.hospital_id','=',$decrypthospitalId)
                ->first();
            
                return view('livewire.admin.hospital.hospital-details-component',compact('hospitalService','hospitalData'));

            }

            if($this->Details =='mapDetails'){

                $hospitalLocationDetails =DB::table('hospital_lists')
                ->where('hospital_lists.hospital_id','=',$decrypthospitalId)
                ->first();

                $hospitalData =DB::table('hospital_lists')
                ->join('hospital_users', 'hospital_users.hospital_users_id', '=','hospital_lists.hospital_user_id')
                ->leftjoin('city', 'city.city_id', '=', 'hospital_lists.hospital_city_name')
                ->where('hospital_lists.hospital_id','=',$decrypthospitalId)
                ->first();

                return view('livewire.admin.hospital.hospital-details-component',compact('hospitalLocationDetails','hospitalData'));

            }

            $hospitalDetails =DB::table('hospital_lists')
            ->join('hospital_users', 'hospital_users.hospital_users_id', '=','hospital_lists.hospital_user_id')
            ->leftjoin('city', 'city.city_id', '=', 'hospital_lists.hospital_city_name')
            ->where('hospital_lists.hospital_id','=',$decrypthospitalId)
            ->first();

            return view('livewire.admin.hospital.hospital-details-component',compact('hospitalDetails'));
        }

    public function openModal()
    {
        $this->isOpen = true;
    }
    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function editHospitalData(){
        dd("ssssssss");
        $this->openModal();

    }
}
