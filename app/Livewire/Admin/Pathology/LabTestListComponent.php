<?php

namespace App\Livewire\Admin\Pathology;
use Livewire\Component;
use Illuminate\Support\Facades\DB; 
use Carbon\Carbon;
use Livewire\WithPagination;
// use Livewire\WithoutUrlPagination;

class LabTestListComponent extends Component
{

public $selectedDate,$filterConditionl, 
$selectedFromDate,$selectedToDate, $fromDate=null, 
$toDate=null,$fromdate, $todate,$check_for,$labTestVerificationStatus,$cityId,$StateId,$remarkText,$hospitalId,$HospitalId,
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
        $labTestVerificationStatus = $this->labTestVerificationStatus ? $this->labTestVerificationStatus : "individualTest";
        
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

        $lab_test_data = DB::table('lab_test')
        ->select(
            'lab_test.lt_test_name',
            'lab_test.lab_test_id',
            'lab_test.lt_lab_test_type',
            'lab_test.lab_test_img',
            'lab_test.lt_lab_test_rating',
            'lab_test.lt_expire_in_month',
            'lab_test.lt_verify_status',
            'lab_test.lt_verify_by',
            'lab_test.created_at as createdAt',
            'admin.admin_name'
        )
        ->leftJoin('admin', 'admin.id', '=', 'lab_test.lt_verify_by')
            ->orderByDesc('lab_test.lab_test_id')
            ->where(function ($query) {
                $query->where('lab_test.lt_test_name', 'like', '%' . $this->search . '%');
            }) 
            ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                return $query->whereBetween('lab_test.created_at', [$fromDate, $toDate]);
            })
            ->when($labTestVerificationStatus == 'individualTest', function ($query) use ($labTestVerificationStatus){
                return $query->where('lab_test.lab_test_p_o_i',1);
                    })
             ->when($labTestVerificationStatus == 'packageTest', function ($query) use ($labTestVerificationStatus){
                return $query->where('lab_test.lab_test_p_o_i',2);
                    })
            ->paginate(10);

            $lab_test_prices = [];
    
            foreach ($lab_test_data as $key) {
                $test_id = $key->lab_test_id;
                
                $prices = DB::table('lab_test_prices')
                    ->where('ltp_test_id', $test_id)
                    ->where('ltp_status','0')
                    ->get();
        
                $lab_test_prices[$test_id] = $prices;
    
            }
    
            $lab_test_category = [];
        
            foreach ($lab_test_data as $key) {
                $test_id = $key->lab_test_id;
                
                $lab_test_category = [];
        
                foreach ($lab_test_data as $key) {
                    $test_id = $key->lab_test_id;
        
                    $category = DB::table('lab_test')
                        ->leftJoin('lab_test_category_mapper', 'lab_test_category_mapper.ltcm_test_id', '=', 'lab_test.lab_test_id')
                        ->leftJoin('lab_category', 'lab_category.lab_category_id', '=', 'lab_test_category_mapper.ltcm_category_id')
                          ->where('lab_test.lab_test_id', $test_id)
                          ->where('lab_test_category_mapper.ltcm_status','0')
                          ->get();
          
                  $lab_test_category[$test_id] = $category;
    
                }
    
            }
    
        if($this->check_for == 'custom'){
            return view('livewire.admin.pathology.lab-test-list-component',['isCustom'=>true],compact('lab_test_data', 'lab_test_prices','lab_test_category'));
            }else {
               return view('livewire.admin.pathology.lab-test-list-component',['isCustom'=>false],compact('lab_test_data', 'lab_test_prices','lab_test_category'));
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


