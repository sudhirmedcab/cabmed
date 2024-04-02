<?php

namespace App\Livewire\Admin\Dashboard;
use Illuminate\Support\Facades\DB; 
use Livewire\Component;
use Carbon\Carbon;

class DashboardComponent extends Component
{
    public $selectedBookingDate,$selectedHospitalDate,$selecteddriverDate,$selectedvehicleDate,$selectedconsumereDate,$selectedpartnerDate; 

    public function render()
    {
        $BookingDateTime = $this->selectedBookingDate;
        $HospitalDateTime = $this->selectedHospitalDate ? strtotime($this->selectedHospitalDate) : null;
        $driverDateTime = $this->selecteddriverDate;
        $vehicleDateTime = $this->selectedvehicleDate;
        $consumerDateTime = $this->selectedconsumereDate;
        $partnerDateTime = $this->selectedpartnerDate;
    
        $bookingData = DB::table('booking_view')
            ->select(
                DB::raw('SUM(CASE WHEN booking_status = 1 THEN 1 ELSE 0 END) as new_booking'),
                DB::raw('SUM(CASE WHEN booking_status = 2 THEN 1 ELSE 0 END) as ongoing_booking'),
                DB::raw('SUM(CASE WHEN booking_status = 0 THEN 1 ELSE 0 END) as enquiry_booking'),
                DB::raw('SUM(CASE WHEN booking_status = 3 THEN 1 ELSE 0 END) as invoice_booking'),
                DB::raw('SUM(CASE WHEN booking_status = 4 THEN 1 ELSE 0 END) as complete_booking'),
                DB::raw('SUM(CASE WHEN booking_status = 5 THEN 1 ELSE 0 END) as cancel_booking'),
                DB::raw('SUM(CASE WHEN booking_status = 6 THEN 1 ELSE 0 END) as future_booking')
            )
            ->when($BookingDateTime != null, function ($query) use ($BookingDateTime) {
                return $query->whereDate('created_at', $BookingDateTime);
            })
            ->where('booking_status', '!=', 7)
            ->get(); 
            
        $hospitalData = DB::table('hospital_lists')
            ->select(
                DB::raw('SUM(CASE WHEN hospital_id THEN 1 ELSE 0 END) as total_Data'),
                DB::raw('SUM(CASE WHEN hospital_verify_status = 1 THEN 1 ELSE 0 END) as verify_hospital'),
                DB::raw('SUM(CASE WHEN hospital_verify_status = 0 THEN 1 ELSE 0 END) as unverify_hospital'),
            )
            ->when($HospitalDateTime != null, function ($query) use ($HospitalDateTime) {
                return $query->whereDate('hospital_lists.hospital_added_timestamp', $HospitalDateTime);
            })
            ->get(); 

        $hospitalOwnerData = DB::table('hospital_lists')
        ->join('hospital_users', 'hospital_users.hospital_users_id','=','hospital_lists.hospital_user_id')
            ->select(
                DB::raw('SUM(CASE WHEN hospital_users_id THEN 1 ELSE 0 END) as total_hospitals_users'),
                DB::raw('SUM(CASE WHEN hospital_verify_status = 1 THEN 1 ELSE 0 END) as verify_owner'),
                DB::raw('SUM(CASE WHEN hospital_verify_status = 0 THEN 1 ELSE 0 END) as unverify_owner'),
            )
            ->when($HospitalDateTime != null, function ($query) use ($HospitalDateTime) {
                return $query->whereDate('hospital_lists.hospital_added_timestamp', $HospitalDateTime);
            })
            ->get(); 

        $driverData = DB::table('driver')
            ->select(
                DB::raw('SUM(CASE WHEN driver_id THEN 1 ELSE 0 END) as total_driver'),
                DB::raw('SUM(CASE WHEN driver_status = 1 THEN 1 ELSE 0 END) as new_driver'),
                DB::raw('SUM(CASE WHEN driver_status = 0 THEN 1 ELSE 0 END) as active_driver'),
                DB::raw('SUM(CASE WHEN driver_status = 4 THEN 1 ELSE 0 END) as applied_driver'),
                DB::raw('SUM(CASE WHEN driver_created_by = 0 THEN 1 ELSE 0 END) as driver_created_self'),
                DB::raw('SUM(CASE WHEN driver_created_by = 1 THEN 1 ELSE 0 END) as driver_created_partner'),
            )
            ->when($driverDateTime != null, function ($query) use ($driverDateTime) {
                return $query->whereDate('driver.created_at', $driverDateTime);
            })
            ->get(); 

        $vehicleData = DB::table('vehicle')
            ->select(
                DB::raw('SUM(CASE WHEN vehicle_id THEN 1 ELSE 0 END) as total_vehicle'),
                DB::raw('SUM(CASE WHEN vehicle_status = 1 THEN 1 ELSE 0 END) as new_vehicle'),
                DB::raw('SUM(CASE WHEN vehicle_status = 0 THEN 1 ELSE 0 END) as active_vehicle'),
                DB::raw('SUM(CASE WHEN vehicle_status = 4 THEN 1 ELSE 0 END) as applied_vehicle'),
                DB::raw('SUM(CASE WHEN vehicle_added_type = 0 THEN 1 ELSE 0 END) as vehicle_created_driver'),
                DB::raw('SUM(CASE WHEN vehicle_added_type = 1 THEN 1 ELSE 0 END) as driver_created_partner'),
            )
            ->when($vehicleDateTime != null, function ($query) use ($vehicleDateTime) {
                return $query->whereDate('vehicle.created_at', $vehicleDateTime);
            })
            ->get(); 
        
            $dashboardData['bookings'] = !empty($bookingData) ? $bookingData[0] : [];
            $dashboardData['hospital'] = !empty($hospitalData) ? $hospitalData[0] : [];
            $dashboardData['hospitalOwnerdata'] = !empty($hospitalOwnerData) ? $hospitalOwnerData[0] : [];
            $dashboardData['driverData'] = !empty($driverData) ? $driverData[0] : [];
            $dashboardData['vehicleData'] = !empty($vehicleData) ? $vehicleData[0] : [];

            $newConsumer = DB::table('consumer')->where('consumer_status',0) ->when($consumerDateTime != null, function ($query) use ($consumerDateTime) {
                return $query->whereDate('created_at', $consumerDateTime);
            })->count();

            $activeConsumer = DB::table('consumer')->where('consumer_status',1) ->when($consumerDateTime != null, function ($query) use ($consumerDateTime) {
                return $query->whereDate('created_at', $consumerDateTime);
            })->count();

            $newPartner = DB::table('partner')->where('partner_status',0)->when($partnerDateTime != null, function ($query) use ($partnerDateTime) {
                return $query->whereDate('created_at', $partnerDateTime);
            })->count();

            $activePartner = DB::table('partner')->where('partner_status',1) ->when($partnerDateTime != null, function ($query) use ($partnerDateTime) {
                return $query->whereDate('created_at', $partnerDateTime);
            })->count();
    
        $data1 = [
            'labels' => ['New Consumer', 'Active Consumer'],
            'data' => [$newConsumer ?? "0", $activeConsumer ?? "0"],
        ];
        $data2 = [
            'labels' => ['New Partner', 'Active Partner'],
            'data' => [$newPartner ?? "0", $activePartner ?? "0"],
        ];

        return view('livewire.admin.dashboard.dashboard-component', compact('data1', 'data2','dashboardData'));
    }
}
