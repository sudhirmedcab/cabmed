<?php

namespace App\Livewire\Admin;
use Illuminate\Support\Facades\DB; 
use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithPagination;

class ConsumerComponent extends Component
{
    public $employees0, $id, $name, $email, $position, $employee_id,$show,$fromdate ,$todate,$dateOption,$from_filter,$to_filter,$date_filter;
    public $isOpen = 0;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    // 
    public $search = '';
    public $sortBy = 'name';
    public $sortDirection = 'asc';

    public $title = 'All Consumer...';
 
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

        $data['consumers'] = DB::table('consumer')
        ->leftJoin('remark_data', 'consumer.consumer_id', '=', 'remark_data.remark_consumer_id')
        ->leftJoin('admin', 'admin.id', '=', 'remark_data.remark_type')  
        ->where('consumer.consumer_name', 'like', '%' . $this->search . '%')
        ->when($fromdate && $todate, function ($query) use ($fromdate, $todate) {
            return $query->whereBetween('consumer.created_at', [$fromdate, $todate]);
        })        ->when($status !== null, function ($query) use ($status) {
            return $query->where('consumer.consumer_status', $status);
        })
        ->when($status === null, function ($query) {
            return $query->whereIn('consumer.consumer_status', [1, 0]);
        })
        ->select('consumer.*','remark_data.*','admin.*','consumer.created_at')
        ->where('consumer.consumer_status','<>','2')
        ->orderBy('consumer_id','desc')
        ->paginate(10);

        if ($fromdate && $todate) {
            $data['consumer_filter'] = ($this->show == '1' ? 'Active' : ($this->show == '0' ? 'New' : 'All'))
                . ' Consumer Data From ' . $fromdate->format('j F H:i:s A') . ' To ' . $todate->format('j F H:i:s A');
        } else {
            $data['consumer_filter'] = 'All '.($this->show == '1' ? 'Active Consumer' : ($this->show == '0' ? ' New Consumer' : 'Consumer')). ' Data From ';
        }

        $filterValue = $this->from_filter && $this->to_filter;
        $notfilterValue = $this->date_filter;

        return view('livewire.admin.consumer-component',$data,[
            'filterValue' => $filterValue,
            'notfilterValue' => $notfilterValue,
        ]);

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
        $consumerDelete = DB::table('consumer')->where('consumer_id',$id)->update(['consumer_status'=>'2']);

        session()->flash('message', 'Consumer Deleted Successfully.');
        session()->flash('type', 'delete');
    }

    public function showNested($value)
    {
    $this->show = $value;

    }
}
