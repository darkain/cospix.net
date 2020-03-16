<style>#add-calendar .ui-widget-header{font-size:1em;}</style>

<table style="width:100%">
	<tr>
		<th class="right" style="width:10em">Gathering Name</th>
		<td><input type="text" id="add-name" style="width:20em;margin-left:5px" /></td>
		<td rowspan="2" class="right">
			<button class="cpn-button" id="btn-calendar" style="padding:1em">Add Gathering</button>
		</td>
	</tr>
	<tr>
		<th class="right">Gathering Location</th>
		<td><input type="text" id="add-location" style="width:20em;margin-left:5px" /></td>
	</tr>
</table>


<div id="add-calendar" style="margin-top:5px"></div>

<script>
$('#add-calendar').fullCalendar({
	theme: true,
	header: { left:'', center:'', right:'' },
	defaultDate: '[event.event_start;date='Y-m-d']',
	editable: false,
	defaultView: 'agendaWeek',
	slotDuration: '00:15:00',
	height: 330,
	allDaySlot: false,
	firstDay: 3,
	scrollTime: '11:00:00',
	timezone: false,

	events: [{
		title: 'Time Block',
		start: '[event.event_start;date='Y-m-d';ope=add:-86400] 12:00:00',
		end: '[event.event_start;date='Y-m-d';ope=add:-86400] 13:00:00',
		editable:true
	}]
});


$('#btn-calendar').click(function(){
	$(this).prop('disabled', true);

	var events = $('#add-calendar').fullCalendar('clientEvents')[0];
	events.start.stripZone();
	events.end.stripZone();

	var gathering = {
		id: [event.event_id],
		name: $('#add-name').val().trim(),
		location: $('#add-location').val().trim(),
		start: events.start.toISOString(),
		end: events.end.toISOString(),
	}

	if (!gathering.name  ||  !gathering.location) {
		alert('Both "Name" and "Location" are required!')
		$(this).prop('disabled', false);
		return;
	}

	$.post('[afurl.base]/event/gatherings/insert', gathering, redirect);
});
</script>
