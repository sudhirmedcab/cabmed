<?php

namespace App\Livewire\Admin\Pathology;
use Illuminate\Support\Facades\DB; 
use Illuminate\Contracts\Encryption\DecryptException;
use Livewire\Component;
use Carbon\Carbon;
// use Livewire\WithoutUrlPagination;
// use Livewire\WithPagination;

class LabOrderDetailComponent extends Component
{
 
    public $orderId,$activeTab,$booking_status,$selectedDate,$filterData, 
    $selectedFromDate,$selectedToDate, $fromDate=null, 
    $toDate=null,$fromdate, $todate;

    public $search = '';
    protected $paginationTheme = 'bootstrap';
    public $sortBy = 'name';
    public $sortDirection = 'asc';

    public function render()
    {
        $orderId = $this->orderId;

        try {

         $decryptorderId = decrypt($orderId);

         } catch (DecryptException $e) {
             abort(403, 'Unauthorized action.');
        }


        if($this->filterData == 'orderDetails'){

            $labtestData = DB::table('customer_lab_order')
            ->leftJoin('consumer', 'consumer.consumer_id', '=', 'customer_lab_order.clo_user_id')
            ->leftJoin('lab', 'lab.lab_id', '=', 'customer_lab_order.clo_lab_id')
            ->leftJoin('city', 'city.city_id', '=', 'customer_lab_order.clo_address_city_id')
            ->leftJoin('state', 'state.state_id', '=', 'city.city_state')
            ->leftJoin('customer_lab_order_test', 'customer_lab_order_test.clot_order_id', '=', 'customer_lab_order.customer_lab_order_id')
            ->leftJoin('customer_lab_order_time_slot', 'customer_lab_order_time_slot.clots_lab_order_id', '=', 'customer_lab_order.customer_lab_order_id')
            ->leftJoin('customer_lab_patient', 'customer_lab_patient.clp_lab_order_id', '=', 'customer_lab_order.customer_lab_order_id')
            ->where('customer_lab_order.customer_lab_order_id',$decryptorderId)
            ->first();
    
            return view('livewire.admin.pathology.lab-order-detail-component',compact('labtestData'));
            
        }elseif($this->filterData == 'testDetails'){

            $ordertestDetails = DB::table('customer_lab_order_test')
            ->leftJoin('lab_test', 'lab_test.lab_test_id', '=', 'customer_lab_order_test.clot_test_id')
             ->leftJoin('customer_lab_order', 'customer_lab_order.customer_lab_order_id', '=', 'customer_lab_order_test.clot_order_id')
            ->leftJoin('lab_test_category_mapper', 'lab_test_category_mapper.ltcm_test_id', '=', 'lab_test.lab_test_id')
            ->leftJoin('city', 'city.city_id', '=', 'customer_lab_order.clo_address_city_id')
            ->leftJoin('state', 'state.state_id', '=', 'city.city_state')
            ->leftJoin('lab_category', 'lab_category.lab_category_id', '=', 'lab_test_category_mapper.ltcm_category_id')
            ->where('customer_lab_order_test.clot_order_id',$decryptorderId)
            ->paginate(10);

            $labtestData = DB::table('customer_lab_order')
            ->leftJoin('consumer', 'consumer.consumer_id', '=', 'customer_lab_order.clo_user_id')
            ->leftJoin('lab', 'lab.lab_id', '=', 'customer_lab_order.clo_lab_id')
            ->leftJoin('city', 'city.city_id', '=', 'customer_lab_order.clo_address_city_id')
            ->leftJoin('state', 'state.state_id', '=', 'city.city_state')
            ->leftJoin('customer_lab_order_test', 'customer_lab_order_test.clot_order_id', '=', 'customer_lab_order.customer_lab_order_id')
            ->leftJoin('customer_lab_order_time_slot', 'customer_lab_order_time_slot.clots_lab_order_id', '=', 'customer_lab_order.customer_lab_order_id')
            ->leftJoin('customer_lab_patient', 'customer_lab_patient.clp_lab_order_id', '=', 'customer_lab_order.customer_lab_order_id')
            ->where('customer_lab_order.customer_lab_order_id',$decryptorderId)
            ->first();

            return view('livewire.admin.pathology.lab-order-detail-component',compact('ordertestDetails','labtestData'));

        }elseif($this->filterData == 'timeDetails'){

            $labtestPatients = DB::table('customer_lab_patient')
            ->where('clp_lab_order_id',$decryptorderId)
            ->orderByDesc('customer_lab_patient.customer_lab_patient_id')
            ->paginate(10);

           
           $labtestData = DB::table('customer_lab_order')
           ->leftJoin('consumer', 'consumer.consumer_id', '=', 'customer_lab_order.clo_user_id')
           ->leftJoin('lab', 'lab.lab_id', '=', 'customer_lab_order.clo_lab_id')
           ->leftJoin('city', 'city.city_id', '=', 'customer_lab_order.clo_address_city_id')
           ->leftJoin('state', 'state.state_id', '=', 'city.city_state')
           ->leftJoin('customer_lab_order_test', 'customer_lab_order_test.clot_order_id', '=', 'customer_lab_order.customer_lab_order_id')
           ->leftJoin('customer_lab_order_time_slot', 'customer_lab_order_time_slot.clots_lab_order_id', '=', 'customer_lab_order.customer_lab_order_id')
           ->leftJoin('customer_lab_patient', 'customer_lab_patient.clp_lab_order_id', '=', 'customer_lab_order.customer_lab_order_id')
           ->where('customer_lab_order.customer_lab_order_id',$decryptorderId)
           ->first();

           return view('livewire.admin.pathology.lab-order-detail-component',compact('labtestPatients','labtestData'));

        }elseif($this->filterData == 'labDetails'){

            $labtestData = DB::table('customer_lab_order')
            ->leftJoin('consumer', 'consumer.consumer_id', '=', 'customer_lab_order.clo_user_id')
            ->leftJoin('lab', 'lab.lab_id', '=', 'customer_lab_order.clo_lab_id')
            ->leftJoin('city', 'city.city_id', '=', 'customer_lab_order.clo_address_city_id')
            ->leftJoin('state', 'state.state_id', '=', 'city.city_state')
            ->leftJoin('customer_lab_order_test', 'customer_lab_order_test.clot_order_id', '=', 'customer_lab_order.customer_lab_order_id')
            ->leftJoin('customer_lab_order_time_slot', 'customer_lab_order_time_slot.clots_lab_order_id', '=', 'customer_lab_order.customer_lab_order_id')
            ->leftJoin('customer_lab_patient', 'customer_lab_patient.clp_lab_order_id', '=', 'customer_lab_order.customer_lab_order_id')
            ->where('customer_lab_order.customer_lab_order_id',$decryptorderId)
            ->first();

            $city_id = $labtestData->clo_address_city_id;

            $labListData = DB::table('customer_lab_order')
            ->leftJoin('lab', 'lab.lab_city', '=', 'customer_lab_order.clo_address_city_id')
            ->leftJoin('lab_owner', 'lab_owner.lab_owner_id', '=', 'lab.lab_owner_by')
            ->leftJoin('city', 'city.city_id', '=', 'customer_lab_order.clo_address_city_id')
            ->leftJoin('state', 'state.state_id', '=', 'city.city_state')
            ->where('customer_lab_order.clo_address_city_id',$city_id)
            ->where('customer_lab_order.customer_lab_order_id',$decryptorderId)
            ->where('lab.lab_status','0')
            ->paginate(10);

           return view('livewire.admin.pathology.lab-order-detail-component',compact('labListData','labtestData'));

        }

        $labtestData = DB::table('customer_lab_order')
        ->leftJoin('consumer', 'consumer.consumer_id', '=', 'customer_lab_order.clo_user_id')
        ->leftJoin('lab', 'lab.lab_id', '=', 'customer_lab_order.clo_lab_id')
        ->leftJoin('city', 'city.city_id', '=', 'customer_lab_order.clo_address_city_id')
        ->leftJoin('state', 'state.state_id', '=', 'city.city_state')
        ->leftJoin('customer_lab_order_test', 'customer_lab_order_test.clot_order_id', '=', 'customer_lab_order.customer_lab_order_id')
        ->leftJoin('customer_lab_order_time_slot', 'customer_lab_order_time_slot.clots_lab_order_id', '=', 'customer_lab_order.customer_lab_order_id')
        ->leftJoin('customer_lab_patient', 'customer_lab_patient.clp_lab_order_id', '=', 'customer_lab_order.customer_lab_order_id')
        ->where('customer_lab_order.customer_lab_order_id',$decryptorderId)
        ->first();

        return view('livewire.admin.pathology.lab-order-detail-component',compact('labtestData'));
    }
}
