<ul>
	<li class="button" style="margin:1em;font-size:1.5em">
		<a style="display:block" href="[afurl.base]/admin/group/[group.group_type_id]">
			[group.group_type_name;block=li]
		</a>
	</li>
</ul>


<input type="text" name="label" id="newgroup" />
<button id="btnnewgroup">Create Group</button>

<script>
$('#btnnewgroup').click(function(){
	$.post(
		'[afurl.base]/admin/group/create',
		$('#newgroup').serialize(),
		refresh
	);
});
</script>
