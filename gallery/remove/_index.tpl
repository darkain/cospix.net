<div class="center">

	<div style="font-size:25px; text-align:justify">
		Are you SURE you want to delete this gallery from your profile?
		There is NO undo action after this point. All associated information
		with this gallery will also be removed from your profile.
	</div>

	<br /><br />
	<button style="padding:1em;font-size:30px" onclick="popdown()">CANCEL</button>
	<br /><br />
	<button id="cpn-confirm-delete-gallery">delete</button>

</div>

<script>
$('#cpn-confirm-delete-gallery').click(function(){
	$.post(
		'[afurl.base]/gallery/remove',
		{id:'[gallery.gallery_id]', confirm:1},
		function() {
			redirect('[afurl.base]/[gallery.user_url;ifempty='[gallery.user_id]']/galleries');
		}
	);
});
</script>
