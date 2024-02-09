<?php

namespace App\Livewire\Admin;
use Illuminate\Support\Facades\DB; 
use Livewire\Component;
use Illuminate\Http\Request;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use App\Models\vehicle_assign_history;


class PartnerDetailListComponent extends Component
{
    public $partnerId,$activeTab,$booking_status,$selectedDate,$filterConditionl, 
    $selectedFromDate,$selectedToDate, $fromDate=null, 
    $toDate=null,$fromdate, $todate,$detailList,$check_for;
    
    public $driverId;
    public $vehicleId;

    use WithoutUrlPagination;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    // 
    public $search = '';
    public $sortBy = 'name';
    public $sortDirection = 'asc';

    #[Layout('livewire.admin.layouts.base')]    //......... add the layout dynamically for the all ...........//

    public function resetFilters(){
          
        $this->partner_status=null;
        $this->selectedDate=null;
    }

    public function filterCondition($value){

        $this->resetFilters();
        if($value=='partner_details'){            
            $this->activeTab=$value;
        }
    
        if($value=='driver'){
            $this->activeTab=$value;
        }
        if($value=='vehicle'){
            $this->activeTab=$value;
        }
    
        if($value=='transaction'){
            $this->activeTab=$value;
        }
        if($value=='assign'){
        }
    
        if($value=='refferal'){
            $this->activeTab=$value;
        }

    }

    public function render()
    {
        $basename = $this->partnerId;
        $detailList = $this->detailList;
        $decryptpartnerId = decrypt($basename);

        if($detailList == 'driver'){

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

            $driver_details = DB::table('driver')
            ->leftJoin('driver_details', 'driver.driver_id', '=', 'driver_details.driver_details_driver_id')
            ->where('driver.driver_created_partner_id','=',$decryptpartnerId)
            ->where(function ($query) {
                $query->where('driver.driver_name', 'like', '%' . $this->search . '%')
                    ->orWhere('driver.driver_last_name', 'like', '%' . $this->search . '%');
            })
            ->where('driver.driver_created_by','=','1')
            ->select('driver.driver_id', 'driver.driver_name', 'driver.driver_last_name', 'driver.driver_mobile','driver.driver_on_booking_status','driver.driver_duty_status','driver.created_at','driver.driver_wallet_amount','driver_details.driver_details_dl_number','driver.driver_status')
            ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                return $query->whereBetween('driver.created_at', [$fromDate, $toDate]);
            })
            ->orderBy('driver.driver_id','desc')
            ->paginate(10);

