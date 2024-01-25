<?php

namespace App\Livewire\Admin;
use Illuminate\Support\Facades\DB; 
use Livewire\Component;
use Illuminate\Validation\Rule;

class ManageDriverComponent extends Component
{
    public $status, $data, $id, $create_for, $driver_name, $driver_mobile, $partner_id, $vehicle_rc_no, $driver_first_name, $driver_last_name, $employee_id;
   
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
    public function store(){
 
        $this->validate([
            'driver_first_name' => 'required',
            'driver_last_name' => 'required',
            'driver_mobile' => [
                'required',
                'numeric',
                'digits:10',
                Rule::unique('driver','driver_mobile')
            ],
            'vehicle_rc_no' => 'required',
            'partner_id' => $this->create_for == 1 ? 'required' : 'nullable'
        ]);

        $data = [
            'driver_created_by' => $this->create_for,
            'driver_name' => $this->driver_first_name,
            'driver_last_name' => $this->driver_last_name,
            'driver_mobile' => $this->driver_mobile,
            'driver_created_partner_id' => $this->create_for == 1 ? $this->partner_id : 0,
        ];
        $status = DB::table('driver')->insert($data);
         if($status){
            session()->flash('message', 'Driver Created Successfully.');
        } else{
            session()->flash('message', 'somethingwent wrong !!');
        }


    }
}
