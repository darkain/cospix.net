<a	style="width:300px; flex-grow:0"
	class="cpn-prometheus-item cpn-discover-tag cpn-no-drag"
	id="cpn-add-photo">
	<figure>
		<img src="[afurl.static]/thumb2/add.svg" />
		<figcaption>
			<div class="cpn-discover-text">
				<span>Upload Photos</span>
			</div>
		</figcaption>
	</figure>
</a>

<script>
$(function(){
	if (typeof afDropzone !== 'undefined') {
		afDropzone(
			'form.prometheus-dropzone',
			[afurl.upload;safe=json],
			'#cpn-add-photo',
			false,
			300
		);
	}
});
</script>
