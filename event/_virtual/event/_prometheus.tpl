<section class="cpn-profile-body">

	<div class="prometheus-profile-flow">

		<div>
			<a href="[afurl.base]/event/[event.event_name;f=urlname]/attendees">
				[onshow;svg=static/thumb2/profile.svg]
				<b>Attendees</b>
			</a>
		</div>

		<div>
			<a href="[afurl.base]/event/[event.event_name;f=urlname]/galleries">
				[onshow;svg=static/thumb2/camera.svg]
				<b>Galleries</b>
			</a>
		</div>

		<div>
			<a target="_blank" href="https://maps.apple.com/?sll=[event.event_lat],[event.event_lon]&amp;address=[event.event_venue;f=urlname]&amp;t=m&amp;z=16">
				[onshow;svg=static/thumb2/convention.svg]
				<b>Map ➥</b>
			</a>
		</div>

		<div>
			<div id="ui-event-date"></div>
			<div id="ui-event-dateold">
				<h3 class="cpn-header">Dates</h3>
				<div>
					Start Date: <time itemprop="startDate" datetime="[event.event_start;date='Y-m-d']">[event.event_start;date='Y-m-d']</time><br />
					End Date: <time itemprop="endDate" datetime="[event.event_end;date='Y-m-d']">[event.event_end;date='Y-m-d']</time>
				</div>
			</div>
			<span id="cpn-event-time">
				Local Time: <br/>[event.localtime;noerr;magnet=(div)]
			</span>
		</div>

		<div>
			<div class="event-weather">
				<iframe src="//forecast.io/embed/#lat=[event.event_lat]&amp;lon=[event.event_lon]&amp;color=%2300C8E6&amp;units=us" sandbox="allow-scripts allow-same-origin"></iframe>
			</div>
		</div>

		<div class="prometheus-insert"></div>
		<div class="prometheus-insert"></div>
		<div class="prometheus-insert"></div>
		<div class="prometheus-insert"></div>
	</div>

	<div style="width:100%; padding-bottom:50%; height:0; position:relative">
		<iframe style="width:100%;height:100%;position:absolute" src="//www.youtube.com/embed/[youtube.youtube_id;magnet=div]?rel=0&amp;autoplay=0" style="border:0" allowfullscreen></iframe>
	</div>

	<iframe style="opacity:0;height:1px" src="[afurl.base]/event/[event.event_name;f=urlname]/map">
		[onshow;block=iframe;when [profile.edit]=1]
		[onshow;block=iframe;when [event.event_lat]=0]
		[onshow;block=iframe;when [event.event_lon]=0]
	</iframe>
</section>

<script>
cpnUpdateTime = function(){
	var ampm	= 'AM';
	var tm		= new Date();
	var tz		= tm.getTimezoneOffset() / 60;
	var h		= (tm.getHours() + tz + [event.timezone]) % 24;
	var m		= tm.getMinutes();
	var s		= tm.getSeconds();

	if (h == 0) h = 12
	if (h > 12) { h -= 12; ampm = 'PM'; }

	$('#cpn-event-time').html(
		'Local Time: ' + h + ':' + (m<10?'0'+m:m) + ':' + (s<10?'0'+s:s) + ' ' + ampm
	);
}


$(function() {
	$('#ui-event-dateold').hide();
	$('#ui-event-date').show().datepicker({
		hideIfNoPrevNext: true,
		minDate: '[event.event_start_string]',
		maxDate:'[event.event_end_string]',
		dayNamesMin:['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
	});

	$('.cpn-fahrenheit').click(function(){
		$(this).hide();
		$('.cpn-celsius').show();
		var url = $('#forecast_embed').attr('src').replace('=ca', '=us')
		$('#forecast_embed').attr('src','');
		setTimeout(function(){$('#forecast_embed').attr('src',url);},1);
	});


	$('.cpn-celsius').click(function(){
		$(this).hide();
		$('.cpn-fahrenheit').show();
		var url = $('#forecast_embed').attr('src').replace('=us', '=ca')
		$('#forecast_embed').attr('src','');
		setTimeout(function(){$('#forecast_embed').attr('src',url);},1);
	});

	setInterval(cpnUpdateTime, 1000);
	cpnUpdateTime();
});
</script>
