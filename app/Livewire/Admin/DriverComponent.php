<?php

namespace App\Livewire\Admin;
use Illuminate\Support\Facades\DB; 
use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithPagination;

class DriverComponent extends Component
{
    public $employees0,$selectedDate,$filterConditionl, 
    $selectedFromDate,$selectedToDate, $fromDate=null, 
    $toDate=null,$fromdate, $todate, $id, $name, $email, $state=[],
    $position, $employee_id, $driver_status=null, $driver_duty_status=null,$division_state_id=null,
    $driverUnderVerBySelf=null,
    $driverUnderVerByPartner=null,
    $activeTab,
    $division,
    $division_state,
    $district_state,
    $walletBalanceFilter,
    $selectDocumentExpiry,
    $driverVerificationStatus = null,
    $sumDriverCountsByDivision;
    public $isOpen = 0;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    // 
    public $search = '';
    public $sortBy = 'name';
    public $sortDirection = 'asc';
     public $age = '30';
    public $address = 'Lucknow';
    public function mount()
    {
        $driverVerificationStatus = $this->driverVerificationStatus ? $this->driverVerificationStatus : null;
        $selectDocumentExpiry = $this->selectDocumentExpiry ? $this->selectDocumentExpiry : null;
        
        $this->state = $this->stateList();
        
    }

    public function activeDriver($value){
    //    dd('ddfdfdf',$value);
    if($value=='Active'){
        // $this->activeDriver = 1;
        $this->activeTab=$value;
        $this->driver_status=1;
    }
    if($value=='Onduty'){
        // $this->activeDriver = 1;
    $this->driver_status=null;
    $this->driver_duty_status='ON';

    $this->activeTab=$value;
    }
    if($value=='Offduty'){
    // $this->activeDriver = 1;
    $this->driver_status=null;
    $this->driver_duty_status='OFF';
    $this->activeTab=$value;
    }

    }
            public function resetFilters(){
                $this->driver_duty_status=null;
                $this->driverUnderVerBySelf=null;
                $this->driverUnderVerByPartner=null;
                $this->driverVerificationStatus=null;
                $this->driver_status=null;
                $this->driver_duty_status=null;
                $this->selectedDate=null;
            }
            public function filterCondition($value){
                $this->resetFilters();
                     if($value=='Active'){
                // $this->activeDriver = 1;
                $this->driver_duty_status=null;
                $this->driverUnderVerBySelf=null;
                $this->driverUnderVerByPartner=null;
                $this->activeTab=$value;
                $this->driver_status=1;
            }
        
            if($value=='Onduty'){
                // $this->activeDriver = 1;
                $this->driver_status=null;
                $this->driverUnderVerBySelf=null;
                $this->driverUnderVerByPartner=null;
                $this->driver_duty_status='ON';
                $this->activeTab=$value;
            }
            if($value=='Offduty'){
                // $this->activeDriver = 1;
                $this->driver_status=null;
                $this->driverUnderVerBySelf=null;
                $this->driverUnderVerByPartner=null;
                $this->driver_duty_status='OFF';
                $this->activeTab=$value;
            }
            if($value=='UnderVerificationBySelf'){
                $this->driver_status=null;
                $this->driver_duty_status=null;
                $this->driverUnderVerByPartner=null;
                $this->driverUnderVerBySelf='yes';
                $this->activeTab=$value;
            }
            if($value=='UnderVerificationByPartner'){
                $this->driver_status=null;
                $this->driver_duty_status=null;
                $this->driverUnderVerBySelf=null;
                $this->activeTab=$value;
                $this->driverUnderVerByPartner='yes';
            }
            if($value=='walletBalance'){
                // $this->activeDriver = 1;
                $this->driver_duty_status=null;
                $this->driverUnderVerBySelf=null;
                $this->driverUnderVerByPartner=null;
                $this->activeTab=$value;
                $this->driver_status=null;
            }
            if($value=='division'){
                // $this->activeDriver = 1;
                $this->driver_duty_status=null;
                $this->driverUnderVerBySelf=null;
                $this->driverUnderVerByPartner=null;
                $this->activeTab=$value;
                $this->driver_status=null;
                $this->division_state=null;
                $this->search='';
            }
            if($value=='district'){
                // $this->activeDriver = 1;
                $this->driver_duty_status=null;
                $this->driverUnderVerBySelf=null;
                $this->driverUnderVerByPartner=null;
                $this->activeTab=$value;
                $this->driver_status=null;
            }
            if($value=='documentExpiry'){
                $this->activeTab=$value;
            }
        }
 
