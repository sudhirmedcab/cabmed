<?php

namespace App\Livewire\Admin\Consumer;

use Illuminate\Support\Facades\DB; 
use Illuminate\Contracts\Encryption\DecryptException;
use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class ConsumerDetailsComponent extends Component
{

    public $consumerId,$activeTab,$booking_status,$selectedDate,$filterConditionl, 
    $selectedFromDate,$selectedToDate, $fromDate=null, 
    $toDate=null,$fromdate, $todate;

    #[Layout('livewire.admin.layouts.base')]

    public function resetFilters(){
          
        $this->booking_status=null;
        $this->selectedDate=null;
    }

    public function filterCondition($value){

        $this->resetFilters();
        if($value=='driver_details'){            
            $this->activeTab=$value;
        }
    
        if($value=='Enquiry'){
            $this->booking_status='0';
            $this->activeTab=$value;
        }
        if($value=='New'){
            $this->booking_status = '1';
            $this->activeTab=$value;
        }
    
        if($value=='Ongoing'){
            $this->booking_status='2';
            $this->activeTab=$value;
        }
        if($value=='Invoice'){
            $this->booking_status = '3';
            $this->activeTab=$value;
        }
    
        if($value=='Complete'){
            $this->booking_status='4';
            $this->activeTab=$value;
        }
        if($value=='Cancel'){
            $this->booking_status = '5';
            $this->activeTab=$value;
        }
        if($value=='Transaction'){
            $this->activeTab=$value;
        }
        if($value=='consumer_transaction'){
            $this->activeTab=$value;
        }
  
}
    public function render()
    {

       $consumerId = $this->consumerId;

       try {
        $decryptconsumerId = decrypt($consumerId);
        } catch (DecryptException $e) {
            abort(403, 'Unauthorized action.');
    }

       $consumerDetails = DB::table('consumer')
       ->where('consumer_id', '=', $decryptconsumerId)
       ->first();

       if(empty($consumerDetails)){
        return redirect()->back()->with('message','Consumer Data Not Found');
       }
    
     return view('livewire.admin.consumer.consumer-details-component',compact('consumerDetails'));

        }

}

