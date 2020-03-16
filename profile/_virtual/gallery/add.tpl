<figure style="width:300px"
	class="cpn-prometheus-item cpn-discover-tag cpn-no-drag"
	id="cpn-add-photo">
	<a>
		<img src="[afurl.static]/thumb2/add.svg" />
		<figcaption>
			<div class="cpn-discover-text">
				<span>Upload Photos</span>
			</div>
		</figcaption>
	</a>
</figure>

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
