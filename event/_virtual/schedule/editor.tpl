<div>
	<h2 class="cpn-header">[af.title]</h2>
	<div id="panel-calendar-container">
		<div class="cpn-default" id="panel-calendar"></div>
	</div>
</div>


<style>
#panel-calendar {
	width:100%;
	height:100%;
}

#panel-calendar-container {
	position:fixed;
	top:0;
	left:0;
	z-index:0;
	padding:152px 0 44px 0;
	height:100%;
	width:100%;
}

#panel-calendar-container>div {
	display:inline-block;
	padding:0;
}

#panel-calendar-container>div .fc-header-left,
#panel-calendar-container>div .fc-header-center,
#panel-calendar-container>div .fc-header-right {
	padding:10px 10px 0 10px;
}

#panel-calendar-container .fc-content {
	overflow-y:scroll;
	width:100%;
	height:100%;
}

#panel-calendar-container .fc-view {
	width:100%;
}

.resource-room-0 { background:rgba(255,0,0,0.1); }
.resource-room-1 { background:rgba(0,200,0,0.1); }
.resource-room-2 { background:rgba(0,0,255,0.1); }
.resource-room-3 { background:rgba(255,255,0,0.1); }

.fc-agenda-slots tbody tr:nth-child(4n+1) {
	background:rgba(0,0,0,0.1);
}

#panel-calendar .fc-content {
	background:#fff;
}

#panel-calendar .fc-event {
	opacity:0.9;
/*	border: 1px solid #00C8E6;
	background-color: #006E7E;
	color: #fff; */
}
</style>

<script>
[onshow;block=script;when [user.permission.admin]=1]
$(function() {
	var eventTime = function(event) {
		console.log(event);
		event.start.stripZone();
		event.end.stripZone();
		$.post('[afurl.base]/event/[event.event_name;f=urlname]/schedule/time', {
			id:		event.id,
			start:	event.start.toISOString(),
			end:	event.end.toISOString(),
			room:	event.resources[0],
		});
	}

	$('#panel-calendar').fullCalendar({
		customButtons: {
			rooms: {
				text: 'Edit Rooms (start here)',
				click: function() {
					popup('[afurl.base]/event/[event.event_name;f=urlname]/schedule/rooms')
				}
			},
		},

		theme:			true,
		header:			{ left:'title', center:'rooms', right:'prev,next' },
		defaultDate:	'[event.event_start;date=Y-m-d]',
		editable:		true,
		droppable:		true,
		defaultView:	'resourceDay',
		slotDuration:	'00:15:00',
		height:			4000,
		allDaySlot:		false,
		timezone:		false,
		firstDay:		3,
		selectable:		true,
		selectHelper:	true,
		resources:		[rooms;json],
		events:			[cal;json],
		eventResize:	eventTime,
		eventDrop:		eventTime,

		select: function(start, end, event) {
			if (event.data.id !== undefined) {
				popup('[afurl.base]/event/[event.event_name;f=urlname]/schedule/add?'+$.param({
					id:		[event.event_id],
					start:	start.toISOString(),
					end:	end.toISOString(),
					room:	event.data.id,
				}), 'Add Panel');
			}
			$(this).fullCalendar('unselect');
		},

		eventClick: function(event) {
			popup('[afurl.base]/event/[event.event_name;f=urlname]/schedule/edit?'+$.param({
				id: event.id,
			}), 'Edit Panel');
		},
	});

});
</script>
