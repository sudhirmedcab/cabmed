<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Employee;
use Livewire\WithPagination;
class EmpList extends Component
{
    public $employees0, $id, $name, $email, $position, $employee_id;
    public $isOpen = 0;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
// 
public $search = '';
public $sortBy = 'name';
public $sortDirection = 'asc';

// protected $queryString = ['search', 'sortBy', 'sortDirection'];
// 
    public function render()
    {
         // $this->employees = Employee::all();
        // $this->employees = Employee::paginate(2);

        // return view('livewire.emp-list', [
        //     'employees' => $employees,
        // ]);
        // return view('livewire.home-component')->layout('livewire.admin.layouts.base');
        // return view('livewire.home-component')->layout('livewire.admin.layouts.base');

        // return view('livewire.emp-list',[
        //     'employees' => Employee::paginate(4),
        // ])->layout('livewire.admin.layouts.base');

        $employee = Employee::where('name', 'like', '%' . $this->search . '%')
                    ->orderBy('id','DESC')
                    ->paginate(5);
                    // dd($employee);
        return view('livewire.emp-list',[
            'employees' => $employee,
            'search' => $this->search
        ])->layout('livewire.admin.layouts.base');
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
