<form id="frm-edit-profile"><div>
	<h3>Edit Social Links</h3>
	<input type="hidden" name="id" value="[profile.user_id]" />

	<div class="frm-social-links">
		<table>
			<tr>
				<td>
					<img src="[afurl.static]/social2/[social.$;block=tr;f=urlname].svg" alt="[social.$]" title="[social.$]" />
				</td>
				<td style="padding:5px">
					[social.$]
				</td>
				<td>
					<input type="text" name="social[[social.$]]" value="[social.val]" style="width:30em" />
				</td>
			</tr>
		</table>

		<button class="cpn-button">Save</button>
	</div>

</div></form>

<script>
$(function() {
	$('#frm-edit-profile button').click(function(event){
		event.preventDefault();
		$.post(
			'[afurl.base]/profile/links/save',
			$('#frm-edit-profile').serialize(),
			refresh
		);
	});
});
</script>

<style>
#frm-edit-profile {
	text-shadow:0 0 1px #fff, 0 0 3px #fff, 0 0 5px #fff, 0 0 10px #fff, 0 0 20px #fff;
	background:rgba(255,255,255,0.75);
	padding:1em;
}

#frm-edit-profile h3 {
	padding:0 0 0.5em 0.3em;
}

#frm-edit-profile input {
	padding:0.3em 0.4em;
}

#frm-edit-profile button {
	width:100%;
	padding:0.5em;
	font-size:1.5em;
	margin-top:1em;
}
</style>
