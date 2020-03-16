<table id="add-panel-table">

	<tr>
		<th class="left">Start:</th>
		<td><input type="text" name="start" value="[panel.schedule_panel_start;date=Y-m-d H:i]" /></td>
	</tr>

	<tr>
		<th class="left">End:</th>
		<td><input type="text" name="end" value="[panel.schedule_panel_end;date=Y-m-d H:i]" /></td>
	</tr>

	<tr>
		<th class="left">Type:</th>
		<td>
			<select name="type" style="width:500px">
				<option value="[type.val;block=option]" [type.val;selected=[panel.schedule_panel_type]]>
					[type.val]
				</option>
			</select>
		</td>
	</tr>

	<tr>
		<th class="left">Room:</th>
		<td>
			<select name="room" style="width:500px">
				<option value="[room.schedule_room_id;block=option]" [room.schedule_room_id;selected=[panel.schedule_room_id]]>
					[room.schedule_room_name]
				</option>
			</select>
		</td>
	</tr>

	<tr>
		<th class="left">Name:</th>
		<td>
			<input type="hidden" name="id" value="[panel.schedule_panel_id]" />
			<input type="text" name="name" id="add-panel-table-name" style="width:500px" value="[panel.schedule_panel_name]" />
		</td>
	</tr>

	<tr>
		<th class="left top">Text:</th>
		<td><textarea name="text" style="width:500px">[panel.schedule_panel_text;safe=textarea]</textarea></td>
	</tr>

	<tr>
		<th class="left">Restrict:</th>
		<td>
			<label style="margin-right:20px">
				<input type="radio" name="restrict" value="" [panel.schedule_panel_restricted;checked=''] /> None
			</label>
			<label style="margin-right:20px">
				<input type="radio" name="restrict" value="[restrict.val]" [panel.schedule_panel_restricted;checked=[restrict.val]] /> [restrict.val;block=label]
			</label>
		</td>
	</tr>

	<tr>
		<th class="left top">Conflict:</th>
		<td><label><input type="checkbox" name="conflict" value="1" [panel.schedule_panel_conflict;checked=1] /> Panel conflicts with other panels</label></td>
	</tr>

</table>


<script>
var savepanel = function() {
	$.post(
		'[afurl.base]/[event.event_name;f=urlname]/virtual/schedule/save',
		$('#add-panel-table').afSerialize(),
		function(name) {
			var event = $('#panel-calendar').fullCalendar(
				'clientEvents',
				[panel.schedule_panel_id]
			)[0];

			event.title = name;

			$('#panel-calendar').fullCalendar('updateEvent', event);

			popdown();
		}
	);
};


$('#save-panel-table-name').focus().keypress(function(e) {
	if (e.which != 13) return;
	savepanel();
});

popbuttons({
	'Save Panel': savepanel,
	'Delete Panel': function() {
		if (!confirm('ARE YOU SURE TO BE DELETING THIS PANEL?')) return;
		$.post('[afurl.base]/event/[event.event_name;f=urlname]/schedule/delete', {
			id: [panel.schedule_panel_id],
		}, function(name) {
			$('#panel-calendar').fullCalendar('removeEvents', [panel.schedule_panel_id]);
			popdown();
		});
	}
}, true);
</script>