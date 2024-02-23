
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
          #calendar{
        padding: 10px;
        margin: 10px;
        width: 100%;
        height: 100%;
        border:2px solid red;
    }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://momentjs.com/downloads/moment.min.js"></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.js'></script>
        <link rel='stylesheet' href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css" /></head>
<body>
    
<div class="container-fluid">
    <!-- Calendar Container -->
    <div class="card-box mb-30">
        <div class="pd-20">
            <p class="text-danger">Calendar Booking Table</p>
        </div>
        <div class="px-5 w-75 mx-auto pb-5">
            <div id='calendar'></div>

        </div>
    </div>

    <!-- Include FullCalendar JavaScript -->
    <script>
  $(document).ready(function() {
            var events = {!! $formattedEvents !!}; // Convert PHP array to JavaScript object

            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                events: events // Assign the events array to FullCalendar
            });
        });
</script>

 

</div>
</body>
</html>
