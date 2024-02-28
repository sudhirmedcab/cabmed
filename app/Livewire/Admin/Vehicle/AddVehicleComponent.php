<?php

namespace App\Livewire\Admin\Vehicle;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB; 
use Livewire\Component;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class AddVehicleComponent extends Component
{
    use WithFileUploads;

    public $vehicle_details_id,
            $city =[],
            $vehicleList,
            $vehicleId,
            $v_vehicle_name_id,
            $ambulanceCategory,
            $ambulanceCatList,
            $isStep1FormSubmitted,
            $isStep2FormSubmitted,
            $isStep3FormSubmitted,
            $step1=true,
            $step2=false,
            $step3=false,
            $step1Data=false,
            $step2Data=false,
            $step3Data=false,
           $partner_id,$vehicle_id,
            $vehicle_rc_no, 
            $vehicle_front_image,$vehicle_back_image,$vehicle_rc_image,$vehicle_rc_number,$vehicle_exp_date,
            $vehicle_details_fitness_certi_img,$vehicle_details_fitness_exp_date,$vehicle_details_insurance_img,$vehicle_details_insurance_exp_date,
            $vehicle_details_insurance_holder_name,$vehicle_details_pollution_img,$vehicle_details_pollution_exp_date,
            $addDriver,$activeTab;

 protected $listeners = ['listenerReferenceHere'];

public function listenerReferenceHere($selectedValue)
{ 
    //Do something with the selected2's selected value here
}

    public function mount()
        {
            $this->ambulanceCatList = $this->ambulanceCategoryList();
            $this->vehicleList = $this->vehicleData();
            $this->loadData();

        }
    public function partners(){
        $partners = DB::table('partner')
                    ->select('partner_id','partner_f_name','partner_l_name','partner_mobile')
                    ->where(['partner_status' => 1])
                    ->get();
       return $partners;
    }

    public function loadData(){

        $originalVehicleId = decrypt($this->vehicleId);
        
        if($originalVehicleId !== null){

                $vehicle_details = DB::table('vehicle')
                ->leftJoin('vehicle_details', 'vehicle_details.vehicle_details_vheicle_id', '=', 'vehicle.vehicle_id')
                ->leftJoin('ambulance_category', 'vehicle.vehicle_category_type', '=', 'ambulance_category.ambulance_category_type')
                ->leftJoin('partner', 'vehicle.vehicle_added_by', '=', 'partner.partner_id')
                ->leftJoin('city', 'partner.partner_city_id', '=', 'city.city_id')
                ->where('vehicle.vehicle_id', $originalVehicleId)
                ->where('vehicle.vehicle_added_type',1)
                ->leftJoin('state', 'state.state_id', '=', 'city.city_state')
                ->first();

            if($vehicle_details){

                    $ambulance_category_type = $vehicle_details->ambulance_category_type;
                    $ambulanceKit = DB::table('ambulance_facilities')->where('ambulance_facilities_category_type', $ambulance_category_type)->get();

                    $this->vehicle_added_type=$vehicle_details->vehicle_added_type;
                    $this->vehicle_added_by=$vehicle_details->vehicle_added_by;
                    $this->partner_id = $vehicle_details->vehicle_added_by;
                    $this->vehicle_rc_number = $vehicle_details->vehicle_rc_number;
                    $this->vehicle_details_id = $vehicle_details->vehicle_details_id;
                    $this->ambulanceCategory = $vehicle_details->vehicle_category_type;
                    $this->vehicle_rc_image = $vehicle_details->vehicle_rc_image;
                    $this->vehicle_front_image = $vehicle_details->vehicle_front_image;
                    $this->vehicle_back_image = $vehicle_details->vehicle_back_image;
                    $this->vehicle_details_fitness_certi_img = $vehicle_details->vehicle_details_fitness_certi_img;
                    $this->vehicle_details_insurance_img = $vehicle_details->vehicle_details_insurance_img;
                    $this->vehicle_details_pollution_img = $vehicle_details->vehicle_details_pollution_img;
                    $this->v_vehicle_name = $vehicle_details->v_vehicle_name;
                    $this->v_vehicle_name_id = $vehicle_details->v_vehicle_name_id;
                    
                    $this->vehicle_exp_date =  Carbon::parse($vehicle_details->vehicle_exp_date)->toDateString();
                    $this->vehicle_details_fitness_exp_date =  Carbon::parse($vehicle_details->vehicle_details_fitness_exp_date)->toDateString();
                    $this->vehicle_details_insurance_exp_date =  Carbon::parse($vehicle_details->vehicle_details_insurance_exp_date)->toDateString();
                    $this->vehicle_details_pollution_exp_date =  Carbon::parse($vehicle_details->vehicle_details_pollution_exp_date)->toDateString();
                    $this->vehicle_details_insurance_holder_name = $vehicle_details->vehicle_details_insurance_holder_name;
                    $this->vehicle_id = $vehicle_details->vehicle_id;
                    $this->vehicle_details_id = $vehicle_details->vehicle_details_id;
                  
                }
            }
    }
   
    public function render()
    {
            return view('livewire.admin.vehicle.add-vehicle-component',[
                'partners' => $this->partners(),
            ]);
        }

 
public function step1Form(){

    $validatedData = $this->validate([
        'vehicle_rc_image' => 'required|mimes:jpeg,png,jpg',
        'vehicle_rc_number' => [
            'required',
            Rule::unique('vehicle', 'vehicle_rc_number') 
        ],  
        'partner_id' => 'required',
        'vehicle_id' => 'nullable',
        'vehicle_exp_date' => 'required'
    ],
    
        [
            'vehicle_rc_number.unique' => 'Rc Number Allready exist',
            'vehicle_rc_number.required' => 'Rc Number required',
            'partner_id.required' => 'Partner Name required',
            'vehicle_exp_date.required' => 'Vehicle Expired Date Field required',
            'vehicle_rc_image.required' => 'RC Image requirerd',
            'vehicle_rc_image.mimes' => 'Type must be : jpeg, png, jpg.'
           
        ]
    );
    
    $vehicle_id = $validatedData['vehicle_id'];

    $data = [
        'vehicle_added_type' => 1,
        'vehicle_added_by' => $validatedData['partner_id'],
        'vehicle_rc_number' => $validatedData['vehicle_rc_number'],
        'vehicle_exp_date' => $validatedData['vehicle_exp_date'],
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
    ];
    // dd($data);
    try {
        DB::beginTransaction();
        if($vehicle_id || $this->vehicle_id){
            DB::table('vehicle')
            ->where('vehicle_id', $vehicle_id)->update($data);

            session()->flash('message', 'Step 1 successfully update !! vehicleid is: '.$vehicle_id);
        }else{

            $insertedId = DB::table('vehicle')->insertGetId($data);
            if ($insertedId) {

            $rc_imageFilename = $this->storeImage($this->vehicle_rc_image, $this->partner_id, 'vehicle_rcsss_img');

            $data2 = [
                'vehicle_rc_image' => $rc_imageFilename,
            ];

            DB::table('vehicle')->where('vehicle_id', $insertedId)->update($data2);

            session()->flash('message', 'Vehicle step1 Created Successfully..'.$insertedId);
          
            $insertedRecord = DB::table('vehicle')->where('vehicle_id', $insertedId)->first();
            $this->vehicleDataStep1 = $insertedRecord;
            $this->vehicle_id = $insertedId;
            $this->isStep1FormSubmitted = true;

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

private function storeImage($image, $insertedId, $imageName)
{

 $imageFilename = 'pv_'.$insertedId . '_' . $imageName . '_' . time() . '.' . $image->getClientOriginalExtension();
 $image->storeAs('vehicle', $imageFilename);
 return 'assets/vehicle/' . $imageFilename;
}


public function step2Form(){

   $validatedData = $this->validate([
       'vehicle_id' => 'required|numeric',
       'vehicle_id' => 'required|numeric',
       'vehicle_front_image' => 'required|mimes:jpeg,png,jpg',
       'vehicle_back_image' => 'required|mimes:jpeg,png,jpg',
       'vehicle_exp_date' => 'required',
       'ambulanceCategory' => 'required',
       'v_vehicle_name_id' => 'required'
   ], [
       'vehicle_front_image.required' => 'Front image required',
       'vehicle_back_image.required' => 'Back image required',
       'ambulanceCategory.required' => 'Category required',
       'v_vehicle_name_id.required' => 'Vehicle Name is required',
       'vehicle_front_image.mimes' => 'Type must be : jpeg, png, jpg.',
       'vehicle_back_image.mimes' => 'Type must be : jpeg, png, jpg.',
       'vehicle_id.required' => '*Please fill previous steps',
       'vehicle_id.numeric' => '*Please fill previous steps',
   ]);
 
   try {
       DB::beginTransaction();

       $vehicle_front_imageFilename = 'pv_'.$this->partner_id.'_vehicle_front_img_' . time() . '.' . $this->vehicle_front_image->getClientOriginalExtension();
       $this->vehicle_front_image->storeAs('vehicle', $vehicle_front_imageFilename);

       $vehicle_back_imageFilename = 'pv_'.$this->partner_id.'_vehicle_back_img_' . time() . '.' . $this->vehicle_back_image->getClientOriginalExtension();
       $this->vehicle_back_image->storeAs('vehicle', $vehicle_back_imageFilename);
     
       $ambulance_facilities_ids = DB::table('ambulance_facilities')
       ->where('ambulance_facilities_category_type', $this->ambulanceCategory)
       ->pluck('ambulance_facilities_id')
       ->toArray();

       $ambulanceName = DB::table('ambulance_category_vehicle')
       ->where('ambulance_category_vehicle_id', $this->v_vehicle_name_id)
       ->value('ambulance_category_vehicle_name');

        $ambulance_facilities_ids = implode(', ', $ambulance_facilities_ids);

         DB::table('vehicle')->where(['vehicle_id' => $this->vehicle_id])->update([
            'vehicle_front_image' => 'assets/vehicle/'.$vehicle_front_imageFilename,
            'vehicle_back_image' => 'assets/vehicle/'.$vehicle_back_imageFilename,
            'vehicle_category_type' => $this->ambulanceCategory,
            'vehicle_category_type_service_id' => $ambulance_facilities_ids,
            'v_vehicle_name_id' => $this->v_vehicle_name_id,
            'v_vehicle_name' => $ambulanceName,
            'vehicle_category_type_service_id' => $ambulance_facilities_ids,
            'updated_at' => Carbon::now()
            ]);
          
            $this->isStep2FormSubmitted = true;
            DB::commit();
            session()->flash('message', 'Step 2 successfull !!'.$this->vehicle_id);
   } 
    catch (\Exception $e) {
       session()->flash('message', 'Step 2 something went wrong!!'.$e->getMessage());
       DB::rollback();
       \Log::error('Error occurred while processing step3Form: ' . $e->getMessage());
   }
}

public function step3Form(){
    $this->validate([
       'vehicle_id' => 'required|numeric',
       'vehicle_details_fitness_certi_img' => 'nullable|image|mimes:jpeg,png,jpg',
       'vehicle_details_fitness_exp_date' => 'nullable|date',
       'vehicle_details_insurance_img' => 'nullable|image|mimes:jpeg,png,jpg',
       'vehicle_details_insurance_exp_date' => 'nullable|date',
       'vehicle_details_insurance_holder_name' => 'nullable',
       'vehicle_details_pollution_img' => 'nullable|mimes:jpeg,png,jpg',
       'vehicle_details_pollution_exp_date' => 'date|nullable'
       
   ], [
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
        $vehicle_details_fitness_certi_imgFilename = 'pv_'.$this->partner_id.'_vehicle_fitness_img_' . time() . '.' . $this->vehicle_details_fitness_certi_img->getClientOriginalExtension();
        $this->vehicle_details_fitness_certi_img->storeAs('vehicle', $vehicle_details_fitness_certi_imgFilename);
        }else{
            $vehicle_details_fitness_certi_imgFilename=null;
        }
        if($this->vehicle_details_insurance_img){
            $vehicle_details_insurance_imgFilename = 'pv_'.$this->partner_id.'vehicle_insurance_img_' . time() . '.' . $this->vehicle_details_insurance_img->getClientOriginalExtension();
            $this->vehicle_details_insurance_img->storeAs('vehicle', $vehicle_details_insurance_imgFilename);
            }else{
                $vehicle_details_insurance_imgFilename=null;
            }  
        if($this->vehicle_details_pollution_img){
            $vehicle_details_pollution_imgFilename = 'pv_'.$this->partner_id.'vehicle_pollution_img_' . time() . '.' . $this->vehicle_details_pollution_img->getClientOriginalExtension();
            $this->vehicle_details_pollution_img->storeAs('vehicle', $vehicle_details_pollution_imgFilename);
            }else{
                $vehicle_details_pollution_imgFilename=null;
            }
        if($this->vehicle_id && $this->vehicle_details_id){
         DB::table('vehicle_details')->where(['vehicle_details_id' => $this->vehicle_details_id])->update([
            'vehicle_details_vheicle_id' => $this->vehicle_id,
            'vehicle_details_added_type' => 1,
            'vehicle_details_added_by' => $this->partner_id,
            'vehicle_details_fitness_certi_img' => $vehicle_details_fitness_certi_imgFilename ? 'assets/vehicle/'.$vehicle_details_fitness_certi_imgFilename : '',
            'vehicle_details_insurance_img' => $vehicle_details_insurance_imgFilename ? 'assets/vehicle/'.$vehicle_details_insurance_imgFilename : '',
            'vehicle_details_pollution_img' => $vehicle_details_pollution_imgFilename ? 'assets/vehicle/'.$vehicle_details_pollution_imgFilename : '',
            'vehicle_details_fitness_exp_date' => (new Carbon($this->vehicle_details_fitness_exp_date))->format('d-F-Y'),
            'vehicle_details_pollution_exp_date' => (new Carbon($this->vehicle_details_pollution_exp_date))->format('d-F-Y'),
            'vehicle_details_insurance_holder_name' => $this->vehicle_details_insurance_holder_name,
            'vehicle_details_insurance_exp_date' => (new Carbon($this->vehicle_details_insurance_exp_date))->format('d-F-Y'),
            'updated_at' => Carbon::now()
                ]);
            session()->flash('message', 'Step 3 updated successfull !!'.$this->vehicle_id.' and '.$this->vehicle_details_id);

        }else{
            $vehicle_details_id = DB::table('vehicle_details')->insertGetId([
                'vehicle_details_vheicle_id' => $this->vehicle_id,
                'vehicle_details_added_type' => 1,
                'vehicle_details_added_by' => $this->partner_id,
                'vehicle_details_vheicle_id' => $this->vehicle_id,
                'vehicle_details_fitness_certi_img' => $vehicle_details_fitness_certi_imgFilename ? 'assets/vehicle/'.$vehicle_details_fitness_certi_imgFilename : '',
                'vehicle_details_insurance_img' => $vehicle_details_insurance_imgFilename ? 'assets/vehicle/'.$vehicle_details_insurance_imgFilename : '',
                'vehicle_details_pollution_img' => $vehicle_details_pollution_imgFilename ? 'assets/vehicle/'.$vehicle_details_pollution_imgFilename : '',
                'vehicle_details_fitness_exp_date' => $this->vehicle_details_fitness_exp_date,
                'vehicle_details_pollution_exp_date' => $this->vehicle_details_pollution_exp_date,
                'vehicle_details_insurance_holder_name' => $this->vehicle_details_insurance_holder_name,
                'vehicle_details_insurance_exp_date' => $this->vehicle_details_insurance_exp_date,
                'vehicle_details_added_by' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
                 ]);
                $this->vehicle_details_id=$vehicle_details_id;
                 session()->flash('message', 'Step 3 successfull !!'.$this->vehicle_id.'and'.$this->vehicle_details_id);
        }
       
        $this->isStep3FormSubmitted = true;
        DB::commit();
   } 
    catch (\Exception $e) {
       session()->flash('message', 'Step 3 something went wrong!!'.$e->getMessage());
       DB::rollback();
       \Log::error('Error occurred while processing step5Form: ' . $e->getMessage());
   }
}
public function editDriver($id){

    return view('livewire.admin.update-driver-component');

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
    }
    public function ambulanceFacilitiesByCatType(){
        $ambulanceFacilityByCatType = DB::table('ambulance_facilities')->where(['ambulance_facilities_category_type' =>'C_AC'])
            ->get();
            return $ambulanceFacilityByCatType;
    }

    public function vehicleData(){
        $vehicileData = DB::table('ambulance_category_vehicle')
            ->select('ambulance_category_vehicle_id','ambulance_category_vehicle_name')
            ->where('ambulance_category_vehicle_status', 0)
            ->get();
            return $vehicileData;
}
}
