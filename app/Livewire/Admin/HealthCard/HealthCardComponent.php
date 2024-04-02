<?php

namespace App\Livewire\Admin\HealthCard;
use Illuminate\Support\Facades\DB; 
use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
class HealthCardComponent extends Component
{
    public $selectedDate,$filterConditionl, 
    $selectedFromDate,$selectedToDate, $fromDate=null, 
    $toDate=null,$fromdate, $todate,$check_for,$healthCardVerificationStatus,
    $activeTab,$health_card_subscription_exp_date,$health_card_subscription_id,$health_card_subscription_cid,$health_card_subscription_plan_id,$health_card_subscription_card_no,$health_card_subscription_name,$health_card_subscription_last_name,$health_card_subscription_mobile_no,$health_card_subscription_gender,$health_card_subscription_address_id,$health_card_subscription_issue_date,$health_card_subscription_added_time_unx,$health_card_subscription_status,$ua_address_pincode,$ua_land_mark,$ua_address,$ua__address,$ua_latitude,$ua_longitude;
    
    public $isOpen = 0;
    use WithPagination;
    use WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';
    // 
    public $search = '';
    public $sortBy = 'name';
    public $sortDirection = 'asc';

    #[Layout('livewire.admin.layouts.base')]   

    public function render()
    {
        // $consumer_status = $this->consumer_status ? $this->consumer_status : null;
        $healthCardVerificationStatus = $this->healthCardVerificationStatus ? $this->healthCardVerificationStatus : null;
        $fromDate = $this->selectedFromDate ? strtotime($this->selectedFromDate): null;
        $toDate = $this->selectedToDate ? strtotime( $this->selectedToDate) : null;

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

           switch ($this->selectedDate) {
                case 'today':
                $from_date = strtotime(date('Y-m-d'));
                $to_date = strtotime(date('Y-m-d').' 23:59:59');
                break;
            case 'yesterday':
                $from_date = strtotime('-1 day', strtotime(date('Y-m-d')));
                $to_date = strtotime('-1 day', strtotime(date('Y-m-d').' 23:59:59'));
                break;
            case 'week':
                $from_date = strtotime('-7 days', strtotime(date('Y-m-d')));
                $to_date = strtotime(date('Y-m-d').' 23:59:59');
                break;
            case 'month':
                $from_date = strtotime(date('Y-m-01'));
                $to_date = strtotime(date('Y-m-t').' 23:59:59');
                break;
            default:
                // Handle other cases if needed
                break;
        }
       
        
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


        if($this->check_for == 'custom'){
            return view('livewire.admin.health-card.health-card-component',[
                'isCustom' => true
            ],compact('healthcardData'));
        }
        return view('livewire.admin.health-card.health-card-component',[
            'isCustom' => false
        ],compact('healthcardData'));

    }

    public function openModal()
    {
        $this->isOpen = true;
    }
    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function createHealthCard()
    {
        $this->openModal();
    }
    public function addorUpdateHelathCard(){

        $validatedData = $this->validate([
            'language_partner_page_name_sku' => 'required',
            'language_partner_page_name_txt' => 'required',
        ], [
             'language_partner_page_name_sku.required' => 'Please Add The Partner Page Sku Name',
             'language_partner_page_name_txt.required' => 'Please Add The Partner Page Text Data',
         ]);

         try {
            DB::beginTransaction();
        
            $data = [
                'language_partner_page_name_sku' => $this->language_partner_page_name_sku,
                'language_partner_page_name_txt' => $this->language_partner_page_name_txt,
            ];
        
            if ($this->language_partner_page_id) {
        
                DB::table('language_partner_page')->where('language_partner_page_id', $this->language_partner_page_id)->update($data);
                session()->flash('activeMessage', 'Partner Language Page Sku updated successfully !!' . $this->language_partner_page_id);
            } else {

                $data['language_partner_page_status'] = 0; // Add 'added_date' only when inserting
                $insertGetId = DB::table('language_partner_page')->insertGetId($data);
                session()->flash('activeMessage', 'Partner Language Page Sku successfully added !!'.$insertGetId);
            }
        
            DB::commit();
            $this->closeModal();

        } catch (\Exception $e) {
            session()->flash('inactiveMessage', 'Something went wrong with the Partner Language Page Sku operation: ' . $e->getMessage());
            DB::rollback();
            \Log::error('Error occurred while processing Partner Language Page Sku operation: ' . $e->getMessage());
        }
    }


}
