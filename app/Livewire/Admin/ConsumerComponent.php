<?php

namespace App\Livewire\Admin;
use Illuminate\Support\Facades\DB; 
use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class ConsumerComponent extends Component
{
    public $partner_id, $partner_f_name, $partner_l_name, $partner_mobile, $partner_dob ,$partner_gender,$partner_city_id,$partner_aadhar_no,$partner_referral ,$referral_referral_by,$partner_aadhar_back,$partner_aadhar_front,$partner_profile_img,$employees0,$selectedDate,$filterConditionl, 
    $selectedFromDate,$selectedToDate, $fromDate=null, 
    $toDate=null,$fromdate, $todate, $id, $name, $email,
    $position, $employee_id, $consumer_status,$consumerVerificationStatus,$check_for,

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
                    if($value=='Active'){            
                    $this->activeTab=$value;
                    $this->consumer_status='1';
                }
            
                if($value=='New'){
                    $this->consumer_status='0';
                    $this->activeTab=$value;
                }
                if($value=='All'){
                    $this->consumer_status = 'null';
                    $this->activeTab=$value;
                }
          
        }
 
    public function render()
    {

        $currentTimestamps = Carbon::now();
        $firstDayOfMonths = Carbon::now()->startOfMonth(); 
 
        $consumer_status = $this->consumer_status ? $this->consumer_status : null;
        $consumerVerificationStatus = $this->consumerVerificationStatus ? $this->consumerVerificationStatus : null;
        $fromDate = $this->selectedFromDate ? Carbon::createFromFormat('Y-m-d', $this->selectedFromDate)->startOfDay() : null;
        $toDate = $this->selectedToDate ? Carbon::createFromFormat('Y-m-d', $this->selectedToDate)->endOfDay() : null;

    //    if($this->selectedFromDate && $this->selectedToDate){
    //         $this->selectedDate = null;     
    //     }
        
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
       
        
        $data['consumers'] = DB::table('consumer')
        ->leftJoin('remark_data', 'consumer.consumer_id', '=', 'remark_data.remark_consumer_id')
        ->leftJoin('admin', 'admin.id', '=', 'remark_data.remark_type')  
        ->where('consumer.consumer_name', 'like', '%' . $this->search . '%')
        ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
            return $query->whereBetween('consumer.created_at', [$fromDate, $toDate]);
        })  
        ->when($consumerVerificationStatus == 'AllVerification', function ($query) use ($consumerVerificationStatus) {
            return $query
                ->whereIn('consumer.consumer_status', [1,0]);
        })
        ->when($consumerVerificationStatus == 'NewVerification', function ($query) use ($consumerVerificationStatus) {
            return $query
                ->where('consumer.consumer_status', 0);
        })
        ->when($consumerVerificationStatus == 'ActiveVerification', function ($query) use ($consumerVerificationStatus) {
            return $query
                ->where('consumer.consumer_status', 1);
        })
        ->when($consumerVerificationStatus == 'InactiveVerification', function ($query) use ($consumerVerificationStatus) {
            return $query
                ->where('consumer.consumer_status', 2);
        })
        ->select('consumer.*','remark_data.*','admin.*','consumer.created_at')
        ->orderBy('consumer_id','desc')
        ->paginate(10);


        if($this->check_for == 'custom'){
            return view('livewire.admin.consumer-component',$data,[
                'isCustom' => true
            ]);
        }
        return view('livewire.admin.consumer-component',$data,[
            'isCustom' => false
        ]);
        

    }

    public function create()
    {
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
        $consumerData = DB::table('consumer')->where('consumer_id',$id)->first();
        
        $consumerStatus = $consumerData->consumer_status;

        if($consumerStatus == 0){
            $consumerDelete = DB::table('consumer')->where('consumer_id',$id)->update(['consumer_status'=>'2']);
            session()->flash('message', 'Consumer Data Deleted Successfully.');
           session()->flash('type', 'delete');
        }elseif($consumerStatus == 1){
            $consumerDelete = DB::table('consumer')->where('consumer_id',$id)->update(['consumer_status'=>'2']);
            session()->flash('message', 'Consumer Data Deleted Successfully.');
           session()->flash('type', 'delete');
        }elseif($consumerStatus == 2){
            $consumerDelete = DB::table('consumer')->where('consumer_id',$id)->update(['consumer_status'=>'1']);
            session()->flash('message', 'Consumer Data Activated Successfully.');
            session()->flash('type', 'delete');
        }


    }
}
