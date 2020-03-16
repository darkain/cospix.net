<form id="frm-edit-dates"><div>

	<div style="float:right; font-size:0.8em">
		<input type="hidden" name="start" value="[event.event_start;date='Y-m-d']" id="start" />
		<input type="hidden" name="end" value="[event.event_end;date='Y-m-d']" id="end" />
		<input type="hidden" name="id" value="[event.event_id]" />
		<div id="from" class="center"><b>Start Date</b></div>
		<div id="to" class="center"><b>End Date</b></div>

		<div>
			<label><input name="canceled" type="checkbox" />
				[event.details.canceled;block=input;att=checked;atttrue=1;noerr]
				Canceled?
			</label>
		</div>
	</div>

	<div style="margin-right:200px" class="frm-social-links">
		<table>
			<tr>
				<td><img src="[afurl.static]/social2/home.svg" title="Home" alt="Home" /></td>
				<td style="padding:5px">Home</td>
				<td><input type="text" name="website" value="[event.event_website]" style="width:30em" /></td>
			</tr>

			<tr>
				<td><img src="[afurl.static]/social2/twitter.svg" title="Twitter" alt="Twitter" /></td>
				<td style="padding:5px">@</td>
				<td><input type="text" name="twitter" value="[event.event_twitter]" /></td>
			</tr>

			<tr>
				<td><img src="[afurl.static]/social2/[social.$;block=tr;f=urlname].svg" title="[social.$]" alt="[social.$]" /></td>
				<td style="padding:5px">[social.$]</td>
				<td><input type="text" name="social[[social.$]]" value="[social.val]" style="width:30em" /></td>
			</tr>
		</table>
	</div>

</div></form>


<script>
$(function() {
	$('#from').datepicker({
		changeMonth: true,
		numberOfMonths: 1,
		showOtherMonths: true,
		selectOtherMonths: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		defaultDate: '[event.event_start;date='Y-m-d']',
		onSelect: function(selectedDate) {
			$('#to').datepicker('option', 'minDate', selectedDate);
			$('#start').val(selectedDate);
		}
	});

	$('#to').datepicker({
		changeMonth: true,
		numberOfMonths: 1,
		showOtherMonths: true,
		selectOtherMonths: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		defaultDate: '[event.event_end;date='Y-m-d']',
		onSelect: function(selectedDate) {
			$('#from').datepicker('option', 'maxDate', selectedDate);
			$('#end').val(selectedDate);
		}
	});

	$('#to').datepicker('option', 'minDate', '[event.event_start;date='Y-m-d']');
	$('#from').datepicker('option', 'maxDate', '[event.event_end;date='Y-m-d']');

	popbuttons([{
		text:'Save Event',
		click:function() {
			$.post(
				'[afurl.base]/event/links/save',
				$('#frm-edit-dates').serialize(),
				refresh
			);
		}
	}], true);
});
</script>
