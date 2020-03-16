<style>
.prometheus-profile-flow {
	margin:10px -10px;
	display:flex;
	flex-flow:row wrap;
}

.prometheus-profile-flow>div {
	width:calc(25%-20px);
	min-width:325px;
	min-height:280px;
	margin:10px;
	flex-grow:1;
	flex-basis:0;
	background:#fff;
	box-shadow:0 0 10px #000;
}

.prometheus-profile-flow>div>div,
.prometheus-profile-flow>div>a {
	min-width:325px;
	width:100%;
	height:300px;
	margin:auto;
	overflow:hidden;
	text-align:center;
	line-height:1em;
	display:block;
	color:#4F4C4C;
}

.prometheus-profile-flow svg {
	margin:auto;
	height:70%;
}

.prometheus-profile-flow>div>a:hover {
	color:#00C8E6;
}


.prometheus-profile-flow>div>a:hover svg path {
	fill:#00C8E6 !important;
}

.prometheus-profile-flow b {
	font-size:4em;
	display:block;
	text-align:center;
	width:100%;
}


.event-weather {
	min-width:325px;
	max-width:325px;
	width:325px;
	padding-top:80px;
	overflow:hidden;
	height:243px;
	min-height:243px;
	max-height:243px;
}

.event-weather iframe {
	border:0;
	height:500px;
	width:500px;
	margin-top:-45px;
	margin-left:-180px;
}

#cpn-event-time {
	display:block;
	font-size:1.7em;
	text-align:center;
}

#ui-event-date {
	height:auto;
	margin-top:1.5em;
}

#ui-event-date table {
	width:322px;
	margin:0 auto;
}

#ui-event-date .ui-datepicker,
#ui-event-date .ui-widget-content,
#ui-event-date .ui-datepicker-header {
	background:none;
	border-radius:none;
	border:none;
	width:100%;
}

#ui-event-date .ui-datepicker-header {
	padding:0;
	margin:0;
	font-size:2em;
	font-weight:normal;
}

#ui-event-date .ui-datepicker th {
	padding:0;
}

.cpn-profile-body .cpn-map-list {
	display:flex;
	flex-flow:row wrap;
	margin:0 -10px 10px -10px;
}

.cpn-profile-body .cpn-map-list li {
	flex-grow:1;
	flex-basis:0;
	width:calc(25%-20px);
	margin:10px;
	min-width:325px;
}
</style>

<section class="cpn-profile-body">

	<div class="prometheus-profile-flow">

		<div>
			<a href="[afurl.base]/event/[event.event_name;safe=url]/attendees">
				[onshow;svg=static/thumb2/profile.svg]
				<b>Attendees</b>
			</a>
		</div>

		<div>
			<a href="[afurl.base]/event/[event.event_name;safe=url]/galleries">
				[onshow;svg=static/thumb2/camera.svg]
				<b>Galleries</b>
			</a>
		</div>

		<div>
			<a target="_blank" href="https://maps.apple.com/?sll=[event.event_lat],[event.event_lon]&amp;address=[event.event_venue;safe=url]&amp;t=m&amp;z=16">
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
				<iframe src="//forecast.io/embed/#lat=[event.event_lat]&amp;lon=[event.event_lon]&amp;color=%2300C8E6&amp;units=us" sandbox="allow-scripts allow-same-origin allow-popups"></iframe>
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
