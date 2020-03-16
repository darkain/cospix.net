<article class="cpn-default">
	<h1 class="cpn-header">Admin</h1>
	<section class="cpn-default larger">
		<b>Event ID:</b> [event.event_id]<br />
		<b>Group ID:</b> [event.event_group]<br />
		<span><b>Added By:</b> <a href="[afurl.base]/[event.added_by.user_id;noerr]">[event.added_by.user_name;noerr;magnet=span]</a></span>

		<br/><br/><br/>
		Assign to a new group:<br/>
		<input type="text" id="txt-group" />
		<button id="btn-group" class="cpn-button">Assign</button>
	</section>
</article>

<script>$(function(){
	$('#btn-group').click(function(){
		$.post('[afurl.base]/event/set/group', {
			id: [event.event_id],
			group: $('#txt-group').val(),
		}, function(data){alert(data);});
	});
});</script>
