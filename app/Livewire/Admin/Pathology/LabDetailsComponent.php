<?php

namespace App\Livewire\Admin\Pathology;
use Illuminate\Support\Facades\DB; 
use Livewire\Component;
use Carbon\Carbon;
// use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use \Crypt;

class LabDetailsComponent extends Component
{
    
    public $LabOwnerId,$activeTab,$booking_status,$selectedDate,$filterConditionl, 
    $selectedFromDate,$selectedToDate, $fromDate=null, 
    $toDate=null,$fromdate, $todate , $Details;

    #[Layout('livewire.admin.layouts.base')]

    public function resetFilters(){
          
        $this->booking_status=null;
        $this->selectedDate=null;
    }

    public function render()
    {
        $lab_owner_id = $this->LabOwnerId;
        
       try {
        $decryptLabOwnerId = decrypt($lab_owner_id);
        } catch (DecryptException $e) {
            abort(403, 'Unauthorized action.');
        }
      
        if($this->Details == 'Transaction'){

            $getlabId = DB::table('lab')
            ->where('lab_owner_by',$decryptLabOwnerId)
            ->first();

            $labId = $getlabId->lab_id;

            $labTransaction = DB::table('lab_owner')
            ->leftJoin('lab', 'lab.lab_owner_by', '=', 'lab_owner.lab_owner_id')
            ->leftJoin('lab_transaction', 'lab_transaction.lab_transaction_lab_id', '=', 'lab.lab_id')
            ->leftJoin('city', 'city.city_id', '=', 'lab_owner.lab_owner_city_name')
            ->leftJoin('state', 'state.state_id', '=', 'city.city_state')
            ->where('lab.lab_id',$labId)
            ->orderByDesc('lab_transaction.lab_transaction_id')
            ->paginate(10);
        
            if(empty($labTransaction[0]->lab_transaction_lab_id)){
                session()->flash('inactiveMessage', 'Your Lab Transaction History Not Availabe.');
                $this->redirect(route('lab_details',['LabOwnerId' => Crypt::encrypt($getlabId->lab_owner_by),'Details'=>'details']));
            }
        
            $lab_test_data = []; // Initialize an empty array to hold the grouped data.
          
            foreach ($labTransaction as $key) {
                $orderId = $key->lab_transaction_order_id;
        
                $lab_test_details = DB::table('customer_lab_order')
                    ->leftJoin('consumer', 'consumer.consumer_id', '=', 'customer_lab_order.clo_user_id')
                    ->leftJoin('customer_lab_order_test', 'customer_lab_order_test.clot_order_id', '=', 'customer_lab_order.customer_lab_order_id')
                    ->leftJoin('lab_test', 'lab_test.lab_test_id', '=', 'customer_lab_order_test.clot_test_id')
                     ->where('customer_lab_order.customer_lab_order_id', $orderId)
                    ->get();
        
                $lab_test_data[$orderId] = $lab_test_details;

            }

            return view('livewire.admin.pathology.lab-details-component',compact('labTransaction', 'lab_test_data','getlabId'));

        }

        $lab_data = DB::table('lab_owner')
        ->leftJoin('lab', 'lab.lab_owner_by', '=', 'lab_owner.lab_owner_id')
        ->leftJoin('lab_bank_details', 'lab_bank_details.lab_owner_id', '=', 'lab_owner.lab_owner_id')
        ->leftJoin('lab_certificate_details', 'lab_certificate_details.lab_certificate_owner_id', '=', 'lab_owner.lab_owner_id')
        ->leftJoin('city', 'city.city_id', '=', 'lab_owner.lab_owner_city_name')
        ->leftJoin('state', 'state.state_id', '=', 'city.city_state')
        ->where('lab_owner.lab_owner_id',$decryptLabOwnerId)
        ->first();

        $get_lab_id = DB::table('lab')
        ->where('lab_owner_by',$decryptLabOwnerId)
        ->first();

        $user_lab_id = $get_lab_id->lab_id;
        
        $lab_test_data = DB::table('lab_test')
        ->leftJoin('lab_category', 'lab_category.lab_category_id', '=', 'lab_test.lt_category')
        ->leftJoin('lab_test_prices', 'lab_test_prices.ltp_test_id', '=', 'lab_test.lab_test_id')
        ->where('lab_test.lt_lab_id',$user_lab_id)
        ->orderByDesc('lab_test.lab_test_id')
        ->get();

        return view('livewire.admin.pathology.lab-details-component',compact('lab_data','lab_test_data'));
    }
}
