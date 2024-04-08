<?php

namespace App\Livewire\Admin\Consumer;

use Illuminate\Support\Facades\DB; 
use Livewire\Component;
use Carbon\Carbon;
// use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class ConsumerBookingDetailsComponent extends Component
{
    use WithPagination;

    public $consumerId,$activeTab,$booking_status,$selectedDate,$filterConditionl, 
    $selectedFromDate,$selectedToDate, $fromDate=null, 
    $toDate=null,$fromdate, $todate,$check_for,$selectBookingStatus,$healthCardVerificationStatus,$selectPathologyBookingStatus;

    protected $paginationTheme = 'bootstrap';
    // 
    public $search = '';
    public $sortBy = 'name';

    #[Layout('livewire.admin.layouts.base')]

    public function resetFilters(){
        $this->selectedDate=null;
        // $this->resetPage();
        $this->search = '';
    }

    public function filterCondition($value){

        $this->resetFilters();
    
        if($value=='Enquiry'){
            $this->booking_status='0';
            $this->activeTab=$value;
        }
        
        if($value=='Transaction'){
            $this->activeTab=$value;
        }
        if($value=='consumer_transaction'){
            $this->activeTab=$value;
        }

        if($value=='pathology_booking'){
            $this->activeTab=$value;
        }

        if($value=='HealthCard'){
            $this->activeTab=$value;
        }
  
}
    public function render()
    {        
        $booking_status = $this->booking_status ? $this->booking_status : null;
        $selectBookingStatus = $this->selectBookingStatus ? $this->selectBookingStatus : "New";
        $selectPathologyBookingStatus = $this->selectPathologyBookingStatus ? $this->selectPathologyBookingStatus : "New";
        $healthCardVerificationStatus = $this->healthCardVerificationStatus ? $this->healthCardVerificationStatus : null;

        $consumerId = $this->consumerId;

        try {

         $decryptconsumerId = decrypt($consumerId);
         } catch (DecryptException $e) {
             abort(403, 'Unauthorized action.');
         }
        
         if(!$booking_status == 'HealthCard' || ! $booking_status == 'pathology_booking' || ! $booking_status == 'transaction'){
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
         }else{

       $fromDate = $this->selectedFromDate ? strtotime($this->selectedFromDate) : null;
        $toDate = $this->selectedToDate ?  strtotime($this->selectedToDate) : null;

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
                $fromDate = strtotime(date('Y-m-d'));
                $toDate = strtotime(date('Y-m-d').' 23:59:59');
                break;
            case 'yesterday':
                $fromDate = strtotime('-1 day', strtotime(date('Y-m-d')));
                $toDate = strtotime('-1 day', strtotime(date('Y-m-d').' 23:59:59'));
                break;
            case 'thisWeek':
                $fromDate = strtotime('-7 days', strtotime(date('Y-m-d')));
                $toDate = strtotime(date('Y-m-d').' 23:59:59');
                break;
            case 'thisMonth':
                $fromDate = strtotime(date('Y-m-01'));
                $toDate = strtotime(date('Y-m-t').' 23:59:59');
                break;
            default:
                $fromDate = $fromDate;
                $toDate = $toDate;
                break;
        }

         }

            if($booking_status == 'transaction'){

                $transactionDetails = DB::table('consumer')
                ->leftjoin('booking_payments', 'booking_payments.consumer_id', '=', 'consumer.consumer_id')
                ->where(function ($query) {
                    $query->where('consumer.consumer_name', 'like', '%' . $this->search . '%')
                        ->orWhere('consumer.consumer_mobile_no', 'like', '%' . $this->search . '%');
                })  
                ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                    return $query->whereBetween('booking_payments.booking_transaction_time', [$fromDate, $toDate]);
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




            if($booking_status=='pathology_booking'){
        
            $pathologybookingDetails = DB::table('customer_lab_order')
            ->leftJoin('consumer', 'consumer.consumer_id', '=', 'customer_lab_order.clo_user_id')
            ->leftJoin('city', 'city.city_id', '=', 'customer_lab_order.clo_address_city_id')
            ->leftJoin('state', 'state.state_id', '=', 'city.city_state')
            ->where(function ($query) {
                $query->where('customer_lab_order.clo_customer_name', 'like', '%' . $this->search . '%')
                    ->orWhere('customer_lab_order.clo_contact_no', 'like', '%' . $this->search . '%');
            })        
            ->where('customer_lab_order.clo_user_id','=',$decryptconsumerId)
            ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                return $query->whereBetween('customer_lab_order.clo_order_time', [$fromDate, $toDate]);
            }) 
            ->when($selectPathologyBookingStatus != 'All', function ($query) use ($selectPathologyBookingStatus) {
                return $query->when($selectPathologyBookingStatus == 'Cancel', function ($query) {
                    return $query->where('customer_lab_order.clo_status',3);
                })
                ->when($selectPathologyBookingStatus == 'New', function ($query) {
                    return $query->where('customer_lab_order.clo_status',1);
                })
            
                ->when($selectPathologyBookingStatus == 'Ongoing', function ($query) {
                    return $query->where('customer_lab_order.clo_status',2);
                })
                ->when($selectPathologyBookingStatus == 'Complete', function ($query) {
                    return $query->where('customer_lab_order.clo_status',4);
                });
            
            })
            ->orderBy('customer_lab_order.customer_lab_order_id','desc')
            ->paginate(10);

            $consumerDetails = DB::table('consumer')
            ->where('consumer_id', '=', $decryptconsumerId)
            ->first();

            if($this->check_for == 'custom'){

                return view('livewire.admin.consumer.consumer-booking-details-component',['isCustom'=>true],compact('pathologybookingDetails','consumerDetails'));
                }else {
                    return view('livewire.admin.consumer.consumer-booking-details-component',['isCustom'=>false],compact('pathologybookingDetails','consumerDetails'));
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



        if($booking_status == 'HealthCard'){

            $healthcardData = DB::table('health_card_subscription')
            ->leftJoin('health_card_plan', 'health_card_plan.health_card_plan_id', '=', 'health_card_subscription.health_card_subscription_plan_id')
            ->leftJoin('consumer', 'consumer.consumer_id', '=', 'health_card_subscription.health_card_subscription_cid')
            ->leftJoin('health_card_remark', 'health_card_remark.helth_subs_id', '=', 'health_card_subscription.health_card_subscription_id')
            ->leftJoin('user_address', 'user_address.ua_user_id', '=', 'health_card_subscription.health_card_subscription_address_id')
            ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                return $query->whereBetween('health_card_subscription.health_card_subscription_added_time_unx', [$fromDate, $toDate]);
            }) 
            ->where(function ($query) {
                $query->where('consumer.consumer_name', 'like', '%' . $this->search . '%')
                    ->orWhere('consumer.consumer_mobile_no', 'like', '%' . $this->search . '%');
            })
            ->where('health_card_subscription.health_card_subscription_cid','=',$decryptconsumerId)
            ->when($healthCardVerificationStatus == 'AllVerification', function ($query) use ($healthCardVerificationStatus) {
                return $query
                    ->whereIn('health_card_subscription.health_card_subscription_status', [1,0,2,3]);
            })
            ->when($healthCardVerificationStatus == 'NewVerification', function ($query) use ($healthCardVerificationStatus) {
                return $query
                    ->where('health_card_subscription.health_card_subscription_status', 0);
            })
            ->when($healthCardVerificationStatus == 'ActiveVerification', function ($query) use ($healthCardVerificationStatus) {
                return $query
                    ->where('health_card_subscription.health_card_subscription_status', 2);
            })
            ->when($healthCardVerificationStatus == 'AppliedVerification', function ($query) use ($healthCardVerificationStatus) {
                return $query
                    ->where('health_card_subscription.health_card_subscription_status', 1);
            })
            ->when($healthCardVerificationStatus == 'InactiveVerification', function ($query) use ($healthCardVerificationStatus) {
                return $query
                    ->where('health_card_subscription.health_card_subscription_status', 3);
            })
            ->orderByDesc('health_card_subscription.health_card_subscription_id')
            ->paginate(10);

            $consumerDetails = DB::table('consumer')
            ->where('consumer_id', '=', $decryptconsumerId)
            ->first();

       if($this->check_for == 'custom'){
        return view('livewire.admin.consumer.consumer-booking-details-component',['isCustom'=>true],compact('healthcardData','consumerDetails'));
        }else {
           return view('livewire.admin.consumer.consumer-booking-details-component',['isCustom'=>false],compact('healthcardData','consumerDetails'));
       }  

        }

        

        $bookingDetails = DB::table('booking_view')
        ->leftJoin('consumer', 'booking_view.booking_by_cid', '=', 'consumer.consumer_id')
        ->where(function ($query) {
                    $query->where('consumer.consumer_name', 'like', '%' . $this->search . '%')
                        ->orWhere('consumer.consumer_mobile_no', 'like', '%' . $this->search . '%');
                })       
         ->where('booking_view.booking_by_cid','=',$decryptconsumerId)
          ->whereNot('booking_view.booking_status',7)
         ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
            return $query->whereBetween('booking_view.created_at', [$fromDate, $toDate]);
        }) 
        ->when($selectBookingStatus != 'All', function ($query) use ($selectBookingStatus) {
            return $query->when($selectBookingStatus == 'Cancel', function ($query) {
                return $query->where('booking_view.booking_status',5);
            })
            ->when($selectBookingStatus == 'New', function ($query) {
                return $query->where('booking_view.booking_status',1);
            })
            ->when($selectBookingStatus == 'Enquiry', function ($query) {
                return $query->where('booking_view.booking_status',0);
            })
            ->when($selectBookingStatus == 'Ongoing', function ($query) {
                return $query->where('booking_view.booking_status',2);
            })
            ->when($selectBookingStatus == 'Invoice', function ($query) {
                return $query->where('booking_view.booking_status',3);
            })
            ->when($selectBookingStatus == 'Complete', function ($query) {
                return $query->where('booking_view.booking_status',4);
            });
         
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
