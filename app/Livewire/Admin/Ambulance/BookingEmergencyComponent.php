<?php

namespace App\Livewire\Admin\Ambulance;
use Illuminate\Support\Facades\DB; 
use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;
use Livewire\WithoutUrlPagination;

class BookingEmergencyComponent extends Component
{
    public $selectedDate,$filterConditionl, 
    $selectedFromDate,$selectedToDate, $fromDate=null, 
    $toDate=null,$fromdate, $todate,$selectedBookingType,$check_for,$selectedbookingStatus,$checkEmergencyStatus,$checkbookingEmergency,
    $activeTab,$consumerEmergencyId,$consumerEmergency,$events = [];
    
    

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
        }elseif($value=='bookingDashboard'){
            $this->activeTab=$value;
        }
       
  
}
    public function render()
    {

        return view('livewire.admin.ambulance.booking-emergency-component');

}

public function openModal()
{
    $this->isOpen = true;
}

public function closeModal()
{
    $this->isOpen = false;
}

public function showMap($consumerEmergencyId)
{
        $consumerEmergency = DB::table('consumer_emergency')
        ->leftjoin('consumer', 'consumer_emergency.consumer_emergency_consumer_id', '=','consumer.consumer_id')
        ->where('consumer_emergency.consumer_emergency_id','=',$consumerEmergencyId)
        ->orderByDesc('consumer_emergency.consumer_emergency_id')
        ->first();

        $this->consumerEmergency = $consumerEmergency;

    $this->openModal();
}

}
