<?php

namespace App\Livewire\Admin\Notification;
use Illuminate\Support\Facades\DB; 
use Livewire\Component;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App\Models\Notification;


class NotificationComponent extends Component
{
    public $activeTab,$notificationTitle, $notificationBody, $driverselectedStatus, $driverselectedduty, $driverselectedupdatedTime, $driverselectedState, $driverselectedCity,$consumerStatus,$consumerselectedCity,$notificationbody,$notificationtitle;

    public function filterCondition($value){

        if($value=='null'){
            $this->activeTab=$value;
        }
        if($value=='Consumer'){
            $this->activeTab=$value;
        }
       
       
  }
  public function updatingsearch(): void
  {
   $this->resetPage();
  }
    public function render()
    {
        ($this->activeTab == 'Consumer');{

            return view('livewire.admin.notification.notification-component');
        }
        
        return view('livewire.admin.notification.notification-component');
    }

    public function sendNotificationDriver()
    {
        $validatedData = $this->validate([
            'notificationTitle' =>'required', 
            'notificationBody' => 'required',
            'driverselectedStatus' => 'required',
            'driverselectedduty' => 'required',
            'driverselectedupdatedTime' => 'required',
            'driverselectedState' => 'required',
            'driverselectedCity' => 'required',
        ], [
             'notificationTitle.required' => 'Please Add The Notifiation Title Name',
             'notificationBody.required' => 'Please Add The Notifiation Body',
             'driverselectedStatus.required' => 'Please Add The Driver Status',
             'driverselectedduty.required' => 'Please Choose The Driver Duty Status',
             'driverselectedupdatedTime.required' => 'Please Choose The Drkiver Updated Time',
             'driverselectedState.required' => 'Please Choose The Driver State Name',
             'driverselectedCity.required' => 'Please Choose The Driver City Name',
         ]);

        $driver_status = $this->driverselectedStatus;
        $driver_duty_status = $this->driverselectedduty;
        $driver_time_status = $this->driverselectedupdatedTime;
        $state_id = $this->driverselectedState;
        $city_id = $this->driverselectedCity;
        
        $query = DB::table('driver')
            ->leftjoin('driver_live_location', 'driver_live_location.driver_live_location_d_id', '=', 'driver.driver_id')
            ->orderBy('driver.driver_id', 'desc');
        
        if ($driver_status != 'All') {
            $query->where('driver.driver_status', $driver_status);
        }
        
        if ($driver_duty_status != 'All') {
            $query->where('driver.driver_duty_status', $driver_duty_status);
        }
        
        if (!empty($city_id)) {
            $query->where('driver.driver_city_id', $city_id);
        }
        
        if ($driver_time_status == 'week') {
            $weekStartDate = now()->startOfWeek()->format('U');
            $query->where('driver_live_location.driver_live_location_updated_time', '>', $weekStartDate);
        } elseif ($driver_time_status == 'Month') {
            $monthStartDate = now()->startOfMonth()->format('U');
            $query->where('driver_live_location.driver_live_location_updated_time', '>', $monthStartDate);
        }
        // No additional time-based filter for 'All'
        
        $data = $query->get();
                    
         if(count($data) > 0){   

                    //...............................notification..................................
                            
                            foreach($data as $key)
                            {
                                $driver_id = $data_list['driver_id']  = $key->driver_id;
                                $driver_fcm_token = $data_list['driver_fcm_token'] = $key->driver_fcm_token;

                                $i =0;
                                $title = $validatedData['notificationTitle'];
                                $sound="default";
                                $image="https://madmin.cabmed.in/site_img/title_icon.png";
                                $key='3';
                                $key2 =  $driver_id; 
                            
                                $body=  $validatedData['notificationBody']; 
                                $result = $this->multiple_notification_msg($driver_fcm_token,$title,$body,$sound,$image,$key,$key2);
                            }

                           //...............................notification..................................

                                   session()->flash('activeMessage', 'Notification send Driver successfully By Medcab.');
                               }
                           else{
                            session()->flash('inactiveMessage', 'Something Went Wroung.....');
                        }        
            
        
    }

    public function sendNotificationConsumer(){
        $validatedData = $this->validate([
            'notificationtitle' =>'required', 
            'notificationbody' => 'required',
            'consumerStatus' => 'required',
        ], [
            'notificationtitle.required' => 'Please Add The Notification Title Name',
            'notificationbody.required' => 'Please Add The Notification Body',
            'consumerStatus.required' => 'Please Add The Consumer Status',
        ]);

        $consumerStatus = $this->consumerStatus;
    
        $query = DB::table('consumer')
                ->orderBy('consumer_id', 'desc');  
                if ($consumerStatus != 'All') {
                    $query->where('consumer.consumer_status', $consumerStatus);
                }

       $data = $query->get();
    
        if (!empty($data)) {
            // Loop through consumers
            foreach ($data as $key) {
                $consumer_id = $key->consumer_id;
                $consumer_name = $key->consumer_name; // Adjusted variable name
                $consumer_fcm_token = $key->consumer_fcm_token;
    
                $title = $validatedData['notificationtitle'];
                $sound = "default";
                $image = "https://madmin.cabmed.in/site_img/title_icon.png";
                $key = '3';
                $key2 = $consumer_id;
    
                $body=  $validatedData['notificationbody']; 
                $result = $this->multiple_notification_msg($consumer_fcm_token, $title, $body, $sound, $image, $key, $key2);
    
            }        
    
            // Return success response
            session()->flash('activeMessage', 'Notification sent to consumers successfully by Medcab.');
        } else {
            // No consumers found
            session()->flash('inactiveMessage', 'No consumers found.');
        }
    }
    
    

    public function multiple_notification_msg($id = NULL,$title,$body,$sound,$image=NULL,$key,$key2)
    {
       $Notification = new Notification();
       $data="";
       $payload['data_object'] = json_encode($data );
       $push_type = 'individual';
       $Notification->setTitle($title);
       $Notification->setMessage($body);
       $Notification->setSound($sound);
       $Notification->setKey($key);
       $Notification->setKey2($key2);
       if (!empty($image)) {
           $Notification->setImage('');
       } else {
           $Notification->setImage('');
       }
       $Notification->setPayload($payload);
       $json = '';
       $response = '';
       $json = $Notification->getPush();
       $response = $Notification->send($id, $json);
   }

}
