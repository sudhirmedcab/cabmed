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

    public $driver_id,$driver_details_id,$vehicle_details_id,$driver_profile_img,
            $city =[],
            $activeCity,
            $ambulanceCategory,
            $ambulanceCatList,
            $driver_city,
            $driver_gender,
            $driver_dob,
            $driver_pan_img,
            $driverDataStep1,
            $driverDataStep2, $driverDataStep3,
            $isStep1FormSubmitted,
            $isStep2FormSubmitted,
            $isStep3FormSubmitted,
            $isStep4FormSubmitted,
            $isStep5FormSubmitted,
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
            $driver_name, $driver_mobile, $partner_id,$vehicle_id,
            $vehicle_rc_no, $driver_first_name,
            $driver_last_name,$driver_police_verification_img,$driver_dl_front,$driver_adhar_front,$driver_profile_image,
            $driver_adhar_back,$driver_adhar_no,$driver_dl_no,
            $driver_pan_front,$driver_pan_no,
            $driver_police_verification,$driver_police_verification_expiry,
            $driver_dl_back, $driver_dl_expiry,
            $vehicle_front_image,$vehicle_back_image,$vehicle_rc_image,$vehicle_rc_number,$vehicle_exp_date,
            $vehicle_details_fitness_certi_img,$vehicle_details_fitness_exp_date,$vehicle_details_insurance_img,$vehicle_details_insurance_exp_date,
            $vehicle_details_insurance_holder_name,$vehicle_details_pollution_img,$vehicle_details_pollution_exp_date,
            $addDriver;

    public function mount()
        {
            $this->city = $this->cityList();
            $this->ambulanceCatList = $this->ambulanceCategoryList();
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
        // dd($this->create_for);
        // if($this->ambulanceCategory){
        //     dd('ambulance_category',$this->ambulanceCategory);
        //     // $this->ambulanceFacilitiesByCatType($this->ambulanceCategory,$this->ambulanceCategory)

        // }
         if($this->create_for == 1){

            $this->vehicle_rc_no = '';
            return view('livewire.admin.manage-driver-component',[
                'partners' => $this->partners(),
                'isPartner' => true
            ]);
        }
        // dd($this->create_for);

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
            $this->isStep1FormSubmitted = true;
            $this->vehicle_id = $insertedRecord;
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

public function step1Form(){

        $validatedData = $this->validate([
            'driver_first_name' => 'required',
            'driver_last_name' => 'required',
            'create_for' => 'required',
            'driver_profile_image' => 'required|mimes:jpeg,png,jpg',
            'driver_mobile' => [
                'required',
                'numeric',
                'digits:10',
            ],
            'vehicle_rc_no' => $this->create_for == 0 ? 'required' : 'nullable',
            'partner_id' => $this->create_for == 1 ? 'required' : 'nullable',
            'driver_dob' => 'required',
            'driver_gender' => 'required',
            'driver_city' => 'required',

        ],
        [
            'create_for.required' => 'Field required',
            'driver_first_name.required' => 'First name required',
            'driver_last_name.required' => 'Last name required',
            'driver_mobile.unique' => 'Allready exist',
            'driver_mobile.required' => 'Mobile required',
            'driver_mobile.numeric' => 'Must be number',
            'vehicle_rc_no.required' => 'RC no. required',
            'partner_id.required' => 'Partner required',
            'driver_dob.required' => 'Date of birth required',
            'driver_gender.required' => 'Gender required',
            'driver_city.required' => 'City required',
            'driver_profile_image.required' => 'Profile Image requirerd',
            'driver_profile_image.mimes' => 'Type must be : jpeg, png, jpg.'
        ]
    );
    $driver_profile_imageFilename = $this->driver_id.'_driver_profile_image_' . time() . '.' . $this->driver_profile_image->getClientOriginalExtension();
    $this->driver_profile_image->storeAs('driver', $driver_profile_imageFilename);

    $data = [
        'driver_created_by' => $this->create_for,
        'driver_name' => $validatedData['driver_first_name'],
        'driver_profile_img' => 'asset/driver'.$driver_profile_imageFilename,
        'driver_last_name' => $validatedData['driver_last_name'],
        'driver_mobile' => $validatedData['driver_mobile'],
        'driver_dob' => $validatedData['driver_dob'],
        'driver_gender' => $validatedData['driver_gender'],
        'driver_city_id' => $validatedData['driver_city'],
        'driver_created_partner_id' => $this->create_for == 1 ? $this->partner_id : 0,
        'driver_registration_step' => 1,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
    ];
    // dd($data);
    try {
        DB::beginTransaction();
        if($this->driver_id){
            DB::table('driver')->where('driver_id', $this->driver_id)->update($data);
            session()->flash('message', 'Step 1 successfully update !! driverid is::'.$this->driver_id.'and'.$this->driver_details_id);
        }else{
            $insertedId = DB::table('driver')->insertGetId($data);
            if ($insertedId) {
                session()->flash('message', 'Driver step1 Created Successfully..'.$insertedId);
                if($this->create_for == 0){
                    $vehicle_id = DB::table('vehicle')->insertGetId(['vehicle_added_type' => $this->create_for, 
                                                    'vehicle_added_by' => $insertedId,
                                                    'vehicle_rc_number' => $this->vehicle_rc_no,
                                                    'created_at' => Carbon::now(),
                                                    'updated_at' => Carbon::now()]);
                    $this->vehicle_id = $vehicle_id;
            }
            $insertedRecord = DB::table('driver')->where('driver_id', $insertedId)->first();
            $this->driverDataStep1 = $insertedRecord;
            $this->vehicle_rc_no = $this->vehicle_rc_no;
            $this->driver_id = $insertedId;
            $this->isStep1FormSubmitted = true;

            //  return view('livewire.admin.manage-driver-component',[
            //     'city' => $this->cityList()
            // ]);
         } else {
            session()->flash('message', 'Something went wrong!!');
            }
        }
        DB::commit(); 
    } catch (\Exception $e) {
        session()->flash('message', 'Error: ' . $e->getMessage());
        \Log::error('Error occurred while processing step1Form: ' . $e->getMessage());
    }
}

public function step2Form(){
    // dd($this);
     $this->validate([
        'driver_id' => 'required|numeric',
        'driver_adhar_front' => 'required|mimes:jpeg,png,jpg',
        'driver_adhar_back' => 'required|mimes:jpeg,png,jpg',
        'driver_adhar_no' => 'required|digits:12',
        'driver_pan_no' => 'nullable|regex:/^[A-Z]{5}[0-9]{4}[A-Z]$/',
        'driver_pan_img' => 'nullable|mimes:jpeg,png,jpg',
    ], [
        'driver_adhar_no.required' => 'Adhar required',
        'driver_adhar_front.required' => 'Front image required',
        'driver_adhar_back.required' => 'Back image required', 
        'driver_pan_img.required' => 'Pan image required',
        'driver_pan_img.mimes' => 'Type must be : jpeg, png, jpg.',
        'driver_pan_no.required' => 'Pan no. required',
        'driver_id.required' => '*Please fill previous steps',
        'driver_id.numeric' => '*Please fill previous steps'
    ]);
  
        //  dd('data',$data);
    try {
        DB::beginTransaction();
        if($this->driver_adhar_front){
        $driver_adhar_frontFilename = $this->driver_id.'_driver_adhar_front_' . time() . '.' . $this->driver_adhar_front->getClientOriginalExtension();
        $this->driver_adhar_front->storeAs('driver', $driver_adhar_frontFilename);
        }else{
            $driver_pan_imgFilename=null;
        }
        if($this->driver_adhar_back){
        $driver_adhar_backFilename = $this->driver_id.'_driver_adhar_back_' . time() . '.' . $this->driver_adhar_back->getClientOriginalExtension();
        $this->driver_adhar_back->storeAs('driver', $driver_adhar_backFilename);
        }else{
            $driver_adhar_backFilename=null;
        }
        if($this->driver_pan_img){
        $driver_pan_imgFilename = $this->driver_id.'_driver_pan_img_' . time() . '.' . $this->driver_pan_img->getClientOriginalExtension();
        $this->driver_pan_img->storeAs('driver', $driver_pan_imgFilename);
        }else{
            $driver_pan_imgFilename=null;
        }
        if($this->driver_id && $this->driver_details_id){
            DB::table('driver_details')->where('driver_details_id', $this->driver_details_id)->update([
                'driver_details_driver_id' => $this->driver_id,
                'driver_details_aadhar_front_img' => $driver_adhar_frontFilename ? 'assets/driver'.$driver_adhar_frontFilename : '',
                'driver_details_aadhar_back_img' => $driver_adhar_backFilename ? 'assets/driver'.$driver_adhar_backFilename : '',
                'driver_details_pan_card_front_img' => $driver_pan_imgFilename ? 'assets/driver'.$driver_pan_imgFilename : '',
                'driver_details_pan_card_number' => $this->driver_pan_no,
                'driver_details_aadhar_number' => $this->driver_adhar_no,
                'updated_at' => Carbon::now()
                 ]);
                session()->flash('message', 'Step 2 updated successfully !!'.$this->driver_id.'and'.$this->driver_details_id);

        }else{
       
        $driver_details_id = DB::table('driver_details')->insertGetId([
            'driver_details_driver_id' => $this->driver_id,
            'driver_details_aadhar_front_img' => $driver_adhar_frontFilename ? 'assets/driver'.$driver_adhar_frontFilename : '',
            'driver_details_aadhar_back_img' => $driver_adhar_backFilename ? 'assets/driver'.$driver_adhar_backFilename : '',
            'driver_details_pan_card_front_img' => $driver_pan_imgFilename ? 'assets/driver'.$driver_pan_imgFilename : '',
            'driver_details_pan_card_number' => $this->driver_pan_no,
            'driver_details_aadhar_number' => $this->driver_adhar_no,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
             ]);
            
             DB::table('driver')->where('driver_id', $this->driver_id)->update([
                'driver_registration_step' => 2,
            ]);
            $this->isStep2FormSubmitted = true;
            $this->driver_details_id=$driver_details_id;
            session()->flash('message', 'Step 2 successfull !!'.$this->driver_id.'and'.$this->driver_details_id);
            }
            DB::commit();
        }
        catch (\Exception $e) {
            session()->flash('message', 'Step 2 something went wrong!!'.$e->getMessage());
            DB::rollback();
            \Log::error('Error occurred while processing step2Form: ' . $e->getMessage());
        }
}

public function step3Form(){
    // dd($this);
    $this->validate([
       'driver_id' => 'required|numeric',
       'driver_details_id' => 'required|numeric',
       'driver_dl_front' => 'required|mimes:jpeg,png,jpg',
       'driver_dl_back' => 'required|mimes:jpeg,png,jpg',
       'driver_police_verification_img' => 'nullable|mimes:jpeg,png,jpg',
       'driver_dl_no' => 'required',
       'driver_dl_expiry' => 'required',
       'driver_police_verification_expiry' => 'nullable|date'
   ], [
       'driver_dl_front.required' => 'Front image required',
       'driver_dl_back.required' => 'Back image required',
       'driver_dl_no.required' => 'Dl required',
       'driver_dl_expiry.required' => 'DL expiry required',
       'driver_police_verification_img.mimes' => 'Type must be : jpeg, png, jpg.',
       'driver_police_verification_expiry.date' => 'Must be date',
       'driver_id.required' => '*Please fill previous steps',
       'driver_id.numeric' => '*Please fill previous steps',
       'driver_details_id.required' => '*Please fill previous steps',
       'driver_details_id.numeric' => '*Please fill previous steps',
   ]);
 
        // dd('data',$this);
   try {
       DB::beginTransaction();
       $driver_dl_frontFilename = $this->driver_id.'_driver_dl_front_image_' . time() . '.' . $this->driver_dl_front->getClientOriginalExtension();
       $this->driver_dl_front->storeAs('driver', $driver_dl_frontFilename);
       $driver_dl_backFilename = $this->driver_id.'_driver_dl_back_image' . time() . '.' . $this->driver_dl_back->getClientOriginalExtension();
       $this->driver_dl_back->storeAs('driver', $driver_dl_backFilename);
       $driver_police_verification_imgFilename = $this->driver_id.'_driver_police_verification_image_' . time() . '.' . $this->driver_police_verification_img->getClientOriginalExtension();
       $this->driver_police_verification_img->storeAs('driver', $driver_police_verification_imgFilename);

        DB::table('driver_details')->where(['driver_details_driver_id' => $this->driver_id,'driver_details_id' => $this->driver_details_id])->update([
            'driver_details_police_verification_image' => 'assets/driver'.$driver_police_verification_imgFilename,
            'driver_details_police_verification_date' => $this->driver_police_verification_expiry,
            'driver_details_dl_front_img' => 'assets/driver'.$driver_dl_frontFilename,
            'driver_details_dl_back_image' => 'assets/driver'.$driver_dl_backFilename,
            'driver_details_dl_number' => $this->driver_dl_no,
            'driver_details_dl_exp_date' => $this->driver_dl_expiry,
            'updated_at' => Carbon::now()
            ]);
            DB::table('driver')->where('driver_id', $this->driver_id)->update([
                'driver_registration_step' => 3,
                'updated_at' => Carbon::now()

            ]);
            $this->isStep3FormSubmitted = true;
            DB::commit();
            session()->flash('message', 'Step 3 successfull !!'.$this->driver_id.'and'.$this->driver_details_id);
   } 
    catch (\Exception $e) {
       session()->flash('message', 'Step 3 something went wrong!!'.$e->getMessage());
       DB::rollback();
       \Log::error('Error occurred while processing step3Form: ' . $e->getMessage());
   }
}
public function step4Form(){
    // dd($this);
    $this->validate([
       'driver_id' => 'required|numeric',
       'driver_details_id' => 'required|numeric',
       'vehicle_id' => 'required|numeric',
       'vehicle_front_image' => 'required|mimes:jpeg,png,jpg',
       'vehicle_back_image' => 'required|mimes:jpeg,png,jpg',
       'vehicle_rc_image' => 'required|mimes:jpeg,png,jpg',
       'vehicle_rc_number' => 'required',
       'vehicle_exp_date' => 'required',
       'ambulanceCategory' => 'required'
   ], [
       'vehicle_front_image.required' => 'Front image required',
       'vehicle_back_image.required' => 'Back image required',
       'vehicle_rc_image.required' => 'RC image required',
       'vehicle_rc_number.required' => 'RC number required',
       'vehicle_exp_date.required' => 'Expiry required',
       'ambulanceCategory.required' => 'Category required',
       'vehicle_rc_image.mimes' => 'Type must be : jpeg, png, jpg.',
       'vehicle_front_image.mimes' => 'Type must be : jpeg, png, jpg.',
       'vehicle_back_image.mimes' => 'Type must be : jpeg, png, jpg.',
       'vehicle_exp_date.date' => 'Must be date',
       'driver_id.required' => '*Please fill previous steps',
       'driver_id.numeric' => '*Please fill previous steps',
       'driver_details_id.required' => '*Please fill previous steps',
       'driver_details_id.numeric' => '*Please fill previous steps',
       'vehicle_id.required' => '*Please fill previous steps',
       'vehicle_id.numeric' => '*Please fill previous steps',
   ]);
 
        // dd('data',$this);
   try {
       DB::beginTransaction();
       $vehicle_front_imageFilename = $this->driver_id.'_vehicle_front_image_' . time() . '.' . $this->vehicle_front_image->getClientOriginalExtension();
       $this->vehicle_front_image->storeAs('driver', $vehicle_front_imageFilename);
       $vehicle_back_imageFilename = $this->driver_id.'_vehicle_back_image_' . time() . '.' . $this->vehicle_back_image->getClientOriginalExtension();
       $this->vehicle_back_image->storeAs('driver', $vehicle_back_imageFilename);
       $vehicle_rc_imageFilename = $this->driver_id.'_vehicle_rc_image_' . time() . '.' . $this->vehicle_rc_image->getClientOriginalExtension();
       $this->vehicle_rc_image->storeAs('driver', $vehicle_rc_imageFilename);
     
       $ambulance_facilities_ids = DB::table('ambulance_facilities')
       ->where('ambulance_facilities_category_type', $this->ambulanceCategory)
       ->pluck('ambulance_facilities_id')
       ->toArray();
        $ambulance_facilities_ids = implode(', ', $ambulance_facilities_ids);

         DB::table('vehicle')->where(['vehicle_id' => $this->vehicle_id])->update([
            'vehicle_front_image' => 'assets/driver'.$vehicle_front_imageFilename,
            'vehicle_back_image' => 'asset/driver'.$vehicle_back_imageFilename,
            'vehicle_rc_image' => 'assets/driver'.$vehicle_rc_imageFilename,
            'vehicle_rc_number' => $this->vehicle_rc_number,
            'vehicle_exp_date' => $this->vehicle_exp_date,
            'vehicle_category_type' => $this->ambulanceCategory,
            'vehicle_category_type_service_id' => $ambulance_facilities_ids,
            'updated_at' => Carbon::now()
            ]);
            DB::table('driver')->where('driver_id', $this->driver_id)->update([
                'driver_registration_step' => 4,
                'updated_at' => Carbon::now()

            ]);
            $this->isStep4FormSubmitted = true;
            DB::commit();
            session()->flash('message', 'Step 4 successfull !!'.$this->driver_id.'and'.$this->driver_details_id);
   } 
    catch (\Exception $e) {
       session()->flash('message', 'Step 4 something went wrong!!'.$e->getMessage());
       DB::rollback();
       \Log::error('Error occurred while processing step3Form: ' . $e->getMessage());
   }
}

public function step5Form(){
    // dd($this);
    $this->validate([
       'driver_id' => 'required|numeric',
       'driver_details_id' => 'required|numeric',
       'vehicle_id' => 'required|numeric',
       'vehicle_details_fitness_certi_img' => 'nullable|image|mimes:jpeg,png,jpg',
       'vehicle_details_fitness_exp_date' => 'nullable|date',
       'vehicle_details_insurance_img' => 'nullable|image|mimes:jpeg,png,jpg',
       'vehicle_details_insurance_exp_date' => 'nullable|date',
       'vehicle_details_insurance_holder_name' => 'nullable',
       'vehicle_details_pollution_img' => 'nullable|mimes:jpeg,png,jpg',
       'vehicle_details_pollution_exp_date' => 'date|nullable'
       
   ], [
        'driver_id.required' => '*Please fill previous steps',
        'driver_id.numeric' => '*Please fill previous steps',
        'driver_details_id.required' => '*Please fill previous steps',
        'driver_details_id.numeric' => '*Please fill previous steps',
        'vehicle_id.required' => '*Please fill previous steps',
        'vehicle_id.numeric' => '*Please fill previous steps',
        'vehicle_details_fitness_certi_img.mimes' => 'Type must be : jpeg, png, jpg.',
        'vehicle_details_insurance_img.mimes' => 'Type must be : jpeg, png, jpg.',
        'vehicle_details_pollution_img.mimes' => 'Type must be : jpeg, png, jpg.',
        'vehicle_details_fitness_exp_date.date' => 'Must be date',
        'vehicle_details_pollution_exp_date.date' => 'Must be date'
    ]);
        // dd('data',$this);
   try {
       DB::beginTransaction();
       if($this->vehicle_details_fitness_certi_img){
        $vehicle_details_fitness_certi_imgFilename = $this->driver_id.'_vehicle_details_fitness_certi_img_' . time() . '.' . $this->vehicle_details_fitness_certi_img->getClientOriginalExtension();
        $this->vehicle_details_fitness_certi_img->storeAs('driver', $vehicle_details_fitness_certi_imgFilename);
        }else{
            $vehicle_details_fitness_certi_imgFilename=null;
        }
        if($this->vehicle_details_insurance_img){
            $vehicle_details_insurance_imgFilename = $this->driver_id.'_vehicle_details_insurance_img_' . time() . '.' . $this->vehicle_details_insurance_img->getClientOriginalExtension();
            $this->vehicle_details_insurance_img->storeAs('driver', $vehicle_details_insurance_imgFilename);
            }else{
                $vehicle_details_insurance_imgFilename=null;
            }  
        if($this->vehicle_details_pollution_img){
            $vehicle_details_pollution_imgFilename = $this->driver_id.'_vehicle_details_pollution_img_' . time() . '.' . $this->vehicle_details_pollution_img->getClientOriginalExtension();
            $this->vehicle_details_pollution_img->storeAs('driver', $vehicle_details_pollution_imgFilename);
            }else{
                $vehicle_details_pollution_imgFilename=null;
            }
        if($this->driver_id && $this->vehicle_details_id){
         DB::table('vehicle_details')->where(['vehicle_details_id' => $this->vehicle_details_id])->update([
            'vehicle_details_vheicle_id' => $this->vehicle_id,
            'vehicle_details_fitness_certi_img' => $vehicle_details_fitness_certi_imgFilename ? 'assets/driver'.$vehicle_details_fitness_certi_imgFilename : '',
            'vehicle_details_insurance_img' => $vehicle_details_insurance_imgFilename ? 'assets/driver'.$vehicle_details_insurance_imgFilename : '',
            'vehicle_details_pollution_img' => $vehicle_details_pollution_imgFilename ? 'assets/driver'.$vehicle_details_pollution_imgFilename : '',
            'vehicle_details_fitness_exp_date' => $this->vehicle_details_fitness_exp_date,
            'vehicle_details_pollution_exp_date' => $this->vehicle_details_pollution_exp_date,
            'vehicle_details_insurance_holder_name' => $this->vehicle_details_insurance_holder_name,
            'vehicle_details_insurance_exp_date' => $this->vehicle_details_insurance_exp_date,
            'vehicle_details_added_by' => 0,
            'updated_at' => Carbon::now()
                ]);
            session()->flash('message', 'Step 5 updated successfull !!'.$this->driver_id.'and'.$this->driver_details_id);

        }else{
            $vehicle_details_id = DB::table('vehicle_details')->insertGetId([
                'vehicle_details_vheicle_id' => $this->vehicle_id,
                'vehicle_details_fitness_certi_img' => $vehicle_details_fitness_certi_imgFilename ? 'assets/driver'.$vehicle_details_fitness_certi_imgFilename : '',
                'vehicle_details_insurance_img' => $vehicle_details_insurance_imgFilename ? 'assets/driver'.$vehicle_details_insurance_imgFilename : '',
                'vehicle_details_pollution_img' => $vehicle_details_pollution_imgFilename ? 'assets/driver'.$vehicle_details_pollution_imgFilename : '',
                'vehicle_details_fitness_exp_date' => $this->vehicle_details_fitness_exp_date,
                'vehicle_details_pollution_exp_date' => $this->vehicle_details_pollution_exp_date,
                'vehicle_details_insurance_holder_name' => $this->vehicle_details_insurance_holder_name,
                'vehicle_details_insurance_exp_date' => $this->vehicle_details_insurance_exp_date,
                'vehicle_details_added_by' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
                 ]);
                $this->vehicle_details_id=$vehicle_details_id;
                 session()->flash('message', 'Step 5 successfull !!'.$this->driver_id.'and'.$this->driver_details_id.'and'.$this->vehicle_details_id);
        }
         DB::table('driver')->where('driver_id', $this->driver_id)->update([
            'driver_registration_step' => 5,
        ]);
        $this->isStep5FormSubmitted = true;
        DB::commit();
   } 
    catch (\Exception $e) {
       session()->flash('message', 'Step 5 something went wrong!!'.$e->getMessage());
       DB::rollback();
       \Log::error('Error occurred while processing step5Form: ' . $e->getMessage());
   }
}

public function step2Formold(){
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
public function step3Formold(){
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
public function step44Form(){
    // dd($this);
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


public function cityList(){
        $activeCity = DB::table('city')
            ->select('city_id','city_name')
            ->where('city_status', 1)
            ->get();
            return $activeCity;
}
    public function ambulanceCategoryList(){
        $ambulanceCategory = DB::table('ambulance_category')
            ->orderByDesc('ambulance_category.ambulance_category_id')
            ->get();
            return $ambulanceCategory;
            dd($ambulanceCategory);
    }
    public function ambulanceFacilitiesByCatType(){
        $ambulanceFacilityByCatType = DB::table('ambulance_facilities')->where(['ambulance_facilities_category_type' =>'C_AC'])
            ->get();
            return $ambulanceFacilityByCatType;
            dd($ambulanceFacilityByCatType);
    }
}
