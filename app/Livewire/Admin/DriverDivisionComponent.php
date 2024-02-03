<?php

namespace App\Livewire\Admin;
use Illuminate\Support\Facades\DB; 
use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithPagination;

class DriverDivisionComponent extends Component
{
    public $driver_division ='division componet called';
    public $employees0,$selectedDate,$filterConditionl, 
    $selectedFromDate,$selectedToDate, $fromDate=null, 
    $toDate=null,$fromdate, $todate, $id, $name, $email,
    $position, $employee_id, $driver_status=null, $driver_duty_status=null,
    $driverUnderVerBySelf=null,
    $driverUnderVerByPartner=null,
    $activeTab,
    $division,
    $walletBalanceFilter,
    $driverVerificationStatus = 'null';

    #[Layout('livewire.admin.layouts.base')]    //......... add the layout dynamically for the all ...........//
public function mount(){
}
    public function DriverDivision(){

        $state = DB::table('state')
        ->leftJoin('division', 'state.state_id', '=', 'division.division_state_id')
        ->leftJoin('city', 'division.division_id', '=', 'city.city_division')
        ->leftJoin('driver as drv', 'city.city_id', '=', 'drv.driver_city_id')
        ->selectRaw('state.state_id,
                     state.state_name, 
                     COUNT(DISTINCT division.division_id) as division_count,
                     COUNT(DISTINCT drv.driver_id) as total_driver_count')
        ->groupBy('state.state_id', 'state.state_name')
        ->get();
            
            $total_driver =  DB::table('driver')->get();   
                return view('dashboard.user.pages.driver.driver_count_division', compact('total_driver','state'));
        }

    public function render()
    {
        dd('asdfghj');
        $state = DB::table('state')
        ->leftJoin('division', 'state.state_id', '=', 'division.division_state_id')
        ->leftJoin('city', 'division.division_id', '=', 'city.city_division')
        ->leftJoin('driver as drv', 'city.city_id', '=', 'drv.driver_city_id')
        ->selectRaw('state.state_id,
                     state.state_name, 
                     COUNT(DISTINCT division.division_id) as division_count,
                     COUNT(DISTINCT drv.driver_id) as total_driver_count')
        ->groupBy('state.state_id', 'state.state_name')
        ->get();
        $total_driver =  DB::table('driver')->get();  
        
        // ........
        $stateName = 27;

        $results = DB::table('division')
         ->leftJoin('city', 'city.city_division', '=', 'division.division_id')
         ->leftJoin('driver', 'driver.driver_city_id', '=', 'city.city_id')
         ->leftJoin('state', 'state.state_id', '=', 'division.division_state_id')
         ->where('state.state_id', $stateName) // Filter by state ID
         ->selectRaw('state.state_name, division.division_name, 
                     COALESCE(COUNT(driver.driver_id), 0) as total_driver_count,
                     SUM(CASE WHEN driver.driver_duty_status = "ON" THEN 1 ELSE 0 END) as on_duty_count,
                     SUM(CASE WHEN driver.driver_duty_status = "OFF" THEN 1 ELSE 0 END) as off_duty_count')
         ->groupBy('state.state_name', 'division.division_name')
         ->orderBy('state.state_name', 'asc')
         ->orderBy('division.division_name', 'asc')
         ->get();
     
         // dd($results);
     
         $sumDriverCountsByDivision = $results->sum('total_driver_count');
      
         $state = DB::table('state')
         ->leftJoin('division', 'state.state_id', '=', 'division.division_state_id')
         ->leftJoin('city', 'division.division_id', '=', 'city.city_division')
         ->leftJoin('driver as drv', 'city.city_id', '=', 'drv.driver_city_id')
         ->selectRaw('state.state_id,
                      state.state_name, 
                      COUNT(DISTINCT division.division_id) as division_count,
                      COUNT(DISTINCT drv.driver_id) as total_driver_count')
         ->groupBy('state.state_id', 'state.state_name')
         ->get();
     
             $total_driver =  DB::table('driver')->get();   
             
        // ........

 
        return view('livewire.admin.driver-division-component',['results' => $results, 'total_driver'=>$total_driver,'state'=>$state,'sumDriverCountsByDivision'=>$sumDriverCountsByDivision]);
        // return view('livewire.admin.driver-division-component',['total_driver'=>$total_driver, 'state' =>$state]);
    }
}
