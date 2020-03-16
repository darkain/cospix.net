<div id="gmap-canvas-parent"><div id="gmap-canvas"></div></div>
<div id="cpn-map-menu"><div id="cpn-map-menu-container"></div></div>

[onload;file=[af.config.root]/map.tpl]

<script>
$('html,body').css('overflow-y', 'hidden');
if (History.getHash()) {
	try {
		var str  = History.getHash().replace('?', '').split('&');
		var lat = str[0].substr( str[0].indexOf('=')+1 );
		var lon = str[1].substr( str[1].indexOf('=')+1 );
		gmapOptions.zoom = parseInt(str[2].substr( str[2].indexOf('=')+1 ));
		gmapOptions.center = new google.maps.LatLng(lat, lon);
	} catch(err) {
		gmapOptions.zoom = [gmap.zoom];
		gmapOptions.center = new google.maps.LatLng([gmap.lat], [gmap.lon]);
	}
} else {
	gmapOptions.zoom = [gmap.zoom];
	gmapOptions.center = new google.maps.LatLng([gmap.lat], [gmap.lon]);
}


$(function(){
	var gmapCanvas = document.getElementById('gmap-canvas');
	if (gmapCanvas) {
		gmap = new google.maps.Map(gmapCanvas, gmapOptions);
		google.maps.event.addListener(gmap, 'click', function() {
			if (gmapInfoWindow) gmapInfoWindow.close();
		});

		gmap.controls[google.maps.ControlPosition.RIGHT_TOP].push(
			$('<div class="gmap-cpn-buttons"><a href="[afurl.base]/profile/map">User Profiles</a></div>').get(0)
		);
	}

[map;safe=no]

	if ('[af.config.root]' === '_cospix') {
		google.maps.event.addListener(gmap, 'idle', function() {
			var url = '?lat=' + gmap.getCenter().toString() + '&zoom=' + gmap.getZoom();
			url = url.replace(/\(|\)| /g, '').replace(',', '&lon=');
			History.replaceState({}, document.title, '[router.parts.path]'+url);
			$('.gmap-cpn-buttons a').attr('href', '[afurl.base]/profile/map/'+url);
			$.get(
				'[router.parts.path]/bounds',
				{b:gmap.getBounds().toString()},
				function(data) { $('#cpn-map-menu div').html(data); }
			);
		});
	}
})
</script>