            if($this->check_for == 'custom'){
                return view('livewire.admin.partner-detail-list-component',[
                    'isCustom' => true
                ],compact('driver_details','decryptpartnerId'));
            }
            return view('livewire.admin.partner-detail-list-component',[
                'isCustom' => false
            ],compact('driver_details','decryptpartnerId'));


        }elseif($detailList == 'vehicle'){

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

            $Vehicles =  DB::table('vehicle')
            ->leftJoin('ambulance_category', 'vehicle.vehicle_category_type', '=', 'ambulance_category.ambulance_category_type')
            ->where('vehicle.vehicle_added_type','=','1')
            ->where(function ($query) {
                $query->where('vehicle.vehicle_rc_number', 'like', '%' . $this->search . '%')
                    ->orWhere('ambulance_category.ambulance_category_name', 'like', '%' . $this->search . '%');
            })
            ->where('vehicle.vehicle_added_by','=',$decryptpartnerId)
            ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                return $query->whereBetween('vehicle.created_at', [$fromDate, $toDate]);
            })
            ->orderBy('vehicle.vehicle_id','desc')
            ->paginate(10);

            if($this->check_for == 'custom'){
                return view('livewire.admin.partner-detail-list-component',[
                    'isCustom' => true
                ],compact('Vehicles','decryptpartnerId'));
            }
            return view('livewire.admin.partner-detail-list-component',[
                'isCustom' => false
            ],compact('Vehicles','decryptpartnerId'));

        }elseif($detailList == 'transaction'){
      
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

            $transaction =  DB::table('partner')
            ->leftjoin('partner_transection', 'partner.partner_id', '=', 'partner_transection.partner_transection_by')
           ->where('partner.partner_id','=',$decryptpartnerId)
           ->where(function ($query) {
            $query->where('partner_transection.partner_transection_pay_id', 'like', '%' . $this->search . '%')
                ->orWhere('partner_transection.partner_transection_note', 'like', '%' . $this->search . '%');
        })
           ->select('partner.*','partner_transection.*','partner_transection.created_at')
           ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
            return $query->whereBetween('partner_transection.created_at', [$fromDate, $toDate]);
        })
           ->orderBy('partner_transection.partner_transection_id','desc')
           ->paginate(10);

           if($this->check_for == 'custom'){
            return view('livewire.admin.partner-detail-list-component',[
                'isCustom' => true
            ],compact('transaction','decryptpartnerId'));
        }
        return view('livewire.admin.partner-detail-list-component',[
            'isCustom' => false
        ],compact('transaction','decryptpartnerId'));

        }elseif($detailList == 'assign'){

            $assignvehicles = DB::table('vehicle')
            ->leftJoin('ambulance_category', 'vehicle.vehicle_category_type', '=', 'ambulance_category.ambulance_category_type')
                ->where('vehicle_status', '=', '1')
                ->where('vehicle_added_type', '=', '1')
                ->where('vehicle_added_by', '=',$decryptpartnerId)
                ->get();
            
            $assigndrivers = DB::table('driver')
                            ->where('driver_status', '=', '1')
                            ->where('driver_created_by', '=', '1')
                            ->where('driver_created_partner_id', '=',$decryptpartnerId)
                            ->get();

             $getdriverorVehicle = DB::table('driver')
             ->leftjoin('vehicle','vehicle.vehicle_id','=','driver.driver_assigned_vehicle_id')
             ->where('driver_status', '=', '1')
             ->where('driver_created_by', '=', '1')
             ->where('vehicle_added_type', '=', '1')
             ->where('driver_created_partner_id',$decryptpartnerId)  
             ->where('vehicle_status', '=', '1')
             ->where('vehicle_added_by',$decryptpartnerId)
             ->get();

             foreach($getdriverorVehicle as $list){

                $driverid = $list->driver_id;
                $vehicleid = $list->vehicle_id;

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

                if(!empty($vehicleid && $driverid)){

                $assignhistoryData = DB::table('vehicle_assign_history')
                ->leftjoin('vehicle','vehicle.vehicle_id','=','vehicle_assign_history.vash_vehicle_id')
                ->leftjoin('ambulance_category','ambulance_category.ambulance_category_type','=','vehicle.vehicle_category_type')
                ->leftjoin('driver','driver.driver_id','=','vehicle_assign_history.vash_driver_id')
                ->select('driver.*','vehicle.*','ambulance_category.*','vehicle_assign_history.*','vehicle_assign_history.created_at')
                ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                    return $query->whereBetween('vehicle_assign_history.created_at', [$fromDate, $toDate]);
                })
                ->where(function ($query) {
                    $query->where('driver.driver_name', 'like', '%' . $this->search . '%')
                        ->orWhere('driver.driver_last_name', 'like', '%' . $this->search . '%')
                        ->orWhere('vehicle.vehicle_rc_number', 'like', '%' . $this->search . '%');
                })
                ->where('vehicle_assign_history.vash_vehicle_id',$vehicleid)
                ->where('vehicle_assign_history.vash_driver_id',$driverid)
                ->paginate(10);

            }

             }

             if(!empty($assignhistoryData)){

            if($this->check_for == 'custom'){
                        return view('livewire.admin.partner-detail-list-component',[
                            'isCustom' => true
                        ],compact('assigndrivers','assignvehicles','decryptpartnerId','assignhistoryData'));
                    }
                    return view('livewire.admin.partner-detail-list-component',[
                        'isCustom' => false
                    ],compact('assigndrivers','assignvehicles','decryptpartnerId','assignhistoryData'));

                }else{
                    return view('livewire.admin.partner-detail-list-component',[
                        'isCustom' => true
                    ],compact('assigndrivers','assignvehicles','decryptpartnerId'));
                }
                return view('livewire.admin.partner-detail-list-component',[
                    'isCustom' => false
                ],compact('assigndrivers','assignvehicles','decryptpartnerId'));


        }elseif($detailList == 'refferal'){

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
               $partnerData = DB::table('partner')
                        ->where('partner_id', '=', $decryptpartnerId)
                        ->orderBy('partner_id', 'desc')
                        ->first();

                        $partnerReferral = $partnerData->partner_referral;
                        $refferal_data = DB::table('partner')
                            ->where('referral_referral_by', 'LIKE', '%'.$partnerReferral.'%')
                            ->paginate(10);

                          $buckets = []; // Initialize the $buckets array outside the loop
                                        
                            foreach($refferal_data as $key)
                            {
                                $datas['partner_id'] = $key->partner_id;
                                $datas['partner_f_name'] = $key->partner_f_name;
                                $datas['partner_l_name'] = $key->partner_l_name;
                                $datas['partner_dob'] = $key->partner_dob;
                                $datas['partner_mobile'] = $key->partner_mobile;
                                $datas['partner_city_id'] = $key->partner_city_id;
                                $datas['partner_gender'] = $key->partner_gender;
                                $datas['partner_profile_img'] = $key->partner_profile_img;
                                $datas['partner_referral'] = $key->partner_referral;
        
                                array_push($buckets,$datas);
                            }
                         
                            $refferalList = $buckets; // Assign the $buckets array to $bucket 
             
             if($this->check_for == 'custom'){
                return view('livewire.admin.partner-detail-list-component',[
                    'isCustom' => true
                ],compact('refferalList','refferal_data','decryptpartnerId'));
            }
            return view('livewire.admin.partner-detail-list-component',[
                'isCustom' => false
            ],compact('refferalList','refferal_data','decryptpartnerId'));

        }else{
                    return "No any filter Data Founds";
        }
    }

    public function AssignDriver(Request $request){

        $validatedData = $this->validate([
            'driverId' => 'required',
            'vehicleId' => 'required',
        ]);

        $basename = $this->partnerId;
        $driver_id = $this->driverId;
        $vehicle_id = $this->vehicleId;
        $partner_id = decrypt($basename);
        $authkey = "dssssdsss";

        $checkAssignHistory = DB::table('vehicle_assign_history')
        ->where('vash_vehicle_id',$vehicle_id)
        ->where('vash_driver_id',$driver_id)
        ->first();

        if($checkAssignHistory){
            session()->flash('message', 'Already Assigned !!.');
            session()->flash('type', 'delete');
            return redirect()->back();
        }

        $vehicle_assign_history = new vehicle_assign_history;
        $data=DB::table('partner')->where('partner_id',$partner_id)->get();
        if(count($data)>0){
            $vehicle=DB::table('vehicle')->where('vehicle_id',$vehicle_id) ->where('vehicle_status','=', '1')->get();
            $driver=DB::table('driver') ->where('driver_id',$driver_id)
            ->where('driver_status','=', '1')
            ->where('driver_on_booking_status','=', '0')
            ->get();

        if(count($vehicle)>0 AND count($driver)>0){
                //remove vehicle if ssigned to anyone
                $chechk_driver=DB::table('driver')->where('driver_id',$driver_id)->where('driver_assigned_vehicle_id',$vehicle_id)->get();
                // print_r($chechk_driver); exit();
                if(count($chechk_driver)>0 ){
                    foreach($chechk_driver as $key){
                        $remove_drive_id = $key->driver_id; 
                        $remove_vehicle_from_driver = db::table('driver')
                        ->where('driver_id','=',$remove_drive_id)
                        ->update(['driver_assigned_vehicle_id' =>'0']); 
                    }
                }

                //assign vehicle to driver
                db::table('driver')->where('driver_id','=',$driver_id)->update(['driver_assigned_vehicle_id' =>$vehicle_id]); 
            
                $vehicle_assign_history->vash_vehicle_id = $vehicle_id;
                $vehicle_assign_history->vash_driver_id = $driver_id;
                $vehicle_assign_history->vash_time = time();
                $vehicle_assign_history->vash_status = '0';
                $vehicle_assign_history->save();

                session()->flash('message', 'Assigned successfully.');
                session()->flash('type', 'store');

        }
        }   
        else{
                    $message = 'Please Check your Id , Please try again!';
                    session()->flash('success', $message);
                    session()->flash('type', 'delete');
                    return redirect()->back();
        }

        
    }
}
