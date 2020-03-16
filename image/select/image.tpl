<div class="center">
	<button class="cpn-button" style="font-size:20px;padding:10px 15px" id="cpn-selected-image">
		Use This Image
	</button>
	<br/><br/>
	<img src="[image.img]" />
</div>

<script>
$('#cpn-selected-image').click(function(){
	$(this).closest('.ui-dialog-content').load(
		'[afurl.base]/featured/submit',
		{id: '[image.hash]'}
	);
});
</script>