    public function render()
    {
// dd($this->activeTab);
        $division = $this->division ? $this->division : null;
        if($this->activeTab=='division'){
        // $division_state_id = $this->division_state ? $this->division_state : 27;
        $division_state_id = ($this->division_state || $this->division_state == 0) ? $this->division_state : 27;
        // dd('sdfghj',$division_state_id);

             $state = DB::table('state')
            ->leftJoin('division', 'state.state_id', '=', 'division.division_state_id')
            ->leftJoin('city', 'division.division_id', '=', 'city.city_division')
            ->leftJoin('driver as drv', 'city.city_id', '=', 'drv.driver_city_id')
            ->selectRaw('state.state_id,
                        state.state_name,
                        COUNT(DISTINCT division.division_id) as division_count,
                        COUNT(DISTINCT drv.driver_id) as total_driver_count')
            ->groupBy('state.state_id', 'state.state_name')
            ->get();
            $total_driver =  DB::table('driver')->get();  
            
        // ........
            // $stateName = 27;

         
            $results = DB::table('division')
            ->leftJoin('city', 'city.city_division', '=', 'division.division_id')
            ->leftJoin('driver', 'driver.driver_city_id', '=', 'city.city_id')
            ->leftJoin('state', 'state.state_id', '=', 'division.division_state_id')
            ->when($division_state_id !== null, function ($query) use ($division_state_id) {
                return $query->where('state.state_id', $division_state_id);
            })
            ->where('division.division_name', 'like', '%' . $this->search . '%')
            ->selectRaw('state.state_name, division.division_name, 
                        COALESCE(COUNT(driver.driver_id), 0) as total_driver_count,
                        SUM(CASE WHEN driver.driver_duty_status = "ON" THEN 1 ELSE 0 END) as on_duty_count,
                        SUM(CASE WHEN driver.driver_duty_status = "OFF" THEN 1 ELSE 0 END) as off_duty_count')
            ->groupBy('state.state_name', 'division.division_name')
            ->paginate(10);
            $sumDriverCountsByDivision = $results->sum('total_driver_count');
            $state = DB::table('state')
            ->leftJoin('division', 'state.state_id', '=', 'division.division_state_id')
            ->leftJoin('city', 'division.division_id', '=', 'city.city_division')
            ->leftJoin('driver as drv', 'city.city_id', '=', 'drv.driver_city_id')
            ->selectRaw('state.state_id,
                        state.state_name, 
                        COUNT(DISTINCT division.division_id) as division_count,
                        COUNT(DISTINCT drv.driver_id) as total_driver_count')
            ->groupBy('state.state_id', 'state.state_name')
            ->get();
     
             $total_driver =  DB::table('driver')->get();   
        // ........
        return view('livewire.admin.driver-division-component',['results' => $results, 'total_driver'=>$total_driver,'state'=>$state,'sumDriverCountsByDivision'=>$sumDriverCountsByDivision])->layout('livewire.admin.layouts.base');

        }

        if($this->activeTab=='district'){

            // $stateName = $request->input('state_id');
            $district_state_id = ($this->district_state || $this->district_state == 0) ? $this->district_state : 27;
            $results = DB::table('district_list')
            ->leftJoin('city', 'city.city_district', '=', 'district_list.district_id')
            ->leftJoin('driver', 'driver.driver_city_id', '=', 'city.city_id')
            ->leftJoin('state', 'state.state_id', '=', 'district_list.d_state_id')
             ->when($district_state_id !== null, function ($query) use ($district_state_id) {
                return $query->where('state.state_id', $district_state_id);
            })
            ->where('district_list.district_name', 'like', '%' . $this->search . '%')
            ->selectRaw('state.state_name, district_list.district_name, 
                        COALESCE(COUNT(driver.driver_id), 0) as total_driver_count,
                        SUM(CASE WHEN driver.driver_duty_status = "ON" THEN 1 ELSE 0 END) as on_duty_count,
                        SUM(CASE WHEN driver.driver_duty_status = "OFF" THEN 1 ELSE 0 END) as off_duty_count')
            ->groupBy('state.state_name', 'district_list.district_name')
            ->orderBy('state.state_name', 'asc')
            ->orderBy('district_list.district_name', 'asc')
            ->paginate(10);

            $sumDriverCountsByDistrict = $results->sum('total_driver_count');
            $state = DB::table('state')
            ->leftJoin('district_list', 'state.state_id', '=', 'district_list.d_state_id')
            ->leftJoin('city', 'district_list.district_id', '=', 'city.city_district')
            ->leftJoin('driver as drv', 'city.city_id', '=', 'drv.driver_city_id')
            ->selectRaw('state.state_id,
                         state.state_name, 
                         COUNT(DISTINCT district_list.district_id) as district_count,
                         COUNT(DISTINCT drv.driver_id) as total_driver_count')
            ->groupBy('state.state_id', 'state.state_name')
            ->get();
            $total_driver =  DB::table('driver')->get();   

        return view('livewire.admin.driver-district-component',['results' => $results, 'total_driver'=>$total_driver,'state'=>$state,'sumDriverCountsByDistrict'=>$sumDriverCountsByDistrict])->layout('livewire.admin.layouts.base');

        }
        $currentTimestamps = Carbon::now();
        $firstDayOfMonths = Carbon::now()->startOfMonth(); 
    //    dd($this->selectedDate);
        // ...
        // dd($this->driver_status);
        // dd($this->driverVerificationStatus);
        $driver_status = $this->driver_status ? $this->driver_status : null;
        $driver_duty_status = $this->driver_duty_status ? $this->driver_duty_status : null;
        $driverUnderVerByPartner = $this->driverUnderVerByPartner ? $this->driverUnderVerByPartner : null;
        $driverUnderVerBySelf = $this->driverUnderVerBySelf ? $this->driverUnderVerBySelf : null;
        $driverVerificationStatus = $this->driverVerificationStatus ? $this->driverVerificationStatus : null;
        $walletBalanceFilter = $this->walletBalanceFilter ? $this->walletBalanceFilter : null;
        $selectDocumentExpiry = $this->selectDocumentExpiry ? $this->selectDocumentExpiry : null;
        
        // dd($driver_status,$driver_duty_status);
        $fromDate = $this->selectedFromDate ? Carbon::createFromFormat('Y-m-d', $this->selectedFromDate)->startOfDay() : null;
        $toDate = $this->selectedToDate ? Carbon::createFromFormat('Y-m-d', $this->selectedToDate)->endOfDay() : null;
        if($this->selectedFromDate && $this->selectedToDate){
            $this->selectedDate = null;     
        }
        if($this->selectedDate){
            $this->selectedFromDate ='';
            $this->selectedToDate ='';
        }
       
        switch ($this->driverVerificationStatus) {
            case 'UnderVerification':
                $fromDate = null;
                $toDate = null;
                break;
            case 'UnderVerificationBySelf':
                $this->driver_status=null;
                $this->driver_duty_status=null;
                $this->driverUnderVerByPartner=null;
                $this->driverUnderVerBySelf='yes';
                break;
            case 'UnderVerificationByPartner':
                $this->driver_status=null;
                $this->driver_duty_status=null;
                $this->driverUnderVerBySelf=null;
                $this->driverUnderVerByPartner='yes';
                break;
            default:
                break;
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
       
        // ...





        $drivers = DB::table('driver')
        ->leftJoin('driver_details', 'driver.driver_id', '=', 'driver_details.driver_details_driver_id')
        ->leftJoin('vehicle', 'driver.driver_assigned_vehicle_id', '=', 'vehicle.vehicle_id')
        ->leftJoin('city', 'driver.driver_city_id', '=', 'city.city_id')
        ->leftJoin('partner', 'driver.driver_created_partner_id', '=', 'partner.partner_id')
        ->leftJoin('state', 'state.state_id', '=', 'city.city_state')
        ->leftJoin('ambulance_category', 'ambulance_category.ambulance_category_type', '=', 'vehicle.vehicle_category_type')
        ->leftJoin('remark_data', 'driver.driver_id', '=', 'remark_data.remark_driver_id')
        ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
            return $query->whereBetween('driver.created_at', [$fromDate, $toDate]);
        })
        ->when($driver_status !== null, function ($query) use ($driver_status) {
            return $query->where('driver.driver_status', $driver_status);
        })
        ->when($driver_duty_status !== null, function ($query) use ($driver_duty_status) {
            return $query->where('driver.driver_duty_status', $driver_duty_status);
        })
        ->when($walletBalanceFilter !==null && $walletBalanceFilter == 'zeroBalance', function ($query) use ($walletBalanceFilter){
            return $query->where('driver.driver_wallet_amount',0);
        })
        ->when($walletBalanceFilter !==null && $walletBalanceFilter == 'negativeBalance', function ($query) use ($walletBalanceFilter){
            return $query->where('driver.driver_wallet_amount','<',0);
        })
        ->when($walletBalanceFilter !==null && $walletBalanceFilter == 'positiveBalance', function ($query) use ($walletBalanceFilter){
            return $query->where('driver.driver_wallet_amount','>',0);
        })
        ->when($selectDocumentExpiry == 'dl', function ($query) use ($selectDocumentExpiry){
            return $query->where('driver_details.driver_details_dl_exp_date','>',0);
        })

        // ->when($driverUnderVerByPartner !== null, function ($query) use ($driverUnderVerByPartner) {
        //     return $query
        //         ->where('driver.driver_status', 4)
        //         ->where('driver_created_by', 1);
        // })
        // ->when($driverUnderVerBySelf !== null, function ($query) use ($driverUnderVerBySelf) {
        //     return $query
        //         ->where('driver.driver_status', 4)
        //         ->where('driver_created_by', 0);
        // }) 
        ->when($driverVerificationStatus == 'UnderVerification', function ($query) use ($driverVerificationStatus) {
            return $query
                ->where('driver.driver_status', 4)
                ->whereIn('driver_created_by', [0,1]);
        })
        ->when($driverVerificationStatus == 'UnderVerificationBySelf', function ($query) use ($driverVerificationStatus) {
            return $query
                ->where('driver.driver_status', 4)
                ->where('driver_created_by', 0);
        })
        ->when($driverVerificationStatus == 'UnderVerificationByPartner', function ($query) use ($driverVerificationStatus) {
            return $query
                ->where('driver.driver_status', 4)
                ->where('driver_created_by', 1);
        })
        ->where('driver.driver_name', 'like', '%' . $this->search . '%')
        ->select('driver_details.*','ambulance_category.*','remark_data.*', 'vehicle.*', 'city.*', 'partner.*', 'state.*', 'driver.driver_id', 'driver.driver_name', 'driver.driver_last_name', 'driver.driver_mobile','driver.driver_wallet_amount','driver.driver_duty_status','driver.join_bonus_status', 'driver.driver_on_booking_status','driver.driver_created_by', 'driver.created_at', 'driver.driver_verify_date','driver.driver_status')
        ->orderBy('driver.driver_id', 'desc')
        ->paginate(10);

// dd($drivers);


        // $employee = Employee::where('name', 'like', '%' . $this->search . '%')
        // ->orderBy('id','DESC')
        // ->paginate(5);
        // dd($employee);
        return view('livewire.admin.driver-component',[
        'drivers' => $drivers,
        ])->layout('livewire.admin.layouts.base');


        return view('livewire.admin.driver-component');
    }
    public function create()
    {
        // dd('Data:: ',$this);
        $this->resetInputFields();
        $this->openModal();
    }
    private function resetInputFields(){
        $this->name = '';
        $this->employee_id = '';
        $this->position = '';
        $this->email = '';

    }
    public function openModal()
    {
        $this->isOpen = true;
    }
    public function closeModal()
    {
        $this->isOpen = false;
    }
    public function store()
    {

        $this->validate([
            'name' => 'required',
            'email' => 'required',
            'employee_id' => 'required',
            'position' => 'required',
        ]);
        // dd($this);
        Employee::updateOrCreate(['id' => $this->id], [
            'name' => $this->name,
            'email' => $this->email,
            'position' => $this->position,
            'employee_id' => $this->employee_id
        ]);

        session()->flash('message', $this->employee_id ? 'Employee Updated Successfully.' : 'Employee Created Successfully.');
        session()->flash('type', 'store');
        $this->closeModal();
        $this->resetInputFields();
    }
    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $this->id = $id;
        $this->employee_id = $employee->employee_id;
        $this->name = $employee->name;
        $this->email = $employee->email;
        $this->position = $employee->position;
        $this->openModal();
    }
    public function delete($id)
    {
        // dd('id is ::',$id);
        Employee::find($id)->delete();
        session()->flash('message', 'Employee Deleted Successfully.');
        session()->flash('type', 'delete');
    }
    public function stateList(){
        $activeCity = DB::table('state')
            ->select('state_id','state_name')
            ->where('state_status', 1)
            ->get();
            return $activeCity;

}
}
