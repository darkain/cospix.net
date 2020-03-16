<div id="gmap-container">
	<div id="gmap-canvas"></div>
</div>

<style>
#gmap-container {
	position:fixed;
	top:0;
	right:0;
	bottom:0;
	left:200px;
	padding-top:82px;
}

#gmap-canvas {
	width:100%;
	height:100%;
}
</style>

<script>
$(function() {
	window.scrollTo(0,0);
	$('html,body').css('overflow', 'hidden');
	$('.cpn-footer').hide();

	gmapOptions.zoom = [gmap.zoom;ifempty=12];
	gmapOptions.center = new google.maps.LatLng([gmap.lat;ifempty=0], [gmap.lon;ifempty=0]);

	var gmapCanvas = $('#gmap-canvas').get(0);
	if (gmapCanvas) {
		gmap = new google.maps.Map(gmapCanvas, gmapOptions);
		google.maps.event.addListener(gmap, 'click', function() {
			if (gmapInfoWindow) gmapInfoWindow.close();
		});
	}

	gmapMarkers = new Array();
	[jsmap.3;safe=no]
});
</script>

<script>
[onshow;block=script;when '[event.event_lat]'='0']
[onshow;block=script;when '[event.event_lon]'='0']
$(function() {
	gmapGeolocate(
		$('.cpn-profile-social span').text().trim(),
		'[afurl.base]/event/geolocate/[event.event_id]'
	);
});
</script>
