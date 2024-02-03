<?php

namespace App\Livewire\Admin\Ambulance;
use Illuminate\Support\Facades\DB; 
use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;

class AmbulanceBookingComponent extends Component
{
    public $show,$fromdate ,$todate,$dateOption,$from_filter,$to_filter,$date_filter;

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

        $data['bookingData'] = DB::table('booking_view')
        ->leftJoin('driver', 'driver.driver_id', '=', 'booking_view.booking_acpt_driver_id')
        ->leftJoin('remark_data', 'remark_data.remark_booking_id', '=', 'booking_view.booking_id')
        ->leftJoin('admin', 'admin.id', '=', 'remark_data.remark_type')
        ->where('booking_status', '!=', '7')
        ->where('booking_view.booking_con_name', 'like', '%' . $this->search . '%')
        ->when($fromdate && $todate, function ($query) use ($fromdate, $todate) {
            return $query->whereBetween('booking_view.created_at', [$fromdate, $todate]);
        }) 
        ->when($status !== null, function ($query) use ($status) {
            return $query->where('booking_view.booking_status', $status);
        })
        ->when($status === null, function ($query) {
            return $query->whereIn('booking_view.booking_status', [1, 0,2,3,4,5,6]);
        })
        ->select('booking_view.*','booking_view.created_at','remark_data.*' ,'admin.*','driver.driver_name','driver.driver_last_name','driver.driver_mobile')
        ->orderBy('booking_view.booking_id', 'desc')
        ->paginate(10);

        if ($fromdate && $todate) {
            $bookingStatus = $this->show;
        
            switch ($bookingStatus) {
              
                case "0":
                    $bookingName = "Enquiry";
                    break;
                case "1":
                    $bookingName = "New";
                    break;
                case "2":
                    $bookingName = "Ongoing";
                    break;
                case "3":
                    $bookingName = "Invoice";
                    break;
                case "4":
                    $bookingName = "Complete";
                    break;
                case "5":
                    $bookingName = "Cancel";
                    break;
                case "6":
                    $bookingName = "Future";
                    break;
                default:
                    $bookingName = "All Booking ";
            }
        
            $data['booking_filter'] = $bookingName . ' Booking From ' . $fromdate->format('j F H:i:s A') . ' To ' . $todate->format('j F H:i:s A'); 
        } else {
            $bookingStatus = $this->show;
        
            switch ($bookingStatus) {
              
                case "0":
                    $bookingName = "Enquiry";
                    break;
                case "1":
                    $bookingName = "New";
                    break;
                case "2":
                    $bookingName = "Ongoing";
                    break;
                case "3":
                    $bookingName = "Invoice";
                    break;
                case "4":
                    $bookingName = "Complete";
                    break;
                case "5":
                    $bookingName = "Cancel";
                    break;
                case "6":
                    $bookingName = "Future";
                    break;
                default:
                    $bookingName = "";
            }
            $data['booking_filter'] = 'All ' . $bookingName . ' Booking ';
        }
        
        $filterValue = $this->from_filter && $this->to_filter;
        $notfilterValue = $this->date_filter;

        return view('livewire.admin.ambulance.ambulance-booking-component',$data,[
            'filterValue' => $filterValue,
            'notfilterValue' => $notfilterValue,
        ]);

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
        $partnerDelete = DB::table('booking_view')->where('booking_id',$id)->update(['booking_status'=>'7']);

        session()->flash('message', 'Booking Deleted Successfully.');
        session()->flash('type', 'delete');
    }
    public function showNested($value)
    {
    $this->show = $value;

    }


}
