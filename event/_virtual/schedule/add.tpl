<table id="add-panel-table">

	<tr>
		<th class="left">Start:</th>
		<td>
			<input type="hidden" name="start" value="[panel.start]" />
			[panel.start;date=r]
		</td>
	</tr>

	<tr>
		<th class="left">End:</th>
		<td>
			<input type="hidden" name="end" value="[panel.end]" />
			[panel.end;date=r]
		</td>
	</tr>

	<tr>
		<th class="left">Type:</th>
		<td>
			<select name="type" style="width:500px">
				<option value="[type.val;block=option]">
					[type.val]
				</option>
			</select>
		</td>
	</tr>

	<tr>
		<th class="left">Room:</th>
		<td>
			<select id="add-panel-table-room" name="room" style="width:500px">
				<option value="[rooms.schedule_room_id;block=option]"
					[rooms.schedule_room_id;selected=[room]]>
					[rooms.schedule_room_name]
				</option>
			</select>
		</td>
	</tr>

	<tr>
		<th class="left">Name:</th>
		<td><input type="text" name="name" id="add-panel-table-name" style="width:500px" /></td>
	</tr>

	<tr>
		<th class="left">Text:</th>
		<td><textarea name="text" style="width:500px;height:8em"></textarea></td>
	</tr>

	<tr>
		<th class="left">Restrict:</th>
		<td>
			<label style="margin-right:20px"><input type="radio" name="restrict" value="" checked /> None</label>
			<label style="margin-right:20px">
				<input type="radio" name="restrict" value="[restrict.val]" /> [restrict.val;block=label]
			</label>
		</td>
	</tr>

	<tr>
		<th class="left top">Conflict:</th>
		<td><label><input type="checkbox" name="conflict" value="1" checked /> Panel conflicts with other panels</label></td>
	</tr>

</table>


<script>
var addpanel = function() {
	$.post(
		'[afurl.base]/event/[event.event_name;f=urlname]/schedule/insert',
		$('#add-panel-table').afSerialize(),
		function(id) {
			$('#panel-calendar').fullCalendar('renderEvent', {
				id:			id.trim(),
				title:		$('#add-panel-table-name').val(),
				start:		'[panel.start;safe=js]',
				end:		'[panel.end;safe=js]',
				resources:	$('#add-panel-table-room').val(),
			}, true);
			popdown();
		}
	);
};


$('#add-panel-table-name').focus().keypress(function(e) {
	if (e.which != 13) return;
	addpanel();
});

popbuttons({'Add Panel': addpanel}, true);
</script>