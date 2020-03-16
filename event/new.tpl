<article class="cpn-default">

	<h1 class="cpn-header">Add A New Event</h1>

	<form action="[afurl.base]/event/add" method="post"><div>

		<table><tr><td style="vertical-align:top; padding:1em" rowspan="2">

			<b>Name</b><br />
			<input value="[new.event_name]" type="text" name="name" style="width:20em" /><br /><br />

			<b>Location <i>(City, State)</i></b><br />
			<input value="[new.event_location]" type="text" name="location" style="width:20em" /><br /><br />

			<b>Venue</b>
			<span>[<a target="_blank" href="https://www.google.com/search?q=[new.event_venue;magnet=span],%20[new.event_location;magnet=span]">search</a>]</span>
			<br />
			<input value="[new.event_venue]" type="text" name="venue" style="width:20em" /><br /><br />

			<b>Web Site</b><br />
			<input value="[new.event_website]" type="text" name="site" style="width:20em" /><br /><br />


			<b>Twitter</b> <i>(optional)</i><br />
			@<input value="[new.event_twitter]" type="text" name="twitter" style="width:20em" /><br /><br />

			<span>
				<b>Group: </b> [new.event_id;magnet=span] - [new.group_name]
				<input value="[new.event_id]" type="hidden" name="group" style="width:20em" /><br /><br />
			</span>



		</td><td style="vertical-align:top; padding:1em">
			<div id="new-event-from"><b>Start Date: <input type="text" name="start" id="new-event-start" value="[new.event_start;date='Y-m-d']" style="width:8em" /></b></div>
		</td><td style="vertical-align:top; padding:1em">
			<div id="new-event-to"><b>End Date: <input type="text" name="end" id="new-event-end" value="[new.event_end;date='Y-m-d']" style="width:8em" /></b></div>
		</td></tr>

		<tr><td colspan="2" class="center">
			<input type="submit" class="button" value="Create Event" style="font-size:30px; height:50px; width:200px" />
		</td></tr>

		</table>

	</div></form>

</article>

<script>
$(function() {
	$('#new-event-from').datepicker({
		changeMonth: true,
		numberOfMonths: 1,
		showOtherMonths: true,
		selectOtherMonths: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		defaultDate: '[new.event_start;date='Y-m-d']',
		onSelect: function(selectedDate) {
			$('#new-event-to').datepicker('option', 'minDate', selectedDate);
			$('#new-event-start').val(selectedDate);
		}
	});

	$('#new-event-to').datepicker({
		changeMonth: true,
		numberOfMonths: 1,
		showOtherMonths: true,
		selectOtherMonths: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		defaultDate: '[new.event_end;date='Y-m-d']',
		onSelect: function(selectedDate) {
			$('#new-event-from').datepicker('option', 'maxDate', selectedDate);
			$('#new-event-end').val(selectedDate);
		}
	});
});
</script>
