<a	class="cpn-prometheus-item cpn-discover-tag cpn-no-drag"
	id="cpn-add-photo"
	style="min-width:300px">
	<figure>
		[onshow;svg=static/thumb2/add.svg]
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
