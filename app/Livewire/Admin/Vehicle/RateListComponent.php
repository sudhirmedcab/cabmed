<?php

namespace App\Livewire\Admin\Vehicle;
use Illuminate\Support\Facades\DB; 
use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Livewire\WithFileUploads;


class RateListComponent extends Component
{
    public $selectedDate,$filterConditionl, 
    $selectedFromDate,$selectedToDate, $fromDate=null, 
    $toDate=null,$fromdate, $todate, $partner_profile_img, $state=[],
    $position, $cityCount, $driver_status=null, $ambulance_category_icon,$categoryId=null,$check_for,
    $activeTab,$ambulanceCatList=[],$ambulance_support_specialists_id,
    $ambulance_category_type,
    $ambulance_support_specialists_name,
    $ambulance_support_specialists_image_circle,
    $ambulance_support_specialists_image_squire,
    $ambulance_support_specialists_category_name,
    $ambulance_support_specialists_description,
    $ambulance_support_specialists_amount,
    $bookingState,$vehicleCreated,
    $categoryVerificationStatus;
    public $tags=[];

    public $isOpen = 0;
    use WithPagination;
    use WithoutUrlPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    // 
    public $search = '';
    public $sortBy = 'name';
    public $sortDirection = 'asc';
     public $age = '30';
    public $address = 'Lucknow';

    public $ambulance_facilities_category_type = [];
    public $ambulance_facilities_image;
    public $ambulance_facilities_name;
    public $ambulance_facilities_id;

    public array $locationUsers = [];
    protected $listeners = ['locationUsersSelected'];

    public function locationUsersSelected($locationUsersValues)
    {
    $this->locationUsers = $locationUsersValues;
    }
    
        #[Layout('livewire.admin.layouts.base')] 
        
  public function resetFilters(){

         $this->ambulance_category_status=null;
         $this->categoryId=null;
         $this->selectedDate=null;
         $this->search ='';
         $this->categoryId="AllCategory";

            }

            public function filterCondition($value){
                $this->resetFilters();

                if($value=='facilityData'){
                    $this->activeTab=$value;
                }
                if($value=='ambulanceAddOnce'){
                    $this->activeTab=$value;
                }
             
          }

          public function mount()
          {
              $this->ambulanceCatList = $this->ambulanceCategoryList();
  
          }

