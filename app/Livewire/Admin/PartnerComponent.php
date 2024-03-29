<?php

namespace App\Livewire\Admin;
use Illuminate\Support\Facades\DB; 
use Illuminate\Validation\Rule;
use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class PartnerComponent extends Component
{
    public $partner_id, $partner_f_name, $partner_l_name, $partner_mobile, $partner_dob ,$partner_gender,$partner_city_id,$partner_aadhar_no,$partner_referral ,$referral_referral_by,$partner_aadhar_back,$partner_aadhar_front,$partner_profile_img,$employees0,$selectedDate,$filterConditionl, 
    $selectedFromDate,$selectedToDate, $fromDate=null, 
    $toDate=null,$fromdate, $todate, $id, $name, $email,
    $position, $employee_id, $partner_status=null,$partnerVerificationStatus,$check_for,
    
    $activeTab;
    
    public $isOpen = 0;
    use WithoutUrlPagination;
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    // 
    public $search = '';
    public $sortBy = 'name';
    public $sortDirection = 'asc';

    #[Layout('livewire.admin.layouts.base')]    //......... add the layout dynamically for the all ...........//


    public function activeDriver($value){

    if($value=='Active'){
        // $this->activeDriver = 1;
        $this->activeTab=$value;
        $this->partner_status=1;
    }
    if($value=='New'){
        // $this->activeDriver = 1;
    $this->partner_status=0;
    $this->activeTab=$value;
    }
    if($value=='All'){
    // $this->activeDriver = 1;
    $this->partner_status=null;
    $this->activeTab=$value;
    }

    }
            public function resetFilters(){
          
                $this->partner_status=null;
                $this->selectedDate=null;
                $this->search ='';
            }

            public function filterCondition($value){

                $this->resetFilters();
                
                    if($value=='Active'){
            
                    $this->activeTab=$value;
                    $this->partner_status='1';
                }
            
                if($value=='New'){
                    // $this->activeDriver = 1;
                    $this->partner_status='0';
                    $this->activeTab=$value;
                }
                if($value=='All'){
                    // $this->activeDriver = 1;
                    $this->partner_status = 'null';
                    $this->activeTab=$value;
                }
          
    
        }
 
    public function render()
    {

        $currentTimestamps = Carbon::now();
        $firstDayOfMonths = Carbon::now()->startOfMonth(); 
 
        $partner_status = $this->partner_status ? $this->partner_status : null;

        $partnerVerificationStatus = $this->partnerVerificationStatus ? $this->partnerVerificationStatus : null;
        $fromDate = $this->selectedFromDate ? Carbon::createFromFormat('Y-m-d', $this->selectedFromDate)->startOfDay() : null;
        $toDate = $this->selectedToDate ? Carbon::createFromFormat('Y-m-d', $this->selectedToDate)->endOfDay() : null;

        // if($this->selectedFromDate && $this->selectedToDate){
        //     $this->selectedDate = null;     
        // } ............ 
        
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
       
        // ...
       
        $partners = DB::table('partner')
        ->leftJoin('city', 'partner.partner_city_id', '=', 'city.city_id')
        ->leftJoin('state', 'city.city_state', '=', 'state.state_id')
        ->leftJoin('remark_data', 'partner.partner_id', '=', 'remark_data.remark_partner_id')
        ->leftJoin('admin', 'admin.id', '=', 'remark_data.remark_type')
        ->where(function ($query) {
            $query->where('partner.partner_f_name', 'like', '%' . $this->search . '%')
                ->orWhere('partner.partner_l_name', 'like', '%' . $this->search . '%');
        })
        ->orderBy('partner.partner_id', 'desc')
        ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
            return $query->whereBetween('partner.created_at', [$fromDate, $toDate]);
        })
         ->when($partnerVerificationStatus == 'AllVerification', function ($query) use ($partnerVerificationStatus) {
            return $query
                ->whereIn('partner.partner_status', [1,0]);
        })
        ->when($partnerVerificationStatus == 'NewVerification', function ($query) use ($partnerVerificationStatus) {
            return $query
                ->where('partner.partner_status', 0);
        })
        ->when($partnerVerificationStatus == 'ActiveVerification', function ($query) use ($partnerVerificationStatus) {
            return $query
                ->where('partner.partner_status', 1);
        })
        ->when($partnerVerificationStatus == 'InactiveVerification', function ($query) use ($partnerVerificationStatus) {
            return $query
                ->where('partner.partner_status', 2);
        })
        ->select(
            'partner.partner_id',
            'partner.partner_f_name',
            'partner.partner_l_name',
            'partner.partner_mobile',
            'partner.partner_wallet',
            'partner.partner_status',
            'admin.admin_name',
            'state.state_name',
            'city.city_name',
            'partner.created_at',
            'remark_data.remark_id',
            'remark_data.remark_partner_id',
            'remark_data.remark_text'
        )
        ->paginate(10); // Use paginate(10) after setting all conditions and selections on the query
       
        $data = [];
    
        $buckethlist = [];
                foreach( $partners as $hkey){
                    $datas['partner_id'] = $partner_id  = $hkey->partner_id; 
                    $datas['partner_f_name'] = $hkey->partner_f_name; 
                    $datas['partner_l_name'] = $hkey->partner_l_name; 
                    $datas['partner_mobile'] = $hkey->partner_mobile; 
                    $datas['partner_wallet'] = $hkey->partner_wallet; 
                    $datas['partner_status'] = $hkey->partner_status; 
                    $datas['state_name'] = $hkey->state_name; 
                    $datas['city_name'] = $hkey->city_name; 
                    $datas['created_at'] = $hkey->created_at; 
                    $datas['remark_id'] = $hkey->remark_id; 
                    $datas['remark_partner_id'] = $hkey->remark_partner_id; 
                    $datas['remark_text'] = $hkey->remark_text; 
                    $datas['admin_name'] = $hkey->admin_name; 

                
                    $active_driver_count = DB::table('driver')
                    ->where('driver_created_partner_id',$partner_id)->where('driver_status','=','1')->get();
                    $datas['active_driver_count'] = count($active_driver_count);

                    $pending_driver_count = DB::table('driver')
                    ->where('driver_created_partner_id',$partner_id)->where('driver_status','=','4')->get();
                    $datas['pending_driver_count'] = count($pending_driver_count);

                    $new_driver_count = DB::table('driver')
                    ->where('driver_created_partner_id',$partner_id)->where('driver_status','=','0')->get();
                    $datas['new_driver_count'] = count($new_driver_count);

                $datas['total_driver'] = count($new_driver_count) + count($pending_driver_count) +count($active_driver_count);

                    $active_vehicle_count = DB::table('vehicle')
                    ->where('vehicle_added_by',$partner_id)
                    ->where('vehicle_status','=','1')
                    ->where('vehicle_added_type','=','1')->get();
                    $datas['active_vehicle_count'] = count($active_vehicle_count);

                    $pending_vehicle_count = DB::table('vehicle')
                    ->where('vehicle_added_by',$partner_id)
                    ->where('vehicle_status','=','4')
                    ->where('vehicle_added_type','=','1')->get();
                    $datas['pending_vehicle_count'] = count($pending_vehicle_count);

                    $new_vehicle_count = DB::table('vehicle')
                    ->where('vehicle_added_by',$partner_id)
                    ->where('vehicle_status','=','0')
                    ->where('vehicle_added_type','=','1')->get();
                    $datas['new_vehicle_count'] = count($new_vehicle_count);

                    $datas['total_vehicle'] = count($new_vehicle_count) + count($pending_vehicle_count) +count($active_vehicle_count);

        
                    array_push($buckethlist, $datas);
                }

                $data['partner']  = $buckethlist; 

                if($this->check_for == 'custom'){
                    return view('livewire.admin.partner-component',[
                        'data' => $data,
                        'isCustom' => true
                    ],compact('partners'));
                }
                return view('livewire.admin.partner-component',[
                    'data' => $data,
                    'isCustom' => false
                ],compact('partners'));

    }
    
    public function create()
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
    public function storepartner()
    {
            $validatedData = $this->validate([
                'partner_f_name' => 'required',
                'partner_l_name' => 'required',
                'partner_profile_img' => 'required|max:2048',
                'partner_aadhar_front' => 'required|max:2048',
                'partner_aadhar_back' => 'required|max:2048',
                'partner_mobile' => [
                    'required',
                    'numeric',
                    'digits:10',
                    Rule::unique('partner','partner_mobile')
                ],  
                'partner_dob' => 'required',
                'partner_gender' => 'required',
                'partner_city_id' => 'required',
                'partner_aadhar_no' => 'required|digits:12',
                'referral_referral_by'=>'required',
    
            ],
            [
                'partner_f_name.required' => 'First name required',
                'partner_l_name.required' => 'Last name required',
                'partner_mobile.unique' => 'Mobile Number Allready exist',
                'partner_mobile.required' => 'Mobile Number required',
                'partner_mobile.numeric' => 'Must be number',
                'partner_dob.required' => 'Date of birth required',
                'partner_aadhar_no.required' => 'Partner Adhar Number required',
                'referral_referral_by.required' => 'Partner Refferal required',
                'partner_gender.required' => 'Gender required',
                'partner_city_id.required' => 'City required',
                'partner_profile_img.required' => 'Profile Image requirerd',
                'partner_aadhar_front.required' => 'Adhar Font Image requirerd',
                'partner_aadhar_back.required' => 'Adhar Back Image requirerd',
            ]
          );

            $dateofBirth = (new Carbon($this->partner_dob))->format('d-F-Y');

            date_default_timezone_set('Asia/Kolkata'); //.........set default timezone

            $data = [
                'partner_f_name' => $validatedData['partner_f_name'],
                'partner_l_name' => $validatedData['partner_l_name'],
                'partner_mobile' => $validatedData['partner_mobile'],
                'partner_dob' => $dateofBirth,
                'partner_gender' => $validatedData['partner_gender'],
                'partner_city_id' => $validatedData['partner_city_id'],
                'partner_aadhar_no' => $validatedData['partner_aadhar_no'],
                'partner_status' => '0',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'referral_referral_by' => $validatedData['referral_referral_by'],
            ];

    
          // dd($data);
          try {
            DB::beginTransaction();
    
            if ($this->partner_id) {
                DB::table('partner')->where('partner_id', $this->partner_id)->update($data);
                session()->flash('message', 'Partner successfully updated !! partner Id is::' . $this->partner_id);
            } else {
                $insertedId = DB::table('partner')->insertGetId($data);
    
                if ($insertedId) {
                    // Store images
                    $partner_profile_imageFilename = $this->storeImage($this->partner_profile_img, $insertedId, 'partner_profile');
                    $partner_adharFont_imageFilename = $this->storeImage($this->partner_aadhar_front, $insertedId, 'partner_aadhar_front');
                    $partner_adharBack_imageFilename = $this->storeImage($this->partner_aadhar_back, $insertedId, 'partner_aadhar_back');
    
                    $data2 = [
                        'partner_profile_img' => $partner_profile_imageFilename,
                        'partner_aadhar_front' => $partner_adharFont_imageFilename,
                        'partner_aadhar_back' => $partner_adharBack_imageFilename,
                    ];
    
                    DB::table('partner')->where('partner_id', $insertedId)->update($data2);
    
                    $this->partnerDataStep1 = $data2;
                    $this->partner_id = $insertedId;
    
                    session()->flash('success','Partner Created Successfully..' . $insertedId);

                } else {
                    session()->flash('message', 'Something went wrong!!');
                }
            }
    
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('message', 'Error: ' . $e->getMessage());
            \Log::error('Error occurred while processing step1Form: ' . $e->getMessage());
        }
    
        }

     private function storeImage($image, $partnerId, $imageName)
   {

    $imageFilename = $partnerId . '_' . $imageName . '_' . time() . '.' . $image->getClientOriginalExtension();
    $image->storeAs('partner', $imageFilename);
    return 'assets/partner/' . $imageFilename;
   }

        
    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $this->id = $id;
        $this->employee_id = $employee->employee_id;
        $this->name = $employee->name;
        $this->email = $employee->email;
        $this->position = $employee->position;
        $this->openModal();
    }
    public function delete($id)
    {
        $partnerData = DB::table('partner')->where('partner_id',$id)->first();
        
        $partnerStatus = $partnerData->partner_status;

        if($partnerStatus == 0){
            $partnerDelete = DB::table('partner')->where('partner_id',$id)->update(['partner_status'=>'2']);
            session()->flash('message', 'Partner Deleted Successfully.');
            session()->flash('type', 'delete');
        }elseif($partnerStatus == 1){

            $partnerDelete = DB::table('partner')->where('partner_id',$id)->update(['partner_status'=>'2']);
            session()->flash('message', 'Partner Deleted Successfully.');
            session()->flash('type', 'delete');
        }elseif($partnerStatus == 2){

            $partnerDelete = DB::table('partner')->where('partner_id',$id)->update(['partner_status'=>'1']);
            session()->flash('message', 'Partner Activated Successfully.');
            session()->flash('type', 'delete');
    }

    }
}
