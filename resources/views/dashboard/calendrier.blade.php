@extends('layouts.admin',['projectId'=>$project->id])

@section('projectName')
    {{$project->name}}
@endsection


@section('css')

<link href={{ asset('packages/main.css') }} rel='stylesheet' />
<script src={{ asset('packages/main.js') }}></script>



<style>
#calendar {
    width: 80%;
    margin: 0 auto;
    background-color:#fff;
  }
</style>

@endsection

    
@section('content')

<div id='calendar'></div>

@endsection




@section('js')

<script src={{ asset('packages/locales-all.js') }}></script>



<script>

function agenda(response)
{
        
          var calendarEl = document.getElementById('calendar');
      
          var calendar = new FullCalendar.Calendar(calendarEl, {
      locale:'fr',
      initialDate: '2020-09-12',
      initialView: 'timeGridWeek',
      nowIndicator: true,
      allDaySlot:false,
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
      },
      navLinks: true, // can click day/week names to navigate views
 
      dayMaxEvents: true, // allow "more" link when too many events
      events: [
        {
          title: 'All Day Event',
          start: '2020-09-01',
        },
        {
          title: 'Long Event',
          start: '2020-09-07',
          end: '2020-09-10'
        },
        {
          groupId: 999,
          title: 'Repeating Event',
          start: '2020-09-09T16:00:00'
        },
        {
          groupId: 999,
          title: 'Repeating Event',
          start: '2020-09-16T16:00:00'
        },
        {
          title: 'Conference',
          start: '2020-09-11',
          end: '2020-09-13'
        },
        {
          title: 'Meeting',
          start: '2020-09-12T10:30',
          end: '2020-09-12T12:30'
        },
       
        {
          title: 'Meeting',
          start: '2020-09-12T14:30:00'
        },
        {
          title: 'Happy Hour',
          start: '2020-09-12T17:30:00'
        },
        {
          title: 'Dinner',
          start: '2020-09-12T20:00:00'
        },
        {
          title: 'Birthday Party',
          start: '2020-09-13T07:00:00'
        },
        {
          title: 'Click for Google',
          url: 'http://google.com/',
          start: '2020-09-28'
        }
      ],

      businessHours:[ {
  // days of week. an array of zero-based day of week integers (0=Sunday)
  daysOfWeek: [ 1, 2, 3, 4,5,6,7 ], // Monday - Thursday

  startTime: '08:00', // a start time (10am in this example)
  endTime: '19:00', // an end time (6pm in this example)
},
 ]
    });

    calendar.render(); 
     
        }






( function ( $ ) {

        var charts = {
            init: function () {
                
                $.ajax({
        
        url: "http://localhost/gestion-projet/public/allDataAgenda",
        type:"GET",
        success:function(response){
          console.log(response);
          agenda(response);
        },
       });


            },
        };
    
        charts.init();

    
    } )( jQuery );




      
      </script>
      
@endsection