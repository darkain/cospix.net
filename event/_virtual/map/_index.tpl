<div id="cpn-event-map-hack" style="padding-bottom:5px"><div></div></div>
<div id="gmap-canvas"></div>

<script>
$(function() {
	window.scrollTo(0,0);
	$('html,body').css('overflow', 'hidden');
	$('.cpn-footer').hide();

	$(window).resize(function(){
		$('#gmap-canvas').height( $('#cpn-event-map-hack div').height() );
	});

	$(window).resize();

	gmapOptions.zoom = [gmap.zoom;ifempty=12];
	gmapOptions.center = new google.maps.LatLng([gmap.lat;ifempty=0], [gmap.lon;ifempty=0]);

	var gmapCanvas = document.getElementById('gmap-canvas');
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