    public function render()
    {
          $categoryVerificationStatus = $this->categoryVerificationStatus ? $this->categoryVerificationStatus : null;
          $categoryId = $this->categoryId ? $this->categoryId : null;
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

          if($this->activeTab=='facilityData'){

                $ambulanceFacility = DB::table('ambulance_facilities')
                                ->leftjoin('ambulance_category','ambulance_category.ambulance_category_type','=','ambulance_facilities.ambulance_facilities_category_type')
                                  ->where(function ($query) {
                                    $query->where('ambulance_facilities.ambulance_facilities_name', 'like', '%' . $this->search . '%')
                                        ->orWhere('ambulance_facilities.ambulance_facilities_category_type', 'like', '%' . $this->search . '%');
                                    })
                                    ->when($categoryId !=="AllCategory", function ($query) use ($categoryId){
                                        return $query->where('ambulance_category.ambulance_category_id',$categoryId);
                                    })
                                    ->when($categoryVerificationStatus !==null && $categoryVerificationStatus == 'AllCategory', function ($query) use ($categoryVerificationStatus){
                                        return $query->whereIn('ambulance_facilities.ambulance_facilities_state',[1,0]);
                                    })
                                    ->when($categoryVerificationStatus !==null && $categoryVerificationStatus == 'InactiveCategory', function ($query) use ($categoryVerificationStatus){
                                        return $query->where('ambulance_facilities.ambulance_facilities_state',1);
                                    })
                                    ->when($categoryVerificationStatus !==null && $categoryVerificationStatus == 'ActiveCategory', function ($query) use ($categoryVerificationStatus){
                                        return $query->where('ambulance_facilities.ambulance_facilities_state',0);
                                    })
                                   ->paginate(10);

                 $ambulanceCategoryData = DB::table('ambulance_category')
                 ->where('ambulance_category_status',0)->get();

                                   
         return view('livewire.admin.vehicle.rate-list-component',[
                         'isCustom' => true
       ],compact('ambulanceFacility','ambulanceCategoryData'));
    
          }elseif($this->activeTab=='ambulanceAddOnce'){

            $ambulanceAddOnce = DB::table('ambulance_support_specialists')
            ->leftjoin('ambulance_category','ambulance_category.ambulance_category_type','=','ambulance_support_specialists.ambulance_support_specialists_category_name')
              ->where(function ($query) {
                $query->where('ambulance_support_specialists.ambulance_support_specialists_category_name', 'like', '%' . $this->search . '%')
                    ->orWhere('ambulance_support_specialists.ambulance_support_specialists_name', 'like', '%' . $this->search . '%');
                })
                ->when($categoryId !=="AllCategory", function ($query) use ($categoryId){
                    return $query->where('ambulance_category.ambulance_category_id',$categoryId);
                })
                ->when($categoryVerificationStatus !==null && $categoryVerificationStatus == 'AllCategory', function ($query) use ($categoryVerificationStatus){
                    return $query->whereIn('ambulance_support_specialists.ambulance_support_specialists_status',[51,50]);
                })
                ->when($categoryVerificationStatus !==null && $categoryVerificationStatus == 'InactiveCategory', function ($query) use ($categoryVerificationStatus){
                    return $query->where('ambulance_support_specialists.ambulance_support_specialists_status',51);
                })
                ->when($categoryVerificationStatus !==null && $categoryVerificationStatus == 'ActiveCategory', function ($query) use ($categoryVerificationStatus){
                    return $query->where('ambulance_support_specialists.ambulance_support_specialists_status',50);
                })
               ->paginate(10);

               $ambulanceCategoryData = DB::table('ambulance_category')
               ->where('ambulance_category_status',0)->get();

            return view('livewire.admin.vehicle.rate-list-component',[
                                    'isCustom' => true
                ],compact('ambulanceAddOnce','ambulanceCategoryData'));

          }
         
          $ambulanceData = DB::table('ambulance_category')
          ->leftjoin('state','state.state_id','ambulance_category.ambulance_category_state_id')
          ->where(function ($query) {
            $query->where('ambulance_category.ambulance_category_type', 'like', '%' . $this->search . '%')
                ->orWhere('ambulance_category.ambulance_category_name', 'like', '%' . $this->search . '%');
        })
          ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
            return $query->whereBetween('ambulance_category.ambulance_category_added_date', [$fromDate, $toDate]);
        })
        ->when($categoryVerificationStatus !==null && $categoryVerificationStatus == 'AllCategory', function ($query) use ($categoryVerificationStatus){
            return $query->whereIn('ambulance_category.ambulance_category_status',[1,0]);
        })
        ->when($categoryVerificationStatus !==null && $categoryVerificationStatus == 'InactiveCategory', function ($query) use ($categoryVerificationStatus){
            return $query->where('ambulance_category.ambulance_category_status',1);
        })
        ->when($categoryVerificationStatus !==null && $categoryVerificationStatus == 'ActiveCategory', function ($query) use ($categoryVerificationStatus){
            return $query->where('ambulance_category.ambulance_category_status',0);
        })
          ->orderBy('ambulance_category.ambulance_category_id', 'desc')
          ->paginate(10);

      if($this->check_for == 'custom'){
        return view('livewire.admin.vehicle.rate-list-component',[
            'isCustom' => true
        ],compact('ambulanceData'));
    }
    return view('livewire.admin.vehicle.rate-list-component',[
        'isCustom' => false
    ],compact('ambulanceData'));

    }

    public function createFacility()
    {
        $this->resetInputFields();
        $this->openModal();
    }
    public function createCategory()
    {
        $this->resetInputFields();
        $this->openModal();
    }
    private function resetInputFields(){
        $this->name = '';
        $this->employee_id = '';
        $this->position = '';
        $this->email = '';

    }
    public function openModal()
    {
        $this->isOpen = true;
    }
    public function closeModal()
    {
        $this->isOpen = false;
    }
    public function deleteCategoryData($ambulanceCategoryId)
    {
        $categoryData = DB::table('ambulance_category')->where('ambulance_category_id',$ambulanceCategoryId)->first();
        
        $categoryStatus = $categoryData->ambulance_category_status;

        if($categoryStatus == '0'){

            $categoryDelete = DB::table('ambulance_category')->where('ambulance_category_id',$ambulanceCategoryId)->update(['ambulance_category_status'=>'1']);
            session()->flash('inactiveMessage', 'Ambulance Category Inactive Successfully.');

        }elseif($categoryStatus =='1'){

            $categoryDelete = DB::table('ambulance_category')->where('ambulance_category_id',$ambulanceCategoryId)->update(['ambulance_category_status'=>'0']);
            session()->flash('activeMessage', 'Ambulance Category Activated Successfully.');
    }

    }
    public function deleteFacilityData($ambulanceFacilityId)
    {
        $categoryData = DB::table('ambulance_facilities')->where('ambulance_facilities_id',$ambulanceFacilityId)->first();
        
        $categoryStatus = $categoryData->ambulance_facilities_state;

        if($categoryStatus == '0'){

            $categoryDelete = DB::table('ambulance_facilities')->where('ambulance_facilities_id',$ambulanceFacilityId)->update(['ambulance_facilities_state'=>'1']);
            session()->flash('inactiveMessage', 'Ambulance Facility Inactive Successfully.');

        }elseif($categoryStatus =='1'){

            $categoryDelete = DB::table('ambulance_facilities')->where('ambulance_facilities_id',$ambulanceFacilityId)->update(['ambulance_facilities_state'=>'0']);
            session()->flash('activeMessage', 'Ambulance Facility Activated Successfully.');
    }

    }
    public function deleteSpecialData($ambulanceSpecialistId)
    {
        $categoryData = DB::table('ambulance_support_specialists')->where('ambulance_support_specialists_id',$ambulanceSpecialistId)->first();
        
        $categoryStatus = $categoryData->ambulance_support_specialists_status;

        if($categoryStatus == '50'){

            $categoryDelete = DB::table('ambulance_support_specialists')->where('ambulance_support_specialists_id',$ambulanceSpecialistId)->update(['ambulance_support_specialists_status'=>'51']);
            session()->flash('inactiveMessage', 'Ambulance Facility Inactive Successfully.');

        }elseif($categoryStatus =='51'){

            $categoryDelete = DB::table('ambulance_support_specialists')->where('ambulance_support_specialists_id',$ambulanceSpecialistId)->update(['ambulance_support_specialists_status'=>'50']);
            session()->flash('activeMessage', 'Ambulance Facility Activated Successfully.');
    }

    }

    public function ambulanceCategoryList(){
        $ambulanceCategory = DB::table('ambulance_category')
            ->orderByDesc('ambulance_category.ambulance_category_id')
            ->get();
            return $ambulanceCategory;
    }

    
    public function storeFacility(){

        $validatedData = $this->validate([
            'ambulance_facilities_category_type' => 'required|array',
            'ambulance_facilities_image' => 'required|image|mimes:jpeg,png,jpg',
            'ambulance_facilities_name' => 'required',
        ], [
             'ambulance_facilities_category_type.required' => 'Please Add The Ambulance Category Type',
             'ambulance_facilities_image.required' => 'Please Add The Ambulance Category Icon',
             'ambulance_facilities_image.mimes' => 'Type must be : jpeg, png, jpg.',
             'ambulance_facilities_name.required' => 'Please Select facility Name'
         ]);  
    
        try {
           DB::beginTransaction();
            
           if($this->ambulance_facilities_id){
                // Update existing record
                if($this->ambulance_facilities_image){
                    $ambulance_facilities_imgFilename = $this->ambulance_facilities_image->getClientOriginalName();
                    $ambulance_facilities_imgFilename = strtolower($ambulance_facilities_imgFilename);
                    $ambulance_facilities_imgFilename = str_replace(' ', '-', $ambulance_facilities_imgFilename);
                    $this->ambulance_facilities_image->storeAs('facilities', $ambulance_facilities_imgFilename);
                } else {
                    $ambulance_facilities_imgFilename=null;
                } 
                DB::table('ambulance_facilities')->where('ambulance_facilities_id', $this->ambulance_facilities_id )->update([
                   'ambulance_facilities_name' => $this->ambulance_facilities_name,
                   'ambulance_facilities_category_type' => implode(", ", $this->ambulance_facilities_category_type),
                   'ambulance_facilities_image' => $ambulance_facilities_imgFilename ? 'assets/facilities/'.$ambulance_facilities_imgFilename : '',
                   'ambulance_facilities_updated_time' => now()->timestamp,
                ]);
                session()->flash('activeMessage', 'Ambulance Facility updated successfully !!'.$this->ambulance_facilities_id);
           } else {
                // Insert new records
                foreach ($validatedData['ambulance_facilities_category_type'] as $category) {
                    if($this->ambulance_facilities_image){
                        $ambulance_facilities_imgFilename = $this->ambulance_facilities_image->getClientOriginalName();
                        $ambulance_facilities_imgFilename = strtolower($ambulance_facilities_imgFilename);
                        $ambulance_facilities_imgFilename = str_replace(' ', '-', $ambulance_facilities_imgFilename);
                        $this->ambulance_facilities_image->storeAs('facilities', $ambulance_facilities_imgFilename);
                    }
                    $insertData = [
                        'ambulance_facilities_name' => $this->ambulance_facilities_name,
                        'ambulance_facilities_category_type' => $category,
                        'ambulance_facilities_image' => $ambulance_facilities_imgFilename ? 'assets/facilities/'.$ambulance_facilities_imgFilename : '',
                        'ambulance_facilities_state' => 0,
                        'ambulance_facilities_updated_time' => now()->timestamp,
                        'ambulance_facilities_created_time' => now()->timestamp
                    ];
                    $insertGetId = DB::table('ambulance_facilities')->insertGetId($insertData);
                }
                session()->flash('activeMessage', 'Ambulance Facility successfully added !!'.$insertGetId);
           }
           DB::commit();
        } catch (\Exception $e) {
            session()->flash('inactiveMessage', 'Ambulance Facility something went wrong!!'.$e->getMessage());
            DB::rollback();
            \Log::error('Error occurred while processing step5Form: ' . $e->getMessage());
        }
    }
    
    public function editFacility($ambulance_facilities_id)
    {
        $ambulanceFacility = DB::table('ambulance_facilities')->where('ambulance_facilities_id',$ambulance_facilities_id)->first();

        $this->ambulance_facilities_id = $ambulanceFacility->ambulance_facilities_id;
        $this->ambulance_facilities_name = $ambulanceFacility->ambulance_facilities_name;
        $this->ambulance_facilities_image = $ambulanceFacility->ambulance_facilities_image;
        $this->ambulance_facilities_category_type = $ambulanceFacility->ambulance_facilities_category_type;

        $this->openModal();
    }

    public function storeSupportData(){

        $validatedData = $this->validate([
            'ambulance_support_specialists_category_name' => 'required|array',
            'ambulance_support_specialists_name' => 'required',
            'ambulance_support_specialists_image_squire' => 'required|image|mimes:jpeg,png,jpg',
            'ambulance_support_specialists_image_circle' => 'required|image|mimes:jpeg,png,jpg',
            'ambulance_support_specialists_description' => 'required',
            'ambulance_support_specialists_amount' => 'required|numeric',
        ], [
             'ambulance_support_specialists_category_name.required' => 'Please Add The Ambulance Category Type',
             'ambulance_support_specialists_name.required' => 'Please Add The Support Facility Specialist',
             'ambulance_support_specialists_image_circle.required' => 'Please Add The Category Icon Circle Image',
             'ambulance_support_specialists_image_circle.mimes' => 'Type must be : jpeg, png, jpg.',
             'ambulance_support_specialists_image_squire.required' => 'Please Add The Category Icon Squire Image',
             'ambulance_support_specialists_image_squire.mimes' => 'Type must be : jpeg, png, jpg.',
             'ambulance_support_specialists_description.required' => 'Please Add The Support Dscription Details Data',
             'ambulance_support_specialists_amount.required' => 'Please Add The Support Specialist Charge Amount',
             'ambulance_support_specialists_amount.numeric' => 'The Support Specialist Should be Number'
         ]);  
    
        try {
           DB::beginTransaction();
            
           if($this->ambulance_support_specialists_id){
                // Update existing record
                if($this->ambulance_support_specialists_image_circle){
                    $ambulance_support_circle_imgFilename = $this->ambulance_support_specialists_image_circle->getClientOriginalName();
                    $ambulance_support_circle_imgFilename = strtolower($ambulance_support_circle_imgFilename);
                    $ambulance_support_circle_imgFilename = str_replace(' ', '-', $ambulance_support_circle_imgFilename);
                    $this->ambulance_support_specialists_image_circle->storeAs('specilist_icon', $ambulance_support_circle_imgFilename);
                } else {
                    $ambulance_support_circle_imgFilename=null;
                } 

                if($this->ambulance_support_specialists_image_squire){
                    $ambulance_support_squire_imgFilename = $this->ambulance_support_specialists_image_circle->getClientOriginalName();
                    $ambulance_support_squire_imgFilename = strtolower($ambulance_support_squire_imgFilename);
                    $ambulance_support_squire_imgFilename = str_replace(' ', '-', $ambulance_support_squire_imgFilename);
                    $this->ambulance_support_specialists_image_squire->storeAs('specilist_icon', $ambulance_support_squire_imgFilename);
                } else {
                    $ambulance_support_squire_imgFilename=null;
                } 
                DB::table('ambulance_support_specialists')->where('ambulance_support_specialists_id', $this->ambulance_support_specialists_id )->update([
                   'ambulance_support_specialists_name' => $this->ambulance_support_specialists_name,
                   'ambulance_support_specialists_amount' => $this->ambulance_support_specialists_amount,
                   'ambulance_support_specialists_category_name' => implode(", ", $this->ambulance_support_specialists_category_name),
                   'ambulance_support_specialists_image_circle' => $ambulance_support_circle_imgFilename ? 'assets/specilist_icon/'.$ambulance_support_circle_imgFilename : '',
                   'ambulance_support_specialists_image_squire' => $ambulance_support_squire_imgFilename ? 'assets/specilist_icon/'.$ambulance_support_squire_imgFilename : '',
                   'ambulance_support_specialists_description' => $this->ambulance_support_specialists_description,

                ]);
                session()->flash('activeMessage', 'Ambulance Support Facility updated successfully !!'.$this->ambulance_support_specialists_id);
           } else {
                // Insert new records
                foreach ($validatedData['ambulance_support_specialists_category_name'] as $category) {
                    if($this->ambulance_support_specialists_image_circle){
                        $ambulance_support_circle_imgFilename = $this->ambulance_support_specialists_image_circle->getClientOriginalName();
                        $ambulance_support_circle_imgFilename = strtolower($ambulance_support_circle_imgFilename);
                        $ambulance_support_circle_imgFilename = str_replace(' ', '-', $ambulance_support_circle_imgFilename);
                        $this->ambulance_support_specialists_image_circle->storeAs('specilist_icon', $ambulance_support_circle_imgFilename);
                    }
                    if($this->ambulance_support_specialists_image_squire){
                        $ambulance_support_squire_imgFilename = $this->ambulance_support_specialists_image_circle->getClientOriginalName();
                        $ambulance_support_squire_imgFilename = strtolower($ambulance_support_squire_imgFilename);
                        $ambulance_support_squire_imgFilename = str_replace(' ', '-', $ambulance_support_squire_imgFilename);
                        $this->ambulance_support_specialists_image_squire->storeAs('specilist_icon', $ambulance_support_squire_imgFilename);
                    }

                    $insertData = [
                        'ambulance_support_specialists_name' => $this->ambulance_support_specialists_name,
                        'ambulance_support_specialists_category_name' => $category,
                        'ambulance_support_specialists_amount' => $this->ambulance_support_specialists_amount,
                        'ambulance_support_specialists_image_circle' => $ambulance_support_circle_imgFilename ? 'assets/specilist_icon/'.$ambulance_support_circle_imgFilename : '',
                        'ambulance_support_specialists_image_squire' => $ambulance_support_squire_imgFilename ? 'assets/specilist_icon/'.$ambulance_support_squire_imgFilename : '',
                        'ambulance_support_specialists_description' => $this->ambulance_support_specialists_description,
                    ];
                    $insertGetId = DB::table('ambulance_support_specialists')->insertGetId($insertData);
                }
                session()->flash('activeMessage', 'Ambulance Support Facility successfully added !!'.$insertGetId);
           }
           DB::commit();
        } catch (\Exception $e) {
            session()->flash('inactiveMessage', 'Ambulance Support Facility something went wrong!!'.$e->getMessage());
            DB::rollback();
            \Log::error('Error occurred while processing step5Form: ' . $e->getMessage());
        }
    }

    public function editSupportFacility($ambulance_support_specialists_id)
    {
        $ambulanceSupportFacility = DB::table('ambulance_support_specialists')->where('ambulance_support_specialists_id',$ambulance_support_specialists_id)->first();

        $this->ambulance_support_specialists_id = $ambulanceSupportFacility->ambulance_support_specialists_id;
        $this->ambulance_support_specialists_name = $ambulanceSupportFacility->ambulance_support_specialists_name;
        $this->ambulance_support_specialists_category_name = $ambulanceSupportFacility->ambulance_support_specialists_category_name;
        $this->ambulance_support_specialists_image_circle = $ambulanceSupportFacility->ambulance_support_specialists_image_circle;
        $this->ambulance_support_specialists_image_squire = $ambulanceSupportFacility->ambulance_support_specialists_image_squire;
        $this->ambulance_support_specialists_description = $ambulanceSupportFacility->ambulance_support_specialists_description;
        $this->ambulance_support_specialists_amount = $ambulanceSupportFacility->ambulance_support_specialists_amount;

        $this->openModal();
    }
}
