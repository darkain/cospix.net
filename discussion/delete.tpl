<div class="largest center">
	Are you SURE you want to delete this discussion?
	<div style="font-size:0">
		<button class="cpn-button" style="padding:1em; font-size:20px; margin:1em" id="cpn-delete-discussion">DELETE</button>
		<button class="cpn-button" style="padding:1em; font-size:20px; margin:1em" onclick="popdown()">CANCEL</button>
	</div>
</div>

<script>
	poptitle('Delete This Discussion?');

	$('#cpn-delete-discussion').click(function(){
		$.post('[afurl.base]/discussion/delete',{
			id: [post.discussion_id], confirm: 1
		}, refresh);
	});
</script>
