<?php

//Load the third-party FullCalendar library into the page and use AJAX to add persistence
require_once('lib/ViewManager.php');
class LeavePlannerView extends ViewManager
{
	private $pageName = "Leave Planner";
	
	public function __construct($dbLink)
	{
		parent::__construct($this->pageName, self::pageContent(), $dbLink);
	}
	
	//The page contents specific to this page - Most of this is to load in the third-party FullCalendar library
	public function pageContent()
	{
		$content = "
<link href='fullcalendar/packages/core/main.css' rel='stylesheet' />
<link href='fullcalendar/packages/daygrid/main.css' rel='stylesheet' />
<link href='fullcalendar/packages/daygrid/main.css' rel='stylesheet' />
<link href='fullcalendar/packages/timegrid/main.css' rel='stylesheet' />
<link href='fullcalendar/packages/list/main.css' rel='stylesheet' />
<script src='fullcalendar/packages/core/main.js'></script>
<script src='fullcalendar/packages/daygrid/main.js'></script>
<script src='fullcalendar/packages/interaction/main.js'></script>
<script src='fullcalendar/packages/daygrid/main.js'></script>
<script src='fullcalendar/packages/timegrid/main.js'></script>
<script src='fullcalendar/packages/list/main.js'></script>
<script src='fullcalendar/packages/moment/main.js'></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list', 'moment' ],
      header: {
        left: 'prev,next',
        center: 'title',
        right: 'today'
      },
      navLinks: true, // can click day/week names to navigate views
      selectable: true,
      selectMirror: true,
      select: function(arg) {
        var title = prompt('Reason for request:');
        if (title) {
		var startDate = (new Date(arg.start)).toISOString().slice(0, 10);
		var endDate = (new Date(arg.end)).toISOString().slice(0, 10);
		$.ajax({
            	url: 'Ajax.php?action=addLeave',
                data: 'type=' + title + '&start=' + startDate + '&end=' + endDate + '&id=' + ".$_SESSION['userID'].",
                type: 'GET',
                success: function () {
                	alert('Request created');
                }
            });
          calendar.addEvent({
            title: 'Annual Leave',
            start: arg.start,
            end: arg.end,
            allDay: arg.allDay
          })
        }
        calendar.unselect()
      },
      editable: true,
      eventLimit: false,
      events: {
        url: 'Ajax.php?action=myLeave&empID=".$_SESSION['userID']."'
      }
    });

    calendar.render();
  });

</script>
<div id='calendar'></div>
";
		return $content;
	}
}

?>