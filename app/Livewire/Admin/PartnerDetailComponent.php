<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\DB; 
use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class PartnerDetailComponent extends Component
{

    public $partnerId,$activeTab,$booking_status,$selectedDate,$filterConditionl, 
    $selectedFromDate,$selectedToDate, $fromDate=null, 
    $toDate=null,$fromdate, $todate;

    #[Layout('livewire.admin.layouts.base')]

    public function resetFilters(){
          
        $this->partner_status=null;
        $this->selectedDate=null;
    }

    public function filterCondition($value){

        $this->resetFilters();
        if($value=='partner_details'){            
            $this->activeTab=$value;
        }
    
        if($value=='driver'){
            $this->activeTab=$value;
        }
        if($value=='vehicle'){
            $this->activeTab=$value;
        }
    
        if($value=='transaction'){
            $this->activeTab=$value;
        }
        if($value=='assign'){
            $this->activeTab=$value;
        }
    
        if($value=='refferal'){
            $this->activeTab=$value;
        }
       
  
}
    public function render()
    {
            $basename = $this->partnerId;
            $decryptpartnerId = decrypt($basename);

            $partner_data=DB::table('partner')
                ->where('partner_id','=',$decryptpartnerId)
                ->first();

            if ($partner_data) {
                $partner_status = $partner_data->partner_status;
            
                        $partner = DB::table('partner')

                            ->where('partner_id', '=', $decryptpartnerId)
                            ->leftjoin('city', 'city.city_id', '=', 'partner.partner_city_id')
                            ->leftjoin('state', 'state.state_id', '=', 'city.city_state')
                            ->orderBy('partner_id', 'desc')
                            ->first();
    
                            $partner_referral_code = $partner->partner_referral;

                            $refferal_data = DB::table('partner')
                                ->where('referral_referral_by', 'LIKE', '%'.$partner_referral_code.'%')
                                ->get();

                              $buckets = []; 
                                            
                                foreach($refferal_data as $key)
                                {
                                    $datas['partner_id'] = $key->partner_id;
                                    $datas['partner_f_name'] = $key->partner_f_name;
                                    $datas['partner_l_name'] = $key->partner_l_name;
                                    $datas['partner_dob'] = $key->partner_dob;
                                    $datas['partner_mobile'] = $key->partner_mobile;
                                    $datas['partner_city_id'] = $key->partner_city_id;
                                    $datas['partner_gender'] = $key->partner_gender;
                                    $datas['partner_profile_img'] = $key->partner_profile_img;
                                    $datas['partner_referral'] = $key->partner_referral;
            
                                    array_push($buckets,$datas);
                                }
                             
                                $bucket = $buckets; // Assign the $buckets array to $bucket  
    
    
             return view('livewire.admin.partner-detail-component',compact('partner','bucket'));
        }

    }

 }

