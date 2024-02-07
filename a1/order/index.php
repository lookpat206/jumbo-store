<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Calendar Example</title>
  <!-- FullCalendar CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" integrity="sha512-W2lUqUj/Ou32lTe3Z/rfexi0cT2K9hj0Ijh3a8wF1EeRvStiV1vTsEqpz0Df6JicU2r0jm91imNX2q1uB7h8AQ==" crossorigin="anonymous" />
</head>
<body>

<div id="calendar"></div>


  <!-- FullCalendar JavaScript -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha512-KJ3eVLpQYbLiYGBjNVrj4YxzyPQwF6q9z9T8FVXVfI9qL0qJ/ScpDqSYzoT+EY86iWrwgv9m2B+DScJuvQHVlQ==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-yUz8votyFP2RfN+Cjj6EJlu0vKrP7DO7sFm3Tckl2qfMBdx+nEqKHC+kOkcNcpF+0sMMnbX+Xp5j/UHaSlaM2oQ==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js" integrity="sha512-ZU+86hTu6j2GzEXzmKfDE8iB5WlkgIEx5X9+8qdbbXiq6W/pGJxX8Y94Z3KGYiO7JC0HeE16JWOCpEUBDsCjAw==" crossorigin="anonymous"></script>

  <script>
  $(document).ready(function() {
    // Initialize FullCalendar
    $('#calendar').fullCalendar({
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay'
      },
      events: [
        {
          title: 'Event 1',
          start: '2024-01-01'
        },
        {
          title: 'Event 2',
          start: '2024-01-05',
          end: '2024-01-07'
        },
        // Add more events as needed
      ]
    });
  });
</script>

</body>
</html>
