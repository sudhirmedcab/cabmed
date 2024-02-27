<?php

namespace App\Livewire\Admin\Consumer;

use Illuminate\Support\Facades\DB; 
use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class ConsumerBookingDetailsComponent extends Component
{

    public $consumerId,$activeTab,$booking_status,$selectedDate,$filterConditionl, 
    $selectedFromDate,$selectedToDate, $fromDate=null, 
    $toDate=null,$fromdate, $todate,$check_for;

    protected $paginationTheme = 'bootstrap';
    // 
    public $search = '';
    public $sortBy = 'name';

    #[Layout('livewire.admin.layouts.base')]

    public function resetFilters(){
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
        $booking_status = $this->booking_status ? $this->booking_status : null;
        $consumerId = $this->consumerId;

        try {
         $decryptconsumerId = decrypt($consumerId);
         } catch (DecryptException $e) {
             abort(403, 'Unauthorized action.');
         }

                
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

            if($booking_status == 'transaction'){

                $transactionDetails = DB::table('consumer')
                ->leftjoin('booking_payments', 'booking_payments.consumer_id', '=', 'consumer.consumer_id')
                ->where(function ($query) {
                    $query->where('consumer.consumer_name', 'like', '%' . $this->search . '%')
                        ->orWhere('consumer.consumer_mobile_no', 'like', '%' . $this->search . '%');
                })  
                ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                    return $query->whereBetween('booking_payments.created_at', [$fromDate, $toDate]);
                }) 
                ->where('booking_payments.consumer_id','=',$decryptconsumerId)
                ->orderBy('consumer.consumer_id','desc')
                ->paginate(10);

                $consumerDetails = DB::table('consumer')
                ->where('consumer_id', '=', $decryptconsumerId)
                ->first();

                if($this->check_for == 'custom'){
                    return view('livewire.admin.consumer.consumer-booking-details-component',['isCustom'=>true],compact('transactionDetails','consumerDetails'));
                    }else {
                       return view('livewire.admin.consumer.consumer-booking-details-component',['isCustom'=>false],compact('transactionDetails','consumerDetails'));
                   }            
            }

            if($booking_status == 'consumer_transaction'){

               $consumerTransaction = DB::table('consumer_transection')
                        ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                            return $query->whereBetween('consumer_transection.created_at', [$fromDate, $toDate]);
                        }) 
                        ->where('consumer_transection_done_by','=',$decryptconsumerId)
                        ->paginate(10);

               $consumerDetails = DB::table('consumer')
                        ->where('consumer_id', '=', $decryptconsumerId)
                        ->first();

                if($this->check_for == 'custom'){
                    return view('livewire.admin.consumer.consumer-booking-details-component',['isCustom'=>true],compact('consumerTransaction','consumerDetails'));
                    }else {
                       return view('livewire.admin.consumer.consumer-booking-details-component',['isCustom'=>false],compact('consumerTransaction','consumerDetails'));
                   }            
            }

        $bookingDetails = DB::table('booking_view')
        ->leftJoin('consumer', 'booking_view.booking_by_cid', '=', 'consumer.consumer_id')
        ->where(function ($query) {
                    $query->where('consumer.consumer_name', 'like', '%' . $this->search . '%')
                        ->orWhere('consumer.consumer_mobile_no', 'like', '%' . $this->search . '%');
                })       
         ->where('booking_view.booking_by_cid','=',$decryptconsumerId)
         ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
            return $query->whereBetween('booking_view.created_at', [$fromDate, $toDate]);
        }) 
        ->when($booking_status !== '0', function ($query) use ($booking_status) {
            return $query->where('booking_view.booking_status', $this->booking_status);
        })
        ->select(
            'booking_view.booking_id',
            'booking_view.booking_source',
            'booking_view.booking_type',
            'booking_view.created_at as booking_created_at',
            'booking_view.booking_pickup',
            'booking_view.booking_con_name',
            'booking_view.booking_con_mobile',
            'booking_view.booking_view_category_name',
            'booking_view.booking_view_total_fare',
            'booking_view.booking_drop',
            'booking_view.booking_payment_method',
            'booking_view.booking_status',
            'consumer.*'
        )
        ->orderBy('booking_view.booking_id','desc')
         ->paginate(10);

         $consumerDetails = DB::table('consumer')
         ->where('consumer_id', '=', $decryptconsumerId)
         ->first();

         if($this->check_for == 'custom'){
         return view('livewire.admin.consumer.consumer-booking-details-component',['isCustom'=>true],compact('bookingDetails','consumerDetails'));
         }else {
            return view('livewire.admin.consumer.consumer-booking-details-component',['isCustom'=>false],compact('bookingDetails','consumerDetails'));
        }

        }

    
}
