<div data-id="[city.city_id;block=div]">
	<strong>[city.city_accent], [city.region_name]</strong>
	<em>[city.country_name]</em>
</div>

<div class="prometheus-insert"></div>
<div class="prometheus-insert"></div>
<div class="prometheus-insert"></div>
<div class="prometheus-insert"></div>
<div class="prometheus-insert"></div>

<script>
$(function() {
	$('#city-search-display>div').click(function(){
		$.post(
			'[afurl.base]/settings/cospix/set/location',
			{location: $(this).data('id')},
			refresh
		);
	});
});
</script>
