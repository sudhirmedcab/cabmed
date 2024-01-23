<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Employee;

class EmployeeList extends Component
{
    public $employees, $name, $position, $employee_id;
    public $isOpen = 0;

    public function render()
    {

        $this->employees = Employee::all();

        return view('livewire.employee-list');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    private function resetInputFields(){
        $this->name = '';
        $this->position = '';
        $this->employee_id = '';
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'position' => 'required',
        ]);

        Employee::updateOrCreate(['id' => $this->employee_id], [
            'name' => $this->name,
            'position' => $this->position
        ]);

        session()->flash('message', $this->employee_id ? 'Employee Updated Successfully.' : 'Employee Created Successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $this->employee_id = $id;
        $this->name = $employee->name;
        $this->position = $employee->position;

        $this->openModal();
    }

    public function delete($id)
    {
        Employee::find($id)->delete();
        session()->flash('message', 'Employee Deleted Successfully.');
    }
}
