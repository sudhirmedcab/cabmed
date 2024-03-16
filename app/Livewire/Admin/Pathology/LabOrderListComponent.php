<?php

namespace App\Livewire\Admin\Pathology;
use Illuminate\Support\Facades\DB; 
use Livewire\Component;
use Carbon\Carbon;
use App\models\consumer;
use App\Models\Notification;
// use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class LabOrderListComponent extends Component
{
    public $selectedDate,$filterConditionl, 
    $selectedFromDate,$selectedToDate, $fromDate=null, 
    $toDate=null,$fromdate, $todate,$check_for,$orderStatusFilter;

    public $search = '';
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $dexpnameSearch = '';
    public $sortBy = 'name';
    public $sortDirection = 'asc';

    public function render()
    {
        $orderStatusFilter = $this->orderStatusFilter ? $this->orderStatusFilter : "New";

        $fromDate = $this->selectedFromDate ? strtotime($this->selectedFromDate) : null;
        $toDate = $this->selectedToDate ?  strtotime($this->selectedToDate) : null;

        if($this->selectedFromDate && $this->selectedToDate){
            $this->selectedDate = null;     
        }
        
        if($this->selectedDate == 'custom'){
            $this->selectedFromDate;
            $this->selectedToDate;
        }else{
            $this->selectedFromDate ='';
            $this->selectedToDate =''; 
        }

        switch ($this->selectedDate) {
            case 'all':
                $fromDate = null;
                $toDate = null;
                break;
            case 'today':
                $fromDate = strtotime(date('Y-m-d'));
                $toDate = strtotime(date('Y-m-d').' 23:59:59');
                break;
            case 'yesterday':
                $fromDate = strtotime('-1 day', strtotime(date('Y-m-d')));
                $toDate = strtotime('-1 day', strtotime(date('Y-m-d').' 23:59:59'));
                break;
            case 'thisWeek':
                $fromDate = strtotime('-7 days', strtotime(date('Y-m-d')));
                $toDate = strtotime(date('Y-m-d').' 23:59:59');
                break;
            case 'thisMonth':
                $fromDate = strtotime(date('Y-m-01'));
                $toDate = strtotime(date('Y-m-t').' 23:59:59');
                break;
            default:
                $fromDate = $fromDate;
                $toDate = $toDate;
                break;
        }

                $lab_order = DB::table('customer_lab_order')
                ->leftJoin('city', 'city.city_id', '=', 'customer_lab_order.clo_address_city_id')
                ->leftJoin('state', 'state.state_id', '=', 'city.city_state')
                ->where(function ($query) {
                    $query->where('customer_lab_order.clo_customer_name', 'like', '%' . $this->search . '%')
                        ->orWhere('customer_lab_order.clo_contact_no', 'like', '%' . $this->search . '%');
                }) 
                ->orderByDesc('customer_lab_order.customer_lab_order_id')
                ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                    return $query->whereBetween('customer_lab_order.clo_order_time', [$fromDate, $toDate]);
                })
                ->when($orderStatusFilter == 'AllVerification', function ($query) use ($orderStatusFilter){
                    return $query->whereIn('customer_lab_order.clo_status',[1,2,3,4]);
                        })
                 ->when($orderStatusFilter == 'New', function ($query) use ($orderStatusFilter){
                    return $query->where('customer_lab_order.clo_status',1);
                        })
               ->when($orderStatusFilter == 'Ongoing', function ($query) use ($orderStatusFilter){
                   return $query->where('customer_lab_order.clo_status',2);
                         })
                ->when($orderStatusFilter == 'Completed', function ($query) use ($orderStatusFilter){
                          return $query->where('customer_lab_order.clo_status',4);
                       })
                ->when($orderStatusFilter == 'Cancelled', function ($query) use ($orderStatusFilter){
                          return $query->where('customer_lab_order.clo_status',3);
                       })
                ->paginate(10);
        
                $lab_test_data = []; // Initialize an empty array to hold the grouped data.
            
                foreach ($lab_order as $key) {
                    $orderId = $key->customer_lab_order_id;
            
                    $lab_test_details = DB::table('customer_lab_order_test')
                        ->leftJoin('lab_test', 'lab_test.lab_test_id', '=', 'customer_lab_order_test.clot_test_id')
                        ->where('customer_lab_order_test.clot_order_id', $orderId)
                        ->get();
            
                    $lab_test_data[$orderId] = $lab_test_details;
                }

           if($this->check_for == 'custom'){
            return view('livewire.admin.pathology.lab-order-list-component',['isCustom'=>true],compact('lab_order', 'lab_test_data'));
            }else {
               return view('livewire.admin.pathology.lab-order-list-component',['isCustom'=>false],compact('lab_order', 'lab_test_data'));
           } 

        }


    }

