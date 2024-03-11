<?php

namespace App\Livewire\Admin\Ambulance;
use Illuminate\Support\Facades\DB; 
use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;

class BookingInvoiceComponent extends Component
{
    public $selectedDate,$filterConditionl, 
    $selectedFromDate,$selectedToDate, $fromDate=null, 
    $toDate=null,$checkbookingEmergency,$check_for,$selectedbookingStatus,$selectedBookingType,
    $activeTab,$driver_duty_status,$ambulance_category_id,$vehicleId,$p_latitude,$p_longitude,$pickup_address,$pickup__address,$driverData,$executiveId;

    public $isOpen = 0;
    use WithPagination;
    use WithFileUploads;

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
            try {

            $selectedbookingStatus = $this->selectedbookingStatus ? $this->selectedbookingStatus : "Invoice";
            $executiveId = $this->executiveId ? $this->executiveId : "All";
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

            $bookingInvoiceData = DB::table('booking_view')
            ->leftJoin('driver', 'driver.driver_id', '=', 'booking_view.booking_acpt_driver_id')
            ->leftJoin('city', 'city.city_name', '=', 'booking_view.booking_pickup_city')
            ->leftJoin('state', 'state.state_id', '=', 'city.city_state')
            ->leftJoin('remark_data', 'remark_data.remark_booking_id', '=', 'booking_view.booking_id')
            ->leftJoin('admin', 'admin.id', '=', 'remark_data.remark_type')
            ->where('booking_status', '!=', '7')
            ->where(function ($query) {
                $query->where('booking_view.booking_con_name', 'like', '%' . $this->search . '%')
                    ->orWhere('booking_view.booking_con_mobile', 'like', '%' . $this->search . '%');
            })
            ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                return $query->whereBetween('booking_view.created_at', [$fromDate, $toDate]);
            }) 
           
            ->when($executiveId != 'All', function ($query) use ($executiveId) {
                return $query
                    ->where('booking_view.booking_user_id',$executiveId);
            })
            ->when($selectedbookingStatus == 'Enquiry', function ($query) use ($selectedbookingStatus) {
                return $query
                    ->where('booking_view.booking_status',0);
            })
            ->when($selectedbookingStatus == 'New', function ($query) use ($selectedbookingStatus) {
                return $query
                    ->where('booking_view.booking_status',1);
            })
            ->when($selectedbookingStatus == 'Ongoing', function ($query) use ($selectedbookingStatus) {
                return $query
                    ->where('booking_view.booking_status',2);
            })
            ->when($selectedbookingStatus == 'Invoice', function ($query) use ($selectedbookingStatus) {
                return $query
                    ->where('booking_view.booking_status',3);
            })
            ->when($selectedbookingStatus == 'Complete', function ($query) use ($selectedbookingStatus) {
                return $query
                    ->where('booking_view.booking_status',4);
            })
            ->when($selectedbookingStatus == 'Cancel', function ($query) use ($selectedbookingStatus) {
                return $query
                    ->where('booking_view.booking_status',5);
            })
            ->when($selectedbookingStatus == 'Future', function ($query) use ($selectedbookingStatus) {
                return $query
                    ->where('booking_view.booking_status',6);
            })    
            ->select('booking_view.booking_id','booking_view.created_at as created_time','booking_view.booking_source','booking_view.booking_type','booking_view.booking_by_cid','booking_view.booking_category','booking_view.booking_schedule_time','booking_view.booking_schedule_time_v1','booking_view.booking_pickup','booking_view.booking_drop','booking_view.booking_pickup_city','booking_view.booking_drop_city','booking_view.booking_amount','booking_view.booking_adv_amount','booking_view.booking_status','booking_view.booking_total_amount','booking_view.booking_user_id','booking_view.booking_acpt_driver_id','booking_view.booking_acpt_vehicle_id','booking_view.booking_con_name','booking_view.booking_con_mobile','booking_view.booking_category','booking_view.booking_view_category_name','remark_data.*' ,'admin.*','driver.driver_name','driver.driver_last_name','driver.driver_mobile','state.state_name')
            ->orderBy('booking_view.booking_id', 'desc')
            ->paginate(10);

            // dd($bookingInvoiceData);

            if(count($bookingInvoiceData)>0){

                foreach($bookingInvoiceData as $bookingInvoice){

                    $bookinguserId = $bookingInvoice->booking_user_id;
            
                        $leadData = [];
            
                        $leadbookingData = DB::table('admin')
                                        ->where('id', $bookinguserId)
                                        ->value('admin_name');
            
                            $leadData[$bookinguserId] = $leadbookingData;
                                               
              }
            }else{
                $leadbookingData = [];
            }
              
          $customerSupport = DB::table('admin')
          ->where('admin_u_status','0')
          ->get();

            if($this->check_for == 'custom'){
                return view('livewire.admin.ambulance.booking-invoice-component',[
                    'isCustom' => true
                ],compact('bookingInvoiceData','leadbookingData','customerSupport'));
            }
            return view('livewire.admin.ambulance.booking-invoice-component',[
                'isCustom' => false
            ],compact('bookingInvoiceData','leadbookingData','customerSupport'));
        

        } catch (\Exception $e) {
            session()->flash('message', 'something went wrong!!'.$e->getMessage());
        }
    
}
}
