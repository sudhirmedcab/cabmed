<?php

namespace App\Livewire\Admin\Ambulance;
use Illuminate\Support\Facades\DB; 
use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;
use Livewire\WithoutUrlPagination;

class BookingCalenderComponent extends Component
{
    public $selectedDate,$filterConditionl, 
    $selectedFromDate,$selectedToDate, $fromDate=null, 
    $toDate=null,$fromdate, $todate,$selectedBookingType,$check_for,$selectedbookingStatus,
    $activeTab,$events = [];

    
    public function render()
    {
      
       // Fetch event data from the database
       $data = DB::table('booking_view')
       ->selectRaw('booking_id,
           booking_schedule_time as event_date,
           SUM(booking_status = "6") as Future,
           SUM(booking_status = "2") as Ongoing,
           SUM(booking_status = "1") as New'
       )
       ->whereIn('booking_status', [1, 2, 6])
       ->groupBy('event_date', 'booking_id')
       ->get();
   
// Format event data for FullCalendar
$events = [];

foreach ($data as $event) {
    $eventColor = '';
    if ($event->Future > 0) {
        $eventColor = 'Tomato';
    } elseif ($event->Ongoing > 0) {
        $eventColor = 'MediumSeaGreen';
    } elseif ($event->New > 0) {
        $eventColor = 'Dodgerblue';
    }

    $eventTitle = '';
    if ($event->Future > 0) {
        $eventTitle .= 'Future Booking (' . $event->Future . '), ';
    }
    if ($event->Ongoing > 0) {
        $eventTitle .= 'Ongoing Booking (' . $event->Ongoing . '), ';
    }
    if ($event->New > 0) {
        $eventTitle .= 'New Booking (' . $event->New . ')';
    }

    $events[] = [
        'title' => rtrim($eventTitle, ', '), // Remove the trailing comma and space
        'start' => $event->event_date,
        'end' => $event->event_date, // Assuming events are single-day
        'color' => $eventColor
    ];
}

// Pass the formatted event data to the view
  $formattedEvents = json_encode($events);

        return view('livewire.admin.ambulance.booking-calender-component',compact('formattedEvents'));
    }
}
