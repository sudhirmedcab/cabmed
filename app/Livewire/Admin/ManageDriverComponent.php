<?php

namespace App\Livewire\Admin;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB; 
use Livewire\Component;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class ManageDriverComponent extends Component
{
    use WithFileUploads;

    public $driver_id, $driver_profile_img,
            $city =[],
            $activeCity,
            $driver_city,
            $driverDataStep1,
            $driverDataStep2, $driverDataStep3,
            $step1=true,
            $step2=false,
            $step3=false,
            $step4=false,
            $step5=false,
            $step6=false,
            $step1Data=false,
            $step2Data=false,
            $step3Data=false,
            $step4Data=false,
            $step5Data=false,
            $status, $data, $id, $create_for, 
            $driver_name, $driver_mobile, $partner_id,
            $vehicle_rc_no, $driver_first_name,
            $driver_last_name, $driver_dl_front,$driver_adhar_front,$driver_adhar_back,$driver_adhar_no,
            $driver_pan_front,$driver_pan_no,
            $driver_police_verification,$driver_police_verification_expiry,
            $driver_dl_back, $driver_dl_expiry,
            $addDriver;

    public function mount()
        {
            $this->city = $this->cityList();
        }
    public function partners(){
        $partners = DB::table('partner')
                    ->select('partner_id','partner_f_name','partner_l_name','partner_mobile')
                    ->where(['partner_status' => 1])
                    ->get();
       return $partners;
    }
   
    public function render()
    {
         if($this->create_for == 1){
            $this->vehicle_rc_no = '';
            return view('livewire.admin.manage-driver-component',[
                'partners' => $this->partners(),
                'isPartner' => true
            ]);
        }
        return view('livewire.admin.manage-driver-component',[
            'partners' => $this->partners(),
            'isPartner' => false
        ]);
    }
 
    public function store()
    {
    $validatedData = $this->validate([
        'driver_first_name' => 'required',
        'driver_last_name' => 'required',
        'driver_mobile' => [
            'required',
            'numeric',
            'digits:10',
            // Rule::unique('driver', 'driver_mobile'),
        ],
        'vehicle_rc_no' => 'required',
        'partner_id' => $this->create_for == 1 ? 'required' : 'nullable',
    ]);

    $data = [
        'driver_created_by' => $this->create_for,
        'driver_name' => $validatedData['driver_first_name'],
        'driver_last_name' => $validatedData['driver_last_name'],
        'driver_mobile' => $validatedData['driver_mobile'],
        'driver_created_partner_id' => $this->create_for == 1 ? $this->partner_id : 0,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
    ];

    try {
        $insertedId = DB::table('driver')->insertGetId($data);

        if ($insertedId) {
            session()->flash('message', 'Driver Created Successfully..'.$insertedId);
            $this->step1Data = true;
            $this->step1 = false;
            $this->step2 = true;
            $this->addDriver = true;
            if($this->create_for == 0){
                DB::table('vehicle')->insertGetId(['vehicle_added_type' => $this->create_for, 
                                                  'vehicle_added_by' => $insertedId,
                                                  'vehicle_rc_number' => $this->vehicle_rc_no,
                                                  'created_at' => Carbon::now(),
                                                  'updated_at' => Carbon::now()]);
            }
            $insertedRecord = DB::table('driver')->where('driver_id', $insertedId)->first();
            $this->driverDataStep1 = $insertedRecord;
            $this->vehicle_rc_no = $this->vehicle_rc_no;
            $this->driver_id = $insertedId;
            //  return view('livewire.admin.manage-driver-component',[
            //     'city' => $this->cityList()
            // ]);
         } else {
            session()->flash('message', 'Something went wrong!!');
        }
    } catch (\Exception $e) {
        session()->flash('message', 'Error: ' . $e->getMessage());
    }
}


public function step2Form(){
        $this->validate([
            'driver_profile_img' => 'required|mimes:jpeg,png,jpg',
            'driver_city' => 'required'
        ]);
        $customFilename = $this->driver_id.'_driver_profile_' . time() . '.' . $this->driver_profile_img->getClientOriginalExtension();
        $this->driver_profile_img->storeAs('driver', $customFilename);

        DB::table('driver')->where('driver_id', $this->driver_id)->update([
            'driver_profile_img' => 'assets/driver'.$customFilename,
            'driver_city_id' => $this->driver_city,
        ]);

        $this->driverDataStep2 = true;
        $this->addError('form2Results', 'Refresh Form 2 results.');
        $this->step2Data = true;
        $this->step2 = false;
        $this->step3 = true;
    }
public function step3Form(){
    $this->validate([
        'driver_dl_front' => 'required|mimes:jpeg,png,jpg',
        'driver_dl_back' => 'required|mimes:jpeg,png,jpg',
        'driver_dl_expiry' => 'required:date'
     ]);
        // dd($this->driver_profile_img,$this->city);
        $customFdriver_dl_front_name = 'driver_details_dl_front_img' . time() . '.' . $this->driver_dl_front->getClientOriginalExtension();
        $customFdriver_dl_back_name = 'driver_details_dl_back_image' . time() . '.' . $this->driver_dl_back->getClientOriginalExtension();
        $this->driver_dl_front->storeAs('driver', $customFdriver_dl_front_name);        
        $this->driver_dl_back->storeAs('driver', $customFdriver_dl_back_name);        

        $insertedId = DB::table('driver_details')->insertGetId([
            'driver_details_driver_id' => $this->driver_id,
            'driver_details_dl_front_img' => 'assets/driver/'.$customFdriver_dl_front_name,
            'driver_details_dl_back_image' => 'assets/driver/'.$customFdriver_dl_back_name,
            'driver_details_dl_exp_date' => $this->driver_dl_expiry,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        $this->driverDataStep3 = DB::table('driver_details')->where('driver_details_id', $insertedId)->first();
        $this->step3Data = true;

        $this->step3 = false;
        $this->step4 = true;

}
public function step4Form(){
    $this->validate([
        'driver_adhar_front' => 'required|mimes:jpeg,png,jpg',
        'driver_adhar_back' => 'required|mimes:jpeg,png,jpg',
        'driver_adhar_no' => 'required:numeric'
     ]);
        // dd($this->driver_profile_img,$this->city);
        // $this->driver_profile_img->store(path: 'driver');
        // $this->addError('form3Results', 'Refresh Form 2 results.');
        $this->step4Data = true;

        $this->step4 = false;
        $this->step5 = true;

}

public function step5Form(){
    $this->validate([
        'driver_pan_front' => 'required|mimes:jpeg,png,jpg',
        'driver_pan_no' => 'required:numeric'
     ]);
        // dd($this->driver_profile_img,$this->city);
        // $this->driver_profile_img->store(path: 'driver');
        // $this->addError('form3Results', 'Refresh Form 2 results.');
        $this->step5Data = true;

        $this->step5 = false;
        $this->step6 = true;

}
public function cityList(){
        $activeCity = DB::table('city')
            ->select('city_id','city_name')
            ->where('city_status', 1)
            ->get();
            return $activeCity;

}
}
