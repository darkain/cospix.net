<style>#add-calendar .ui-widget-header{font-size:1em;}</style>

<div id="add-calendar"></div>

<script>
$('#add-calendar').fullCalendar({
	theme: true,
	header: { left:'', center:'', right:'' },
	defaultDate: '[gathering.gathering_start;date='Y-m-d']',
	editable: false,
	defaultView: 'agendaWeek',
	slotDuration: '00:15:00',
	height: 390,
	allDaySlot: false,
	firstDay: 3,
	scrollTime: '[gathering.gathering_start;date='Y-m-d G:i:s';ope=add:-3600]',
	timezone: false,

	events: [{
		title: 'Time Block',
		start: '[gathering.gathering_start;date='Y-m-d G:i:s']',
		end: '[gathering.gathering_end;date='Y-m-d G:i:s']',
		editable:true
	}]
});


popbuttons([{
	text:'Save Gathering',
	click:function() {
		var events = $('#add-calendar').fullCalendar('clientEvents')[0];
		events.start.stripZone();
		events.end.stripZone();

		$.post('[afurl.base]/event/gatherings/time', {
			id:[gathering.gathering_id],
			start: events.start.toISOString(),
			end: events.end.toISOString(),
		}, refresh);
	}
}], true);
</script>
