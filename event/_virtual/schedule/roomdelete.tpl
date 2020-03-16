<pre>
	Are you sure you want to delete this room for your convention?

	NOTE: There is NO UNDO!
	WARNING: ALL scheduled items for this room will also be deleted!
</pre>


<div class="center">
	<button id="cpn-room-delete" class="cpn-button">Delete</button>
</div>

<script>
$(function(){
	$('#cpn-room-delete').click(function(){
		$('#popup-window').load(
			'[afurl.all]',
			{ id: [room.schedule_room_id], confirm:1 }
		);
	});
});
</script>
