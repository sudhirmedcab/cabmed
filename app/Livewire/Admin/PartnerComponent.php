<?php

namespace App\Livewire\Admin;
use Illuminate\Support\Facades\DB; 
use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;

class PartnerComponent extends Component
{
    public $partner_id, $partner_f_name, $partner_l_name, $partner_mobile, $partner_dob ,$partner_gender,$partner_city_id,$partner_aadhar_no,$partner_referral ,$referral_referral_by,$partner_aadhar_back,$partner_aadhar_front,$partner_profile_img, $active,$new,$show,$fromdate ,$todate,$dateOption,$from_filter,$to_filter,$date_filter;

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

    public function render()
    { 
        $currentTimestamps = Carbon::now();
        $firstDayOfMonths = Carbon::now()->startOfMonth();
    
        // Convert the input strings to Carbon date objects
        $fromdate = $this->fromdate ? Carbon::createFromFormat('Y-m-d', $this->fromdate)->startOfDay() : null;
        $todate = $this->todate ? Carbon::createFromFormat('Y-m-d', $this->todate)->endOfDay() : null;
        $dateOption = $this->dateOption;
    
        // Check if "All" option is selected
        if ($dateOption === 'all') {
            $fromdate = null;
            $todate = null;
        } elseif (!empty($dateOption)) {
            switch ($dateOption) {
                case 'today':
                    $fromdate = Carbon::today();
                    $todate = Carbon::today()->endOfDay();
                    break;
                case 'yesterday':
                    $fromdate = Carbon::yesterday();
                    $todate = Carbon::yesterday()->endOfDay();
                    break;
                case 'week':
                    $fromdate = Carbon::now()->subDays(7)->startOfDay();
                    $todate = Carbon::now();
                    break;
                case 'month':
                    $fromdate = Carbon::now()->startOfMonth();
                    $todate = Carbon::now()->endOfMonth();
                    break;
                default:
                    // Handle other cases if needed
                    break;
            }
        }
    
        $status = $this->show;
    
        $partners = DB::table('partner')
            ->leftJoin('city', 'partner.partner_city_id', '=', 'city.city_id')
            ->leftJoin('state', 'city.city_state', '=', 'state.state_id')
            ->leftJoin('remark_data', 'partner.partner_id', '=', 'remark_data.remark_partner_id')
            ->leftJoin('admin', 'admin.id', '=', 'remark_data.remark_type')
            ->where('partner.partner_f_name', 'like', '%' . $this->search . '%')
            ->orwhere('partner.partner_l_name', 'like', '%' . $this->search . '%')
            ->when($fromdate && $todate, function ($query) use ($fromdate, $todate) {
                return $query->whereBetween('partner.created_at', [$fromdate, $todate]);
            })
            ->when($status !== null, function ($query) use ($status) {
                return $query->where('partner.partner_status', $status);
            })
            ->when($status === null, function ($query) {
                return $query->whereIn('partner.partner_status', [1, 0]);
            })
            // ->where('partner.partner_name', 'like', '%' . $this->search . '%')
            ->orderBy('partner.partner_id', 'desc')
            ->where('partner.partner_status','<>','2')
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
            ->paginate(10); // Use get() instead of paginate(10) to retrieve all data at once
    
        $data = [];
    
        if ($fromdate && $todate) {
            $data['partner_filter'] = ($this->show == '1' ? 'Active' : ($this->show == '0' ? 'New' : 'All'))
                . ' Partner Data From ' . $fromdate->format('j F H:i:s A') . ' To ' . $todate->format('j F H:i:s A');
        } else {
            $data['partner_filter'] = 'All '.($this->show == '1' ? 'Active Partner' : ($this->show == '0' ? ' New Partner' : 'Partner')). ' Data From ';
        }
    
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

                $data['partners']  = $buckethlist; 

                $filterValue = $this->from_filter && $this->to_filter;
                $notfilterValue = $this->date_filter;
            
                return view('livewire.admin.partner-component', [
                    'data' => $data,
                    'filterValue' => $filterValue,
                    'notfilterValue' => $notfilterValue,
                ], compact('partners'));
              
     
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

        try{
            $this->validate([
                'partner_f_name' => 'required',
                'partner_l_name' => 'required',
                'partner_mobile' => [
                    'required',
                    'numeric',
                    'digits:10',
                    Rule::unique('partner','partner_mobile')
                ], 
                'partner_dob' => 'required',
                'partner_gender' => 'required',
                'partner_city_id' => 'required',
                'partner_aadhar_no' => 'required|min:12|numeric',
                'referral_referral_by'=>'required',
                'partner_profile_img' => 'required',
                'partner_aadhar_front' => 'required',
                'partner_aadhar_back' => 'required',
            ]);
    
            $dateofBirth = (new Carbon($this->partner_dob))->format('d-F-Y');
    
            $data = [
                'partner_f_name' => $this->partner_f_name,
                'partner_l_name' => $this->partner_l_name,
                'partner_mobile' => $this->partner_mobile,
                'partner_dob' => $dateofBirth,
                'partner_gender' => $this->partner_gender,
                'partner_city_id' => $this->partner_city_id,
                'partner_aadhar_no' => $this->partner_aadhar_no,
                'partner_status' => '0',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'referral_referral_by' => $this->referral_referral_by,
                // 'partner_profile_img' => $this->partner_profile_img->store(path: 'partner'),
                // 'partner_aadhar_front' => $this->partner_aadhar_front->storePublicly('partner', 'partner_aadhar_front'),
                // 'partner_aadhar_back' => $this->partner_aadhar_back->storePublicly('partner', 'partner_aadhar_back'),
            ];
    
            $savedata = DB::table('partner')->updateOrInsert(['partner_id' => $this->partner_id],$data);
            if($savedata){
                session()->flash('success', $this->partner_id ? 'Partner Updated Successfully.' : 'Partner Created Successfully.');
    
                $this->closeModal();
                $this->resetInputFields();       
            } else{
               session()->flash('danger', 'somethingwent wrong !!');
           }
        }catch (Exception $e) {
              
            $message = $e->getMessage();
            var_dump('Exception Message: '. $message);
        
            $code = $e->getCode();       
            var_dump('Exception Code: '. $code);
        
            $string = $e->__toString();       
            var_dump('Exception String: '. $string);
        
            exit;
        }
        
     

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
        $partnerDelete = DB::table('partner')->where('partner_id',$id)->update(['partner_status'=>'2']);

        session()->flash('message', 'Partner Deleted Successfully.');
        session()->flash('type', 'delete');
    }
    public function showNested($value)
    {
    $this->show = $value;

    }


}
