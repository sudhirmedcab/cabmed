<?php

namespace App\Livewire\Admin;
use Illuminate\Support\Facades\DB; 
use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithPagination;

class DriverComponent extends Component
{
    public $employees0, $id, $name, $email, $position, $employee_id;
    public $isOpen = 0;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    // 
    public $search = '';
    public $sortBy = 'name';
    public $sortDirection = 'asc';

 
    public function render()
    {

        $currentTimestamps = Carbon::now();
        $firstDayOfMonths = Carbon::now()->startOfMonth(); 
        $drivers = DB::table('driver')
        ->leftJoin('driver_details', 'driver.driver_id', '=', 'driver_details.driver_details_driver_id')
        ->leftJoin('vehicle', 'driver.driver_assigned_vehicle_id', '=', 'vehicle.vehicle_id')
        ->leftJoin('city', 'driver.driver_city_id', '=', 'city.city_id')
        ->leftJoin('partner', 'driver.driver_created_partner_id', '=', 'partner.partner_id')
        ->leftJoin('state', 'state.state_id', '=', 'city.city_state')
        ->leftJoin('ambulance_category', 'ambulance_category.ambulance_category_type', '=', 'vehicle.vehicle_category_type')
        ->leftJoin('remark_data', 'driver.driver_id', '=', 'remark_data.remark_driver_id')
        // ->whereBetween(('driver.created_at'), [$firstDayOfMonths, $currentTimestamps])
        ->where('driver.driver_name', 'like', '%' . $this->search . '%')
        ->select('driver_details.*','ambulance_category.*','remark_data.*', 'vehicle.*', 'city.*', 'partner.*', 'state.*', 'driver.driver_id', 'driver.driver_name', 'driver.driver_last_name', 'driver.driver_mobile','driver.driver_wallet_amount','driver.driver_duty_status','driver.join_bonus_status', 'driver.driver_on_booking_status','driver.driver_created_by', 'driver.created_at', 'driver.driver_verify_date','driver.driver_status')
        ->orderBy('driver.driver_id', 'desc')
        ->paginate(10);

// dd($drivers);


        // $employee = Employee::where('name', 'like', '%' . $this->search . '%')
        // ->orderBy('id','DESC')
        // ->paginate(5);
        // dd($employee);
        return view('livewire.admin.driver-component',[
        'drivers' => $drivers,
        ])->layout('livewire.admin.layouts.base');


        return view('livewire.admin.driver-component');
    }
    public function create()
    {
        // dd('Data:: ',$this);
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
    public function store()
    {

        $this->validate([
            'name' => 'required',
            'email' => 'required',
            'employee_id' => 'required',
            'position' => 'required',
        ]);
        // dd($this);
        Employee::updateOrCreate(['id' => $this->id], [
            'name' => $this->name,
            'email' => $this->email,
            'position' => $this->position,
            'employee_id' => $this->employee_id
        ]);

        session()->flash('message', $this->employee_id ? 'Employee Updated Successfully.' : 'Employee Created Successfully.');
        session()->flash('type', 'store');
        $this->closeModal();
        $this->resetInputFields();
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
        // dd('id is ::',$id);
        Employee::find($id)->delete();
        session()->flash('message', 'Employee Deleted Successfully.');
        session()->flash('type', 'delete');
    }
}
