<?php

namespace App\Livewire\Admin\Pathology;

use Livewire\Component;
use Illuminate\Support\Facades\DB; 
use Carbon\Carbon;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class LabListComponent extends Component
{

public $selectedDate,$filterConditionl, 
$selectedFromDate,$selectedToDate, $fromDate=null, 
$toDate=null,$fromdate, $todate,$check_for,$labVerificationStatus,$cityId,$StateId,$remarkText,$hospitalId,$HospitalId,
$activeTab;

public $isOpen = 0;
use WithPagination;
use WithoutUrlPagination;
protected $paginationTheme = 'bootstrap';
// 
public $search = '';
public $sortBy = 'name';
public $sortDirection = 'asc';

    public function render()
    {        
        $labVerificationStatus = $this->labVerificationStatus ? $this->labVerificationStatus : null;

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

        $lablistData = DB::table('lab_owner')
        ->leftJoin('lab', 'lab.lab_owner_by', '=', 'lab_owner.lab_owner_id')
        ->leftJoin('city', 'city.city_id', '=', 'lab_owner.lab_owner_city_name')
        ->leftJoin('state', 'state.state_id', '=', 'city.city_state')
        ->whereNotNull('lab.lab_id')
        ->where(function ($query) {
            $query->where('lab_owner.lab_owner_name', 'like', '%' . $this->search . '%')
                ->orWhere('lab.lab_name', 'like', '%' . $this->search . '%');
        })  
          ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
            return $query->whereBetween('lab_owner.lab_owner_added_time', [$fromDate, $toDate]);
        })
        ->when($labVerificationStatus == 'AllVerification', function ($query) use ($labVerificationStatus){
            return $query->whereIn('lab_owner.lab_owner_status',[3,4,5,6]);
                })
         ->when($labVerificationStatus == 'ActiveVerification', function ($query) use ($labVerificationStatus){
            return $query->where('lab_owner.lab_owner_status',6);
                })
       ->when($labVerificationStatus == 'InactiveVerification', function ($query) use ($labVerificationStatus){
           return $query->where('lab_owner.lab_owner_status',5);
                 })
        ->when($labVerificationStatus == 'NewVerification', function ($query) use ($labVerificationStatus){
                  return $query->whereIn('lab_owner.lab_owner_status',[3,4]);
               })
        ->orderByDesc('lab_owner.lab_owner_id')
        ->paginate(10);

        if($this->check_for == 'custom'){
            return view('livewire.admin.pathology.lab-list-component',['isCustom'=>true],compact('lablistData'));
            }else {
               return view('livewire.admin.pathology.lab-list-component',['isCustom'=>false],compact('lablistData'));
           } 
    }

    public function deleteLabList($labId){

        $labOwnerData = DB::table('lab_owner')->where('lab_owner_id',$labId)->first();
        
        $ownerStatus = $labOwnerData->lab_owner_status;

        if($ownerStatus == '6'){

            $labOwnerDelete = DB::table('lab_owner')->where('lab_owner_id',$labId)->update(['lab_owner_status'=>'5']);

            session()->flash('inactiveMessage', 'Lab owner Inactive Successfully.');

        }elseif($ownerStatus =='5'){

            $labOwnerDelete = DB::table('lab_owner')->where('lab_owner_id',$labId)->update(['lab_owner_status'=>'6']);

            session()->flash('activeMessage', 'Lab owner Activated Successfully.');
    }

    }
}


