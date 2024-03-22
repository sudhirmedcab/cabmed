<?php

namespace App\Livewire\Admin\Setting;
use Livewire\Component;
use Illuminate\Support\Facades\DB; 
use Carbon\Carbon;
use Livewire\WithPagination;
// use Livewire\WithoutUrlPagination;

class CustomerOtpComponent extends Component
{
    public $selectedDate,$filterConditionl, 
    $selectedFromDate,$selectedToDate, $fromDate=null, 
    $toDate=null,$fromdate, $todate,$check_for,$otpPlatfromSource,$cityId,$StateId,$remarkText,$hospitalId,$HospitalId,
    $activeTab;
    
    public $isOpen = 0;
    use WithPagination;
    // use WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';
    // 
    public $search = '';
    public $sortBy = 'name';
    public $sortDirection = 'asc';
    
        public function render()
        {        
            $otpPlatfromSource = $this->otpPlatfromSource ? $this->otpPlatfromSource : "ConsumerSource";
    
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

            $consumersOtp = DB::table('verification_otp')
            ->where(function ($query) {
                $query->where('verification_otp.vfn_consumer_mob_no', 'like', '%' . $this->search . '%');
            })
            ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                return $query->whereBetween('verification_otp.vfn_timestamp', [$fromDate, $toDate]);
            })
            ->when($otpPlatfromSource != 'AllSource', function ($query) use ($otpPlatfromSource) {
                return $query->when($otpPlatfromSource == 'ConsumerSource', function ($query) {
                    return $query->where('vfn_source', 'like', '%' . 'Consumer' . '%');
                })
                ->when($otpPlatfromSource == 'PartnerSource', function ($query) {
                    return $query->where('vfn_source', 'Partner App');
                })
                ->when($otpPlatfromSource == 'DriverSource', function ($query) {
                    return $query->where('vfn_source', 'like', '%' . 'Driver' . '%');
                })
                ->when($otpPlatfromSource == 'PathologySource', function ($query) {
                    return $query->where('vfn_source', 'like', '%' . 'Partner Website' . '%');
                })
                ->when($otpPlatfromSource == 'WebsiteSource', function ($query) {
                    return $query->where('vfn_source', 'WEBSITE');
                })
                ->when($otpPlatfromSource == 'CollectionBoySource', function ($query) {
                    return $query->where('vfn_source', 'like', '%' . 'Collection' . '%');
                });
            })
            ->orderByDesc('verification_otp.vfn_otp_id')
            ->paginate(10);
        
    
            if($this->check_for == 'custom'){
                return view('livewire.admin.setting.customer-otp-component',['isCustom'=>true],compact('consumersOtp'));
                }else {
                   return view('livewire.admin.setting.customer-otp-component',['isCustom'=>false],compact('consumersOtp'));
               } 
        }
    
       
    }
    

