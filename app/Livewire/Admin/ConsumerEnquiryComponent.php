<?php

namespace App\Livewire\Admin;
use Illuminate\Support\Facades\DB; 
use Livewire\Component;
use Carbon\Carbon;
use App\models\consumer;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class ConsumerEnquiryComponent extends Component
{
    public $selectedDate,$filterConditionl, 
    $selectedFromDate,$selectedToDate, $fromDate=null, 
    $toDate=null,$fromdate, $todate, $id, $name, $email,
    $position, $employee_id, $consumer_status,$mainServiceFiter,$check_for,
    $ambulanceServiceFiter,$ambulanceService,$dialrecordFiter,

    $activeTab;
    
    public $isOpen = 0;
    use WithPagination;
    use WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';
    // 
    public $search = '';
    public $sortBy = 'name';
    public $sortDirection = 'asc';

    #[Layout('livewire.admin.layouts.base')]    //......... add the layout dynamically for the all ...........//

            public function resetFilters(){
          
                $this->consumer_status=null;
                $this->selectedDate=null;
            }

            public function filterCondition($value){
                $this->resetFilters();
                    if($value=='app'){            
                    $this->activeTab=$value;
                    $this->consumer_status='1';
                }
            
                if($value=='web'){
                    $this->consumer_status='0';
                    $this->activeTab=$value;
                }
                if($value=='dial'){
                    $this->consumer_status = 'null';
                    $this->activeTab=$value;
                }
          
        }
 
    public function render()
    {
        if($this->activeTab=='dial'){

            $currentTimestamps = Carbon::now();
            $firstDayOfMonths = Carbon::now()->startOfMonth(); 

            $dialrecordFiter = $this->dialrecordFiter ? $this->dialrecordFiter : null;
            $fromDate = $this->selectedFromDate ? Carbon::createFromFormat('Y-m-d', $this->selectedFromDate)->startOfDay() : null;
            $toDate = $this->selectedToDate ? Carbon::createFromFormat('Y-m-d', $this->selectedToDate)->endOfDay() : null;
            
            if($this->selectedDate == 'custom'){
                $this->selectedFromDate;
                $this->selectedToDate;
            }else{
                $this->selectedFromDate ='';
                $this->selectedToDate =''; 
            }

            switch ($this->dialrecordFiter) {
                case 'govtNumber':
                    $this->thisNumber='108';
                    break;
                case 'landline':
                    $this->thisNumber='18008908208';
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
    
            
            $consumer_dial_data = DB::table('consumer_dial_record')
            ->leftJoin('consumer', 'consumer.consumer_id', '=', 'consumer_dial_record.cdr_consumer_id')
            ->leftJoin('hospital_lists', 'hospital_lists.hospital_id', '=', 'consumer_dial_record.cdr_hospital_id')
            ->leftJoin('remark_data', 'remark_data.remark_consumer_dial_id', '=', 'consumer_dial_record.cdr_id')
            ->leftJoin('admin', 'admin.id', '=', 'remark_data.remark_type')
            ->where('consumer_dial_record.consumer_dial_records_status','<>', 1)
            ->where('consumer.consumer_name', 'like', '%' . $this->search . '%')
            ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                return $query->whereBetween('consumer_dial_record.created_at', [$fromDate, $toDate]);
            })  
            ->when($dialrecordFiter == 'govtNumber', function ($query) use ($dialrecordFiter) {
                return $query
                    ->where('consumer_dial_record.cdr_number', $this->thisNumber);
            })
            ->when($dialrecordFiter == 'landline', function ($query) use ($dialrecordFiter) {
                return $query
                    ->where('consumer_dial_record.cdr_number', $this->thisNumber);
            })
            ->when($dialrecordFiter == 'private', function ($query) use ($dialrecordFiter) {
                return $query
                    ->whereNotIn('consumer_dial_record.cdr_number', ['108','18008908208']);
            })
            ->select('consumer.*','hospital_lists.*','remark_data.*','admin.*','consumer_dial_record.cdr_current_lat','consumer_dial_record.cdr_current_long','consumer_dial_record.cdr_id','consumer_dial_record.cdr_consumer_id','consumer_dial_record..cdr_hospital_id','consumer_dial_record.cdr_number','consumer_dial_record.created_at')
            ->OrderByDesc('cdr_id')
            ->paginate(10);
    
            $buket_map_data = [];
    
            foreach($consumer_dial_data as $location_data){
                $add_data['cdr_current_lat'] = $location_data->cdr_current_lat;
                $add_data['cdr_current_long'] = $location_data->cdr_current_long;
                $add_data['consumer_name'] = $location_data->consumer_name;
                $add_data['consumer_mobile_no'] = $location_data->consumer_mobile_no;
                array_push($buket_map_data, $add_data);
            }
    
    
            if($this->check_for == 'custom'){
                return view('livewire.admin.consumer-dial-component',[
                    'isCustom' => true
                ],compact('buket_map_data','consumer_dial_data'));
            }
            return view('livewire.admin.consumer-dial-component',[
                'isCustom' => false
            ],compact('buket_map_data','consumer_dial_data'));

        }elseif($this->activeTab=='web'){
            $currentTimestamps = Carbon::now();
            $firstDayOfMonths = Carbon::now()->startOfMonth(); 

            $ambulanceServiceFiter = $this->ambulanceServiceFiter ? $this->ambulanceServiceFiter : null;
            $fromDate = $this->selectedFromDate ? Carbon::createFromFormat('Y-m-d', $this->selectedFromDate)->startOfDay() : null;
            $toDate = $this->selectedToDate ? Carbon::createFromFormat('Y-m-d', $this->selectedToDate)->endOfDay() : null;
            
            if($this->selectedDate == 'custom'){
                $this->selectedFromDate;
                $this->selectedToDate;
            }else{
                $this->selectedFromDate ='';
                $this->selectedToDate =''; 
            }


            switch ($this->ambulanceServiceFiter) {
                case 'roadAmbulance':
                    $this->ambulanceService='Road';
                    break;
                case 'deadbodyAmbulance':
                    $this->ambulanceService='Dead';

                    break;
                case 'trainAmbulance':
                    $this->ambulanceService='Train';

                    break;
                case 'airAmbulance':
                    $this->ambulanceService='Air';
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
    
            $medcabWebRecords = DB::table('medcab_enquiry_record')
            ->select([
                'medcab_enquiry_record.enquiry_id',
                'medcab_enquiry_record.created_at',
                'medcab_enquiry_record.enquiry_name',
                'medcab_enquiry_record.enquiry_mobile',
                'medcab_enquiry_record.medcab_enquiry_record_url',
                'city.city_name',
                'state.state_name',
                'medcab_enquiry_record.enquiry_ambulance',
                'remark_data.remark_id',
                'remark_data.ambulance_enquire_id',
                'remark_data.remark_text',
                'admin.admin_name',
            ])
            ->leftjoin('city', 'city.city_id', '=', 'medcab_enquiry_record.enquiry_city')
            ->leftjoin('state', 'state.state_id', '=', 'city.city_state')
            ->where('medcab_enquiry_record.enquiry_name', 'like', '%' . $this->search . '%')
            ->where(function ($query) {
                $query->where('medcab_enquiry_record.enquiry_name', 'like', '%' . $this->search . '%')
                    ->orWhere('medcab_enquiry_record.enquiry_ambulance', 'like', '%' . $this->search . '%');
            })
            ->where('medcab_enquiry_record.enquiry_ambulance', 'like', '%' . $this->ambulanceService . '%')
            ->leftJoin('remark_data', 'remark_data.ambulance_enquire_id', '=', 'medcab_enquiry_record.enquiry_id')
            ->leftJoin('admin', 'admin.id', '=', 'remark_data.remark_type')
            ->where('medcab_enquiry_record.medcab_enquiry_record_status','<>', 1)
            ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                return $query->whereBetween('medcab_enquiry_record.created_at', [$fromDate, $toDate]);
            }) 
            ->orderBy('enquiry_id', 'desc')
            ->paginate(10);
        
            if($this->check_for == 'custom'){
                return view('livewire.admin.consumer-web-component',[
                    'isCustom' => true
                ],compact('medcabWebRecords'));
            }
            return view('livewire.admin.consumer-web-component',[
                'isCustom' => false
            ],compact('medcabWebRecords'));

        }

        $currentTimestamps = Carbon::now();
        $firstDayOfMonths = Carbon::now()->startOfMonth(); 
 
        $mainServiceFiter = $this->mainServiceFiter ? $this->mainServiceFiter : null;
        $fromDate = $this->selectedFromDate ? Carbon::createFromFormat('Y-m-d', $this->selectedFromDate)->startOfDay() : null;
        $toDate = $this->selectedToDate ? Carbon::createFromFormat('Y-m-d', $this->selectedToDate)->endOfDay() : null;
        
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

        
        $mainServices = DB::table('a_main_services')
        ->where('ams_lang_id','1')
        ->get();
              
        $consumers =  DB::table('genral_enquary')
        ->leftJoin('a_main_services', 'a_main_services.ams_id', '=', 'genral_enquary.genral_enquary_ms_category_id')
        ->where('genral_enquary.genral_enquary_consumer_name', 'like', '%' . $this->search . '%')
        ->leftJoin('remark_data', 'remark_data.remark_consumer_enquiry_records_id', '=', 'genral_enquary.genral_enquary_id')
        ->leftJoin('admin', 'admin.id', '=', 'remark_data.remark_type')
        ->where('a_main_services.ams_lang_id', 1)
        ->where('genral_enquary.genral_enquary_status','<>', 1)
        ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
            return $query->whereBetween('genral_enquary.created_at', [$fromDate, $toDate]);
        })  
        ->when($mainServiceFiter !==null , function ($query) use ($mainServiceFiter) {
            return $query
                ->where('genral_enquary.genral_enquary_ms_category_id',$mainServiceFiter);
        })
        ->orderby('genral_enquary.genral_enquary_time','desc')
        ->paginate(10);


        if($this->check_for == 'custom'){
            return view('livewire.admin.consumer-enquiry-component',[
                'isCustom' => true
            ],compact('consumers','mainServices'));
        }
        return view('livewire.admin.consumer-enquiry-component',[
            'isCustom' => false
        ],compact('consumers','mainServices'));
    

    }
 
      
    public function delete($id)
    {
        $conusmerenquiryDelete = DB::table('genral_enquary')->where('genral_enquary_id',$id)->update(['genral_enquary_status'=>'1']);

        session()->flash('message', 'Consumer Enquiry Data Deleted Successfully.');
        session()->flash('type', 'delete');
    }

    public function deleteconsumerDial($id)
    {
        $conusmerdialDelete = DB::table('consumer_dial_record')->where('cdr_id',$id)->update(['consumer_dial_records_status'=>'1']);

        session()->flash('message', 'Consumer Dial Data Deleted Successfully.');
        session()->flash('type', 'delete');
    }


    public function deleteconsumerWeb($id)
    {
        $deleteconsumerWeb = DB::table('medcab_enquiry_record')->where('enquiry_id',$id)->update(['medcab_enquiry_record_status'=>'1']);

        session()->flash('message', 'Consumer Web Enquiry Data Deleted Successfully.');
        session()->flash('type', 'delete');
    }

    public function SaveconsumerWeb($id)
    {
        try {

        $getconsumerWeb = DB::table('medcab_enquiry_record')->where('enquiry_id',$id)->first();

        $checkDuplicasy = DB::table('consumer')->where('consumer_mobile_no',$getconsumerWeb->enquiry_mobile)->first();

        if($checkDuplicasy){
            return redirect()->back()->with(['message'=> 'Consumer Already Existed !!.','type'=>'delete']);
        }

        $consumer = new consumer();
        $consumer->consumer_auth_key = "dsdsdsdsd";
        $consumer->consumer_mobile_no = $getconsumerWeb->enquiry_mobile;
        $consumer->consumer_name = $getconsumerWeb->enquiry_name;
        $consumer->consumer_registred_date = Carbon::now()->timestamp;
        $consumer->consumer_registred_date = Carbon::now()->timestamp;
        $consumer->consumer_city_id = $getconsumerWeb->enquiry_city ?? 'N/A';
        $consumer->consumer_status = '1';
        $consumer->save();
    
        session()->flash('message', 'Your Consumer Data  Saved Successfully.');
        session()->flash('type', 'store');
    } catch (\Exception $e) {

    return $e->getMessage();
}

}

}
